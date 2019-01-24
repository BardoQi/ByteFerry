<?php

namespace ByteFerry\Packet;


class TreeData
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

    public $propertie=[];

    public $level;

    private $_parent;

    private $_schema;

    private $_stream;

    private $_bits;

    public function one_of($oneOfDef){
        //getKey
        //format key
        //return from $oneOfDef['list']['data'][$key]
    }

    public function repeat(){

    }

    public function format($key,$format){

    }




}