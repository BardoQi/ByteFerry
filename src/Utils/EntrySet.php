<?php
/**
 * EntrySet class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Utils;


use ByteFerry\Exceptions\InvalidArgumentException;

/**
 * Class EntrySet
 * @desc With this class, you can get a value from key, and get a key from value.
 * @package ByteFerry\Utils
 */
class EntrySet
{
    /**
     * @var array $items
     */
    protected $items;


    /**
     * @var array
     */
    protected $flipItems;

    /**
     * ArrayList constructor.
     * @param array $items
     */
    protected function __construct($items)
    {
        $this->items = $items;
        $this->flipItems = array_flip($items);
    }

    /**
     * Initial a EntrySet from given json data.
     *
     * @param $list key-value list data in json string
     * @return EntrySet
     */
    public static function ofJson($list){
        $items = json_decode($list) ;
        return new self($items);
    }

    /**
     * Initial a EntrySet from given array data.
     *
     * @param $list key-value list data in array
     * @return EntrySet
     */
    public static function ofArray($list){
        return new self($list);
    }

    /**
     * Get a value from a key name.
     *
     * @param $name  key name
     * @return mixed
     */
    public function getValue($name){
        if (isset($this->items[$name])){
            return $this->items[$name];
        }else{
            throw InvalidArgumentException::itemNotFound($name);
        }
    }

    /**
     * @see function getValue
     * @param $name
     */
    public function __get($name){
        $this->getValue($name);
    }

    /**
     * @see function getValue
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __callStatic($name, $arguments)
    {
        return $this->getValue($name);
    }

    /**
     * Get a key from a value.
     * @param $value
     * @return mixed
     */
    public function getKey($value){
        if (isset($this->flipItems[$value])){
            return $this->flipItems[$value];
        }else{
            throw InvalidArgumentException::itemNotFound($value);
        }
    }

}