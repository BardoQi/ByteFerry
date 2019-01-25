<?php

namespace ByteFerry\Packet;

use ByteFerry\Packet\Packet;
use ByteFerry\Stream\OutputStream;
use ByteFerry\Schema\Schema;
use ByteFerry\Bits\OutputBits;

class PacketEncoder extends Packet
{

    /**
     * PacketDecoder constructor.
     * @param Schema $schema
     * @param OutputStream $stream
     */
    public function __construct(Schema $schema,OutputStream $stream)
    {
        parent::__construct($schema,$stream);
    }

    /**
     * @param $data_array
     * @throws \ByteFerry\Exceptions\SchemaException
     * @return string: binary string buffer
     */
    public function encode($data_array){
        $message = $this->schema->getNode('message');
        $message->initData();
        $string_buffer = $message->encode($data_array,null,0);
        return $string_buffer;
    }




}