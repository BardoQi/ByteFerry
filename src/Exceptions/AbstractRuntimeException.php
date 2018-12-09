<?php
/**
 * AbstractRuntimeException class file
 *
 * @author Bardo Qi <bardoqi@gmail.com>
 * @copyright Copyright (c) 2018, Bardo Qi
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace ByteFerry\Exceptions;

use RuntimeException;
use Throwable;

abstract class AbstractRuntimeException extends RuntimeException implements Throwable
{

}