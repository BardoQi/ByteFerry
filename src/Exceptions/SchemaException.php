<?php
/**
 * SchemaException class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Exceptions;

use ByteFerry\Exceptions\AbstractSchemaException;

class SchemaException extends AbstractSchemaException
{
    public static function schemaFileReadFail($msg=''){
        return new self('Schema File Read Fail!  '.$msg);
    }

    public static function typeNotFound(){
        return new self('type not found in schema!');
    }

    public static function schemaIsNotValid(){
        return new self('json_decode fail because schema is not valid!');
    }



}