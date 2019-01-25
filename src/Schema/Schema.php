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
    private function __construct($name,$array,$data_node)
    {
        $this->name = $name;
        $this->schema_def = $array;
        $this->dataNode = $data_node;
    }

    /**
     * @param string $name
     * @param string $schema_file
     * @param DataNode $dataNode
     * @return mixed
     * @throws SchemaException
     */
    public static function getInstance($name,$schema_file,$data_node){
        if (!isset(self::$instance[$name])){
            if (is_file($schema_file)){
                $schema_array = self::readSchemaFile($schema_file);
                self:$instance[$name] = new self($name,$schema_array,$data_node);
            }else{
                Throw SchemaException::schemaFileReadFail();
            }
        }
        return self::$instance[$name];
    }

    /**
     * @param string $path
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
     * @param string $type_name
     * @return bool
     */
    public function typeIsSet($type_name){
        return isset($this->schema_def['type_list'][$type_name]);
    }

    /**
     * @param $type_name
     * @return bool
     * @throws SchemaException
     */
    public function getType($type_name){
        if(!isset($this->schema_def['type_list'][$type_name])){
            Throw SchemaException::typeNotFound();
        }
        return $this->schema_def[$type_name];
    }

    /**
     * @param $typeName
     * @return bool
     * @throws SchemaException
     */
    public function getNode($type_name){
        if(!isset($this->data_nodes[$type_name])){
            if(!isset($this->schema_def['type_list'][$type_name])){
                Throw SchemaException::typeNotFound();
            }
            $this->initNode($type_name);
        }
        return clone($this->data_nodes[$type_name]);
    }

    /**
     * @param $typeName
     * @return bool
     * @throws SchemaException
     */
    private function initNode($type_name){
        $def_array = $this->getType($type_name);
        $node = clone($this->data_nodes[$type_name]);
        $node->initData($def_array);
        $this->data_nodes[$type_name] = $node;
        return true;
    }


}