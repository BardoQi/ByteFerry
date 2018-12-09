<?php
/**
 * TreeNodeInterface class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Utils;


interface TreeNodeInterface
{
    public function factory($type,$definition);

    public function _render();
}