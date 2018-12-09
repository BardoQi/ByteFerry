<?php
/**
 * InvalidArgumentException class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Exceptions;

use ByteFerry\Exceptions\AbstractInvalidArgumentException;

class InvalidArgumentException extends AbstractInvalidArgumentException
{

    public static function StreamMustBeResource(){
        return new self('Stream must be a resource');
    }

    public static function InvalidResourceType($type=null){
        if (null==$type){
            return new self('Invalid resource type');
        }
        return new self(sprintf('Invalid resource type: %s', $type));
    }

    public static function PropertyNotFound($name){
        return new self(sprintf('Property %s not found.', $name));
    }

    public static function itemNotFound($value){
        return new self(sprintf('The item with value of %s not found.', $value));
    }

}