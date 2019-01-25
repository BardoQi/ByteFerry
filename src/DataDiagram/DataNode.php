<?php

namespace ByteFerry\DataDiagram;

use ByteFerry\FormulaEngine\FormulaEngine;

/**
 * Class DataNode
 * @package ByteFerry\DataDiagram
 */
class DataNode
{
    public $comment;

    public $pos;

    public $length;

    public $data_type;

    public $required;

    public $tag;

    public $name;

    public $chillren=[];

    public $chillren_type=[];

    public $before_event=[];

    public $after_event=[];

    public $value;

    public $repeat;

    public $assemble;

    public $assemble_type;

    public $disperse;

    public $disperse_type;

    public $encode_formula;

    public $decode_formula;

    public $properties=[];




    public $level;

    private $_parent;

    private $_schema;

    private $_stream;

    private $_bits;

    /**
     * DataNode constructor.
     */
    public function __construct(){

    }

    /**
     * @param $data_array
     */
    public function init_data($data_array){
        foreach($data_array as $key => $value){
            if(property_exists($this , $key)){
                $this->$key = $value;
            }else{
                $this->properties[$key] = $value;
            }
        }
    }

    /**
     * Convert the value to string.
     * Important: This function only convert current node, not recursive!
     * @return string
     */
    public function __toString()
    {
        if(!empty($this->format)){
            return sprintf($this->format,$this->value);
        }
        return (string)$this->value;
    }

    /**
     * Convert the tree object to associate array recursively.
     * @return array
     */
    public function toArray(){
        $children = null;
        if(!empty($this->children)){
            if(true == $this->assemble){
                $children = $this->asm_values();
            }else{
                $children = [];
                foreach ($this->children as $val){
                    $children[]=$val->toArray();
                }
            }
        }
        $children_name = (!empty($this->name))?$this->name:$this->tag;
        $return_array=[
            'comment' => $this->comment,
            'tag' => $this->tag,
            'name' => $this->name,
            'value' => $this->decode_with_formula(),
            $children_name => $children
        ];
        return $return_array;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name){
        if(property_exists($this , $name)){
            return $this->name;
        }else{
            return $this->properties[$name];
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name,$value){
        if(property_exists($this , $name)){
            $this->$name = $value;
        }else{
            $this->properties[$name] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function asm_values(){
        $method = "asm_as" . $this->assemble_type;
        return $this->$method();
    }

    /**
     * @return string
     */
    public function asm_as_string(){
        $return_string = "";
        foreach($this->chillren as $value){
            $return_string .= (string)$value;
        }
        return $return_string;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function decode_with_formula(){
        if (!empty($this->decode_formula)){
            return $this->value = FormulaEngine::calculate($this->decode_formula,['A' => $this->value]);
        }
        return $this->value;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function encode_with_formula(){
        if (!empty($this->encode_formula)){
            return $this->value = FormulaEngine::calculate($this->encode_formula,['A' => $this->value]);
        }
        return $this->value;
    }


    public function one_of($oneOfDef){
        //getKey
        //format key
        //return from $oneOfDef['list']['data'][$key]
    }

    public function repeat(){

    }


    /**
     * destroy the children for save memory
     */
    public function destroy(){
        if(!empty($this->chillren)){
            foreach ($this->chillren as $val){
                $val->destroy();
                unset($val);
            }
        }
    }


}