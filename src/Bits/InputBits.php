<?php
/**
 **************************************************************
 *        ___         __        ____
 *       / _ ) __ __ / /_ ___  / __/___  ____ ____ __ __
 *      / _  |/ // // __// -_)/ _/ / -_)/ __// __// // /
 *     /____/ \_, / \__/ \__//_/   \__//_/  /_/   \_, /
 *           /___/                               /___/
 *
 **************************************************************
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
     * @param string $str_buffer
     * @return InputBits
     */
    public static function ofString($str_buffer){
        $byte_array = str_split($str_buffer);
        $bin='';
        foreach ($byte_array as $character) {
            $bin .= sprintf('%08b', ord($character));
        }
        return new self($bin);
    }

    /**
     * @param array $byte_array
     * @return InputBits
     */
    public static function ofByte($byte_array){
        $bin='';
        foreach ($byte_array as $character) {
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
            $ret += $this->bin_arry[$this->position++];
        }
        return $ret;
    }

    /**
     * @param int $length
     * @return int
     */
    public function readInt($length=1){
         return $this->read($length);
    }




}