<?php
/**
 * AbstractInvalidArgumentException class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Exceptions;

use InvalidArgumentException;
use Throwable;

abstract class AbstractInvalidArgumentException extends InvalidArgumentException implements Throwable
{

}