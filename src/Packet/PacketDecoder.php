<?php


namespace ByteFerry\Packet;

use ByteFerry\DataDiagram\DataNode;


class PacketDecoder
{
    public $schema;
    public $stream;


    public function __construct($schema,$stream)
    {
        $this->schema = $schema;
        $this->stream = $stream;
    }


    public function decode($data){

    }

}