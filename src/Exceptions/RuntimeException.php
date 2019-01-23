<?php
/**
 * RuntimeException class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */


namespace ByteFerry\Exceptions;

use ByteFerry\Exceptions\AbstractRuntimeException;

class RuntimeException extends AbstractRuntimeException
{

    public static function BufferAllocationFailed(){
        return new self('Buffer allocation failed');
    }

    public static function MethodNotExists($methodName){
        return new self(sprintf('Method %s not exists.',$methodName));
    }

    public static function ObjectIsReadOnly(){
        return new self('Object is read only');
    }


}