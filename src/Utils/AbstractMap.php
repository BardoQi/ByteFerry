<?php
/**
 * AbstractMap class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */
namespace ByteFerry\Utils;


abstract class AbstractMap
{
    protected $properties = [];


    abstract public function __construct($data);


    public function isEmpty(){
        return (count($this->properties)==0);
    }

    public function __get($name){
        if (isset($this->properties[$name])){
            return $this->properties[$name];
        }
        return null;
    }

    public function __set($name, $value){
        $this->properties[$name] = $value;
        return $this;
    }


}