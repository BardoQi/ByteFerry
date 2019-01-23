<?php
/**
 * OutputStream class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Stream;

use ByteFerry\Stream\StreamIo;
//use ByteFerry\Utils\NumberUtils;
use ByteFerry\Exceptions\InvalidArgumentException;

/**
 * Class OutputStream
 * @package ByteFerry\Stream
 */
class OutputStream extends StreamIo
{
    /**
     * Methods of primitive types
     */
    /**
     * alias of method writeInt8()
     * @method writeByte()
     */
    /**
     * alias of method writeInt8()
     * @method writeChar()
     */
    /**
     * alias of method writeInt16()
     * @method writeShort()
     */
    /**
     * alias of method writeInt16()
     * @method writeWord()
     */
    /**
     * alias of method writeInt16()
     * @method writeInt()
     */
    /**
     * alias of method writeInt32()
     * @method writeDword()
     */
    /**
     * alias of method writeInt64()
     * @method writeLong()
     */
    /**
     * alias of method insertInt8()
     * @method insertByte()
     */
    /**
     * alias of method insertInt8()
     * @method insertChar()
     */
    /**
     * alias of method insertInt16()
     * @method insertShort()
     */
    /**
     * alias of method insertInt16()
     * @method insertWord()
     */
    /**
     * alias of method insertInt32()
     * @method insertInt()
     */
    /**
     * alias of method insertInt32()
     * @method insertDword()
     */
    /**
     * alias of method insertInt64()
     * @method insertLong()
     */
    /**
     * alias of method putInt8()
     * @method putByte()
     */
    /**
     * alias of method putInt8()
     * @method putChar()
     */
    /**
     * alias of method putInt16()
     * @method putShort()
     */
    /**
     * alias of method putInt16()
     * @method putWord()
     */
    /**
     * alias of method putInt32()
     * @method putInt()
     */
    /**
     * alias of method putInt32()
     * @method putDword()
     */
    /**
     * alias of method putInt64()
     * @method putLong()
     */
    /**
     * alias of method replaceInt8()
     * @method replaceByte()
     */
    /**
     * alias of method replaceInt8()
     * @method replaceChar()
     */
    /**
     * alias of method replaceInt16()
     * @method replaceShort()
     */
    /**
     * alias of method replaceInt16()
     * @method replaceWord()
     */
    /**
     * alias of method replaceInt32()
     * @method replaceInt()
     */
    /**
     * alias of method replaceInt32()
     * @method replaceDword()
     */
    /**
     * alias of method replaceInt64()
     * @method replaceLong()
     */
    /**
     * alias of method replaceInt64()
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
     */
    /**
     * alias of method skipInt64()
     * @method skipInt64()
     */

    /**
     * Stream constructor.
     * @param resource $stream Stream resource to wrap.
     * @param array $options Associative array of options.
     */
    protected function __construct($stream, $options = [])
    {
        parent::__construct($stream, $options);
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
        return new static($stream, $options);

    }

    /**
     * Create a new stream based on given string.
     * @param string $stringBuffer
     * @param array $options Additional options
     * @return static
     */
    public static function ofString($stringBuffer = '', $options = []){

        $stream = fopen('php://memory', 'W+b');
        if ($stringBuffer !== '') {
            fwrite($stream, $stringBuffer);
            fseek($stream, 0);
        }
        return new static($stream, $options);

    }

    /**
     * Create a new stream based on given resource.
     * @param resource $resource
     * @param array $options Additional options
     * @return static
     */
    public static function ofResource($resource, $options = []){

        return new static($resource, $options);

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
        return new static($stream, $options);

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
        return new static($stream, $options);

    }

    /**
     * Create a new stream based on given object.
     * @param object $obj
     * @param array $options Additional options
     * @return static
     */
    public static function ofObject($obj, $options = []){

        if (method_exists($obj, '__toString')) {
            return static::ofString((string)$obj, $options);
        }
        throw InvalidArgumentException::InvalidResourceType();

    }

    /**
     * Write data to stream.
     * @param string $data
     * @param int $length
     * @return int
     */
    public function write($data, $length = null)
    {
        if ($length === null) {
            return fwrite($this->_streamHandle, $data);
        } else {
            return fwrite($this->_streamHandle, $data, $length);
        }
    }

    /**
     * Write array bytes
     * @param $bytes
     * @return int
     */
    public function writeBytes($bytes)
    {
        array_unshift($bytes, 'C*');
        return $this->write(call_user_func_array('pack', $bytes));
    }


    /**
     * Write string data
     * @param string $value
     * @param string|int $length
     * @param string $charset
     * @return int
     */
    public function writeString($value, $length = '*', $charset = null)
    {
        if ($charset) {
            $value = iconv('utf8', $charset, $value);
        } elseif (isset($this->options['charset'])) {
            $value = iconv('utf8', $this->options['charset'], $value);
        }
        return $this->write(pack('A' . $length, $value));
    }



    /**
     * @param $value
     * @return int
     */
    public function writeBool($value)
    {
        return $this->writeInt($value ? 1 : 0, 8);
    }

    /**
     * write a Binary Coded Decimals(8421code)
     * @param $value
     * @return int
     */
    public function writeBcd8421($value){

        $len = strlen($value);
        // 奇数,前补零
        if (($len & 0x1) == 1) {
            $value = "0" . $value;
        }
        $bytes=[];
        for ($i = 0; $i < $len; $i+=2) {
            $high = $value[$i];
            $low = $value[$i+1];
            $bytes[] =  chr(($high << 4) | $low);
        }
        return $this->write($bytes);
    }

    /**
     * @param $value
     * @return int
     */
    public function writeFloat($value)
    {
        $bytes = pack('f', $value);
        return $this->write($bytes);
    }


    /**
     * @param $value
     * @return int
     */
    public function writeDouble($value)
    {
        $bytes = pack('d', $value);
        return $this->write($bytes);
    }


    /**
     * @param $length
     * @return int
     */
    public function writeNull($length)
    {
        return $this->write(pack('x' . $length));
    }


    /**
     * @return void
     */
    public function __destruct()
    {
        parent::close();
    }


    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat32($value)
    {
        $bytes = pack('f', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat32BE($value)
    {
        $this->writeFloat32($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat32LE($value)
    {
        $this->writeFloat32($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat64($value)
    {
        $bytes = pack('d', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat64BE($value)
    {
        $this->writeFloat64($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeFloat64LE($value)
    {
        $this->writeFloat64($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt16($value)
    {
        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        $bytes = pack('s', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt16BE($value)
    {
        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        $bytes = pack('n', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt16LE($value)
    {
        while ($value >= 0x8000) {
            $value -= 0x10000;
        }

        $bytes = pack('v', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt32($value)
    {
        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        $bytes = pack('l', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt32BE($value)
    {
        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        $bytes = pack('N', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt32LE($value)
    {
        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        $bytes = pack('V', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt8($value)
    {
        while ($value >= 0x80) {
            $value -= 0x100;
        }

        $bytes = pack('c', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt8BE($value)
    {
        $this->writeInt8($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeInt8LE($value)
    {
        $this->writeInt8($value);
    }


    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt8($value)
    {
        while ($value > 0xff) {
            $value -= 0x100;
        }

        $bytes = pack('C', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt8BE($value)
    {
        $this->writeUInt8($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt8LE($value)
    {
        $this->writeUInt8($value);
    }


    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt16($value)
    {
        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        $bytes = pack('S', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt16BE($value)
    {
        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        $bytes = pack('n', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt16LE($value)
    {
        while ($value > 0xffff) {
            $value -= 0x10000;
        }

        $bytes = pack('v', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt32($value)
    {
        while ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        $bytes = pack('L', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt32BE($value)
    {
        $bytes = pack('N', $value);

        return $this->write($bytes);
    }

    /**
     * {@inheritdoc}
     *
     * @param float $value The value to write.
     */
    public function writeUInt32LE($value)
    {
        $bytes = pack('V', $value);

        return $this->write($bytes);
    }


}