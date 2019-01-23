<?php
/**
 * InputStream class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Stream;

use ByteFerry\Stream\StreamIo;
use ByteFerry\Utils\NumberUtils;
use ByteFerry\Exceptions\InvalidArgumentException;

/**
 * Class StreamInput
 * @package ByteFerry\Stream
 */
class InputStream extends StreamIo
{
    /**
     * Methods of primitive types
     */
    /**
     * alias of method readInt8()
     * @method readByte()
     */
    /**
     * alias of method readInt8()
     * @method readChar()
     */
    /**
     * alias of method readInt8()
     * @method readShort()
     */
    /**
     * alias of method readInt16()
     * @method readWord()
     */
    /**
     * alias of method readInt16()
     * @method readInt()
     */
    /**
     * alias of method readInt32()
     * @method readDword()
     */
    /**
     * alias of method readInt32()
     * @method readLong()
     */
    /**
     * alias of method skipInt8()
     * @method skipChar()
     */
    /**
     * alias of method skipInt8()
     * @method skipByte()
     */
    /**
     * alias of method skipInt8()
     * @method skipInt8()
     */
    /**
     * alias of method skipInt8()
     * @method skipShort()
     */
    /**
     * alias of method skipInt16()
     * @method skipWord()
     */
    /**
     * alias of method skipInt16()
     * @method skipInt16()
     */
    /**
     * alias of method skipInt32()
     * @method skipInt()
     */
    /**
     * alias of method skipInt32()
     * @method skipInt32()
     */
    /**
     * alias of method skipInt32()
     * @method skipDword()
     */
    /**
     * alias of method skipInt64()
     * @method skipLong()
    /**
     * alias of method skipInt64()
     * @method skipInt64()
     */


    /**
     * Stream constructor.
     * @param resource $stream Stream resource to wrap.
     * @param array $options Associative array of options.
     * @param string $streamType Type of stream.
     */
    protected function __construct($stream, $options = [], $streamType = null)
    {
        parent::__construct($stream, $options,$streamType);
    }

    /**
     * Create a new stream based on the input type.
     * @param mixed $resource Entity body data
     * @param array $options Additional options
     * @return static
     */
    public static function factory($resource = '', $options = [])
    {
        $type = gettype($resource);
        switch ($type) {
            case 'string':
                return static::ofString($resource, $options);
            case 'resource':
                return static::ofResource($resource, $options);
            case 'object':
                return static::ofObject($resource, $options);
        }
        throw InvalidArgumentException::InvalidResourceType($type);
    }

    /**
     * Create a new stream based on given string.
     * @param string $pathFileName
     * @param string $stringBuffer
     * @param array $options Additional options
     * @return static
     */
    public static function ofFile($pathFileName, $stringBuffer = '', $options = []){

        $stream = fopen($pathFileName, 'W+b');
        if ($stringBuffer !== '') {
            fwrite($stream, $stringBuffer);
            fseek($stream, 0);
        }
        return new self($stream, $options,'FILE');

    }

    /**
     * Create a new stream based on given string.
     * @param string $stringBuffer
     * @param array $options Additional options
     * @param string $streamType Type of stream
     * @return static
     */
    public static function ofString($stringBuffer = '', $options = [], $streamType = null){

        $stream = fopen('php://temp', 'r+');
        if ($stringBuffer !== '') {
            fwrite($stream, $stringBuffer);
            fseek($stream, 0);
        }
        if ($streamType == null){
            $streamType  = 'STRING' ;
        }
        return new self($stream, $options,$streamType);

    }

    /**
     * Create a new stream based on given resource.
     * @param resource $resource
     * @param array $options Additional options
     * @return static
     */
    public static function ofResource($resource, $options = []){

        return new self($resource, $options,'RESOURCE');

    }

    /**
     * Create a new stream based on given string.
     * @param string $stringBuffer
     * @param array $options Additional options
     * @return static
     */
    public static function ofTempFile($stringBuffer = '', $options = []){

        $stream = fopen('php://temp', 'W+b');
        if ($stringBuffer !== '') {
            fwrite($stream, $stringBuffer);
            fseek($stream, 0);
        }
        return new self($stream, $options,'TEMP_FILE');

    }

    /**
     * Create a new stream based on given string.
     * @param string $stringBuffer
     * @param array $options Additional options
     * @return static
     */
    public static function ofMemory($stringBuffer = '', $options = []){

        $stream = fopen('php://memory', 'W+b');
        if ($stringBuffer !== '') {
            fwrite($stream, $stringBuffer);
            fseek($stream, 0);
        }
        return new self($stream, $options,'MEMORY');

    }

    /**
     * Create a new stream based on given object.
     * @param object $obj
     * @param array $options Additional options
     * @return static
     */
    public static function ofObject($obj, $options = []){

        if (method_exists($obj, '__toString')) {
            return static::ofString((string)$obj, $options,'OBJECT' );
        }
        throw InvalidArgumentException::InvalidResourceType();

    }

    /**
     * Reads remainder of a stream into a string
     * @param int $length The maximum bytes to read. Defaults to -1 (read all the remaining buffer).
     * @return string a string or false on failure.
     */
    public function read($length = null)
    {
        return stream_get_contents($this->_streamHandle, $length, $this->offset());
    }

    /**
     * Reads $length bytes from an input stream.
     * @param $length
     * @return array|false
     */
    public function readBytes($length)
    {
        $bytes = $this->read($length);
        if ($bytes !== false) {
            return array_values(unpack('C*', $bytes));
        }
        return false;
    }

    /**
     * Read one line from the stream.
     * @param int $length Maximum number of bytes to read.
     * @param string $ending Line ending to stop at. Defaults to "\n".
     * @return string The data read from the stream
     */
    public function readLine($length = null, $ending = "\n")
    {
        if ($length === null) {
            $length = $this->size();
        }
        return stream_get_line($this->_streamHandle, $length, $ending);
    }

    /**
     * Read bytes as string
     * @param int $length
     * @param string $charset
     * @return string
     */
    public function readString($length, $charset = null)
    {
        $bytes = $this->read($length);
        $value = unpack('A' . $length, $bytes)[1];
        if ($charset) {
            $value = iconv($charset, 'utf8', $value);
        } elseif ($this->options['charset']) {
            $value = iconv($this->options['charset'], 'utf8', $value);
        }
        return $value;
    }

    /**
     * @return mixed
     */
    public function readInt8($signed = false){
        $data = $this->read(1);
        if ($signed === false)
            return unpack('C', $data)[1];
        else
            return unpack('c', $data)[1];
    }



    /**
     * @param int $size
     * @param bool $unsigned
     * @return int
     */
    public function readInt($size = 32, $unsigned = true)
    {
        $size = NumberUtils::roundUp($size, 8);
        $data = $this->read($size / 8);
        $value = 0;
        switch ($size) {
            case 8:
                $value = unpack('C', $data)[1];
                break;
            case 16:
                $value = unpack($this->isLittleEndian ? 'v' : 'n', $data)[1];
                break;
            case 24:
                $bytes = unpack('C3', $data);
                if ($this->isLittleEndian) {
                    $value = $bytes[1] | $bytes[2] << 8 | $bytes[3] << 16;
                } else {
                    $value = $bytes[1] << 16 | $bytes[2] << 8 | $bytes[3];
                }
                break;
            case 32:
                $value = unpack($this->isLittleEndian ? 'V' : 'N', $data)[1];
                break;
            case 64:
                $ret = unpack($this->isLittleEndian ? 'V2' : 'N2', $data);
                if ($this->isLittleEndian) {
                    $value = bcadd($ret[1], bcmul($ret[2], 0xffffffff + 1));
                } else {
                    $value = bcadd($ret[2], bcmul($ret[1], 0xffffffff + 1));
                }
                break;
        }
        return $unsigned ? $value : NumberUtils::unsignedToSigned($value, $size);
    }

    /**
     * @return int
     */
    public function readBool()
    {
        return $this->readInt(8);
    }

    /**
     * @return int
     */
    public function readFloat()
    {
        $bytes = $this->read(4);
        return unpack('f', $bytes)[1];
    }

    /**
     * @return int
     */
    public function readDouble()
    {
        $bytes = $this->read(8);
        return unpack('d', $bytes)[1];
    }

    /**
     * read a Binary Coded Decimals(8421code)
     *
     * @param int $byteLength
     * @return string
     */
    public function readBcd8421($byteLength){

        $bytes = $this->read($byteLength);
        $temp = [];
        for ($i = 0; $i < count($bytes); $i++) {
            $temp[] = ((ord($bytes[$i]) & 0xf0) >> 4);
            $temp[] =  (ord($bytes[$i]) & 0x0f);
        }
        return implode("",$temp);
    }

    public function __destruct()
    {
        parent::close();
    }




    /**
     * {@inheritdoc}
     *
     * @return float
     */
    public function readFloat32()
    {
         return $this->readFloat();
    }

    /**
     * {@inheritdoc}
     *
     * @return float
     */
    public function readFloat64()
    {
         return $this->readDouble();
    }


    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt16()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('s', $bytes);

        $value = current($unpacked);

        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt16BE()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('n', $bytes);

        $value = current($unpacked);

        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt16LE()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('v', $bytes);

        $value = current($unpacked);

        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt32()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('L', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt32BE()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('N', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt32LE()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('V', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }



    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt8BE()
    {
        return $this->readInt8();
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readInt8LE()
    {
        return $this->readInt8();
    }


    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt16()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('S', $bytes);

        $value = current($unpacked);

        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt16BE()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('n', $bytes);

        $value = current($unpacked);

        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt16LE()
    {
        $bytes = $this->read(2);

        $unpacked = unpack('v', $bytes);

        $value = current($unpacked);

        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt32()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('L', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt32BE()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('N', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt32LE()
    {
        $bytes = $this->read(4);

        $unpacked = unpack('V', $bytes);

        $value = current($unpacked);

        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt8()
    {
        $bytes = $this->read(1);

        $unpacked = unpack('C', $bytes);

        $result = current($unpacked);

        while ($result > 0xff) {
            $result -= 0x100;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt8BE()
    {
        return $this->readUInt8();
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function readUInt8LE()
    {
        return $this->readUInt8();
    }

}