<?php


namespace ByteFerry\Packet;

use ByteFerry\DataDiagram\DataNode;
use ByteFerry\Schema\Schema;
use ByteFerry\Stream\InputStream;
use ByteFerry\Bits\InputBits;

class PacketDecoder extends Packet
{

    /**
     * PacketDecoder constructor.
     * @param Schema $schema
     * @param InputStream $stream
     */
    public function __construct(Schema $schema,InputStream $stream)
    {
        parent::__construct($schema,$stream);
    }

    /**
     * @param $string_buffer
     * @throws \ByteFerry\Exceptions\SchemaException
     */
    public function decode($string_buffer){
        $message = $this->schema->getNode('message');
        $message->initData();
        $data_array = $message->decode($string_buffer,null,0);
        return $data_array;
    }

}