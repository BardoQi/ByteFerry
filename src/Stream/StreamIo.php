<?php
/**
 * StreamIo class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Stream;

use ByteFerry\Exceptions\InvalidArgumentException;
use ByteFerry\Exceptions\RuntimeException;


/**
 * Class StreamIo
 * @package ByteFerry\Stream
 */
class StreamIo
{
    /**
     * Endianness constant;
     */
    const BIG_ENDIAN = 1;

    /**
     * Endianness constant;
     */
    const LITTLE_ENDIAN = 2;

    /**
     *
     * Endianness constant;
     */
    const LOW_WORD_FIRST = 4;

    /**
     * Endianness constant;
     */
    const HI_WORD_FIRST = 8;

    /**
     * When bytes for little endian are in 'ABCD' order
     * then Big Endian Low Word First is in 'BADC' order
     * Endianness constant;
     */
    const BIG_ENDIAN_LOW_WORD_FIRST = self::BIG_ENDIAN | self::LOW_WORD_FIRST;


    /**
     * @var array
     * example:[
     *  'charset'=>'UTF-8',
     *  'endianness' => 0,
     *  'digit' = 4
     * ]
     */
    public $options = [];

    /**
     * @var bool
     */
    public $machine_endianness = self::BIG_ENDIAN;


    public $system_endianness = self::BIG_ENDIAN;

    /**
     * @var resource
     */
    protected $_stream_handle;


    /**
     * @var
     */
    protected $_functions;


    /**
     * alias of base type
     * @var array
     */
    protected $type_alias = [
        'char'=>'int8',
        'byte'=>'int8',
        'short'=>'int16',
        'word'=>'int16',
        'int'=>'int32',
        'dword'=>'int32',
        'long'=>'int64',
    ];

    private $stream_type;

    private $lengthMap = [
        'char'	=>1,
        'byte'	=>1,
        'int8'	=>1,
        'short'	=>2,
        'word'	=>2,
        'int16'	=>2,
        'int'	=>4,
        'int32'	=>4,
        'dword'	=>4,
        'long'	=>8,
        'int64'	=>8,
        'float32'=>4,
        'float64'=>8
    ];

    /**
     * Stream constructor.
     * @param resource $stream Stream resource to wrap.
     * @param array $options Associative array of options.
     * @param string $stream_type Stream type(RESOURCE,OBJECT,STRING,FILE,TEMP_FILE,MEMORY)
     */
    protected function __construct($stream, $options = [], $stream_type = null)
    {
        if (!is_resource($stream)) {
            throw InvalidArgumentException::StreamMustBeResource();
        }
        $this->_stream_handle = $stream;
        $this->options = $options;
        $this->stream_type = $stream_type;
        $this->system_endianness = $options['endianness'];
        $this->machine_endianness = $this->getMachineEndianness();
    }


    /**
     * Test the Endianness of the machine.
     * @return int
     */
    public function getMachineEndianness() {
        return (unpack('S',"\x01\x00")[1] === 1)? self::LITTLE_ENDIAN : self::BIG_ENDIAN;
    }

    /**
     * Get stream meta data
     * @return array
     */
    public function getMetaData()
    {
        return stream_get_meta_data($this->_stream_handle);
    }

    /**
     * Get stream resource
     * @return resource
     */
    public function getResource()
    {
        return $this->_stream_handle;
    }

    /**
     * Get stream size
     * @return int
     */
    public function size()
    {
        $currPos = ftell($this->_stream_handle);
        fseek($this->_stream_handle, 0, SEEK_END);
        $length = ftell($this->_stream_handle);
        fseek($this->_stream_handle, $currPos, SEEK_SET);
        return $length;
    }

    /**
     * allocate new stream from current stream
     * @param int $length
     * @param bool $skip
     * @return static
     * @throws RuntimeException
     */
    public function allocate($length, $skip = true)
    {
        $stream = fopen('php://memory', 'r+');
        if (stream_copy_to_stream($this->_stream_handle, $stream, $length)) {
            if ($skip) {
                $this->skip($length);
            }
            return new static($stream);
        }
        throw RuntimeException::BufferAllocationFailed();
    }

    /**
     * Copies data from $resource to stream
     * @param resource $resource
     * @param int $length Maximum bytes to copy
     * @return int
     */
    public function pipe($resource, $length = null)
    {
        if (!is_resource($resource)) {
            throw InvalidArgumentException::InvalidResourceType();
        }
        if ($length) {
            return stream_copy_to_stream($resource, $this->_stream_handle, $length);
        } else {
            return stream_copy_to_stream($resource, $this->_stream_handle);
        }
    }

    /**
     * Returns the current position of the file pointer
     * @return int
     */
    public function offset()
    {
        return ftell($this->_stream_handle);
    }

    /**
     * Move the file pointer to a new position
     * @param int $offset
     * @param int $whence Accepted values are:
     *  - SEEK_SET - Set position equal to $offset bytes.
     *  - SEEK_CUR - Set position to current location plus $offset.
     *  - SEEK_END - Set position to end-of-file plus $offset.
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return fseek($this->_stream_handle, $offset, $whence);
    }

    /**
     * Rewind the position of a file pointer
     * @return bool true on success or false on failure.
     */
    public function rewind()
    {
        return rewind($this->_stream_handle);
    }

    /**
     * @param int $length
     * @return int
     */
    public function skip($length=1)
    {
        return $this->seek($length, SEEK_CUR);
    }

    /**
     * @return void
     */
    public function close()
    {
        if (is_resource($this->_stream_handle)) {
            fclose($this->_stream_handle);
        }
    }


    /**
     * Method for calling with alias:
     *
     * @param $method_name
     * @param $args
     * @return mixed
     * @throws RuntimeException
     */
    public function __call($method_name,$args){

        if (method_exists($this,$method_name)){
            return call_user_func_array([$this,$method_name],$args);
        }

        if (preg_match('~^(read|write|insert|put|replace|skip)([A-Z])(.*)$~', $method_name, $matches)) {
            $type = strtolower($matches[2]) . $matches[3];

            if (!isset($this->type_alias[$type])) {
                throw RuntimeException::MethodNotExists($method_name);

            }

            if ($matches[1] == 'skip'){
                $length = $this->lengthMap[$type];
                return $this->skip($length);
            }

            $method = $matches[1] . $type;
            if (method_exists($this,$method)){
                return call_user_func_array([$this,$method],$args);
            }else{
                throw RuntimeException::MethodNotExists($method);

            }
        }
        return false;
    }



    /**
     * Method for calling via program code
     *
     * @param $action
     * @param $type
     * @param $args
     * @return mixed
     */
    public function callByType($action,$type,$args){
        return call_user_func_array([$this,$action. ucfirst($type)],$args);
    }

}