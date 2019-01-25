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

    /**
     * @var array of schema definition
     */
    protected $schema_def=[];

    /**
     * @var array of DataNode with key of data_type
     */
    protected $data_nodes=[];

    /**
     * @var array of Schema Object
     */
    private static $instance = [];

    /**
     * @var DataNode
     */
    private $dataNode;

    /**
     * Schema constructor.
     * @param $name
     * @param $array
     * @param $dataNode
     */
    private function __construct($name,$array,$dataNode)
    {
        $this->name = $name;
        $this->schema_def = $array;
        $this->dataNode = $dataNode;
    }

    /**
     * @param $name
     * @param $schema_file
     * @param $dataNode
     * @return mixed
     * @throws SchemaException
     */
    public static function getInstance($name,$schema_file,$dataNode){
        if (!isset(self::$instance[$name])){
            if (is_file($schema_file)){
                $schema_array = self::readSchemaFile($schema_file);
                self:$instance[$name] = new self($name,$schema_array,$dataNode);
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
    private static function readSchemaFile($path){
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
    private function __clone(){}

    /**
     * @param $typeName
     * @return bool
     */
    public function typeIsSet($typeName){
        return isset($this->schema_def['type_list'][$typeName]);
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
     * @throws SchemaException
     */
    public function getNode($typeName){
        if(!isset($this->data_nodes[$typeName])){
            if(!isset($this->schema_def['type_list'][$typeName])){
                Throw SchemaException::typeNotFound();
            }
            $this->initNode($typeName);
        }
        return clone($this->data_nodes[$typeName]);
    }

    /**
     * @param $typeName
     * @return bool
     * @throws SchemaException
     */
    private function initNode($typeName){
        $def_array = $this->getType($typeName);
        $node = clone($this->dataNode);
        $node->init_data($def_array);
        $this->data_nodes[$typeName] = $node;
        return true;
    }


}