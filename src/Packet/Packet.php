<?php


namespace ByteFerry\Packet;

use ByteFerry\DataDiagram\DataNode;
use ByteFerry\Schema\Schema;
use ByteFerry\Stream\StreamIo;

class Packet
{
    public $schema;
    public $stream;

    public function __construct(Schema $schema,StreamIo $stream)
    {
        $this->schema = $schema;
        $this->stream = $stream;
    }
}