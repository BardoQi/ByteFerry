<?php
/**
 * TreeMap class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */
namespace ByteFerry\Utils;


class TreeMap extends AbstractMap
{

    protected $children = [];


    public function __construct($treeArray)
    {
        $this->_load($treeArray);
    }

    public function _load($treeArray){
        foreach($treeArray as $key => $value){
            if ($key != 'children'){
                $this->properties[$key] = $value;
            }else{
                foreach ($value as $key => $value){
                    $node = Self::factory($key,$value);

                }
            }
        }
    }

    public function add($treeArray){

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


    public function render(){
        foreach($this->children as $node){
            $node->render();
        }
        return $this->_render();
    }


    public function toString(){

        $Str = "{".static::class .'{%s,"children":$s}' . "}";
        $properties = json_encode($this->properties,true);
        $nodes = "";
        foreach($this->children as $key => $node){
            if (strlen($nodes)>0){
                $nodes.=",";
            }
            $nodes = '"' .$key. '":' . $node->toString();
        }
        if ($nodes == NULL){
            $nodes = '"null"';
        }
        return sprintf($Str,$properties,$nodes);

    }

    public function __toString()
    {
         return $this->toString();
    }

}