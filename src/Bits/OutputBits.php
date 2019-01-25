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
 * OutputBits class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */


namespace ByteFerry\Bits;


/**
 * Class OutputBits
 * @package BardoQi\StreamBuffer\Bits
 */
class OutputBits extends Bits
{


    /**
     * OutputBits constructor.
     * @param $bin
     */
    protected function __construct($bin)
    {
        parent::__construct($bin);
    }

    /**
     * @param $length
     * @return OutputBits
     */
    public static function ofByte($length){
        $bin=str_repeat('0',$length);
        return new self($bin);
    }

    /**
     * @param $value
     * @param $length
     */
    public function write($value,$length){
        for($i=0;$i<$length;$i++){
            $this->bin_arry[$this->position++] = ($value & 1);
            $value = ($value >> 1);
        }
    }

    /**
     * @return number
     */
    public function getValue(){
        return(bindec(implode("",array_reverse($this->bin_arry))));
    }


}