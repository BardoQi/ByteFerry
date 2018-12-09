<?php
/**
 * InputBits class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Bits;


/**
 * Class InputBits
 * @package BardoQi\StreamBuffer\Bits
 */
class InputBits extends Bits
{

    /**
     * InputBits constructor.
     * @param $bin
     */
    protected function __construct($bin)
    {
        parent::__construct($bin);
    }

    /**
     * @param string $str
     * @return InputBits
     */
    public static function ofString($str){
        $byteArray = str_split($str);
        $bin='';
        foreach ($byteArray as $character) {
            $bin .= sprintf('%08b', ord($character));
        }
        return new self($bin);
    }

    /**
     * @param string $byts
     * @return InputBits
     */
    public static function ofByte($byts){
        $byteArray = str_split($byts);
        $bin='';
        foreach ($byteArray as $character) {
            $num =$value = unpack('C', $character)[1];
            $bin .= sprintf('%08b', $num);
        }
        return new self($bin);
    }

    /**
     * @param int $length
     * @return int
     */
    public function read($length=1){
        $ret=0;
        for($i=0;$i<$length;$i++){
            $ret =($ret << 1);
            $ret += $this->binArry[$this->position++];
        }
        return $ret;
    }

}