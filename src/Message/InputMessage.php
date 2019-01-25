<?php
/**
 * InputMessage class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Message;
use ByteFerry\Stream\InputStream;
use ByteFerry\Schema\Schema;
use ByteFerry\DataDiagram\DataNode;

class InputMessage
{
    public $dataNodes = [];

    public $schema;

    public function getNode($typeName){
        if (!isset($this->dataNodes[$typeName])){
            $data_array = $this->schema->getNode($typeName);
            $this->dataNodes[$typeName] = new DataNode($data_array);
        }
        return clone($this->dataNodes[$typeName]);
    }
}