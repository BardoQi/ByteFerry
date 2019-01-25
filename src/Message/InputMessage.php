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
    public $data_nodes = [];

    public $schema;

    public function getNode($type_name){
        if (!isset($this->dataNodes[$type_name])){
            $data_array = $this->schema->getNode($type_name);
            $this->data_nodes[$type_name] = new DataNode($data_array);
        }
        return clone($this->dataNodes[$type_name]);
    }
}