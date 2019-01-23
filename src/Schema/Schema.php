<?php
/**
 * Schema class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Schema;

use ByteFerry\Exceptions\SchemaException;

class Schema
{

    protected $schema_def=[];

    private static $instance = [];

    private function __construct($name,$array)
    {
        $this->schema_def=$array;
    }

    /**
     * @param $name
     * @param $schema_file
     * @return mixed
     * @throws SchemaException
     */
    public function getInstance($name,$schema_file){
        if (!isset(self::$instance[$name])){
            if (is_file($schema_file)){
                $schema_array = $this->readSchemaFile($schema_file);
                self:$instance[$name] = new self($name,$schema_array);
            }else{
                Throw SchemaException::schemaFileReadFail();
            }
        }
        return self::$instance[$name];
    }

    /**
     * @param $path
     * @return bool
     * @throws SchemaException
     */
    private function readSchemaFile($path){
        try {
            $content = file_get_contents($path);
            if (false === $content ) {
                // Handle the error
                Throw SchemaException::schemaFileReadFail();
            }
        } catch (\Exception $e) {
            // Handle exception
            Throw SchemaException::schemaFileReadFail($e->getMessage());
        }
        $schema_array = json_decode($content,true);
        if (false === $schema_array ) {
            // Handle the error
            Throw SchemaException::schemaIsNotValid();
        }
        return $schema_array;
    }

    /**
     * @return $this
     */
    public function __clone()
    {
        return $this;
    }

    /**
     * @param $typeName
     * @return bool
     * @throws SchemaException
     */
    public function getType($typeName){
        if(!isset($this->schema_def['type_list'][$typeName])){
            Throw SchemaException::typeNotFound();
        }
        return $this->schema_def[$typeName];
    }

    /**
     * @param $typeName
     * @return bool
     */
    public function typeIsSet($typeName){
        return isset($this->schema_def['type_list'][$typeName]);
    }

}