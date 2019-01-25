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
 *
 * Bits class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Bits;

use ByteFerry\Exceptions\RuntimeException;
use ArrayAccess;
use Iterator;
use Countable;

/**
 * Class Bits
 * @desc A package for reading and writing of bits. With this package, you need not use bit operator of php. And you can more easily process bit data.
 * @package Streamy\Bits
 */
class Bits implements ArrayAccess,Iterator,Countable
{

    /**
     * @var array $bin_array
     */
    protected $bin_array=[];

    /**
     * @var int $position
     */
    protected $position;


    /**
     * Bits constructor.
     * @param $bin
     */
    protected function __construct($bin)
    {
        $this->bin_array = array_reverse((array)$bin) ;
        $this->position = 0;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if (is_subclass_of($this,"InputBits")){
            if (is_null($offset)) {
                $this->bin_array[] = $value;
            } else {
                $this->bin_array[$offset] = $value;
            }
        }else{
            Throw RuntimeException::ObjectIsReadOnly();
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->bin_array[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        if (is_subclass_of($this,"InputBits")){
            unset($this->bin_array[$offset]);
        }else{
            Throw RuntimeException::ObjectIsReadOnly();
        }
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset) {
        return isset($this->bin_array[$offset]) ? $this->bin_array[$offset] : null;
    }

    /**
     * @return int
     */
    public function count(){
        return count($this->bin_array);
    }

    /**
     * @return void
     */
    function rewind() {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    function current() {
        return $this->bin_array[$this->position];
    }

    /**
     * @return int
     */
    function key() {
        return $this->position;
    }

    /**
     * @return void
     */
    function next() {
        ++$this->position;
    }

    /**
     * @return bool
     */
    function valid() {
        return isset($this->position[$this->position]);
    }

    /**
     * @param int $bits
     * @return void
     */
    public function skip($bits=1){
        $this->position+=$bits;
    }


}