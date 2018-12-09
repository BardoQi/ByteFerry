<?php
/**
 * InputMessage class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Message;

use ByteFerry\Utils\TreeMap;
use ByteFerry\Stream\InputStream;
use ByteFerry\Schema\InputSchema;
use ByteFerry\Utils\TreeNodeInterface;

abstract class InputMessage extends TreeMap implements TreeNodeInterface
{

}