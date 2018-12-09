<?php
/**
 * OutputMessage class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Message;

use ByteFerry\Utils\TreeMap;
use ByteFerry\Stream\OutputStream;
use ByteFerry\Schema\OutputSchema;
use ByteFerry\Utils\TreeNodeInterface;

abstract class OutputMessage extends TreeMap implements TreeNodeInterface
{

    public function __construct()
    {

    }
}