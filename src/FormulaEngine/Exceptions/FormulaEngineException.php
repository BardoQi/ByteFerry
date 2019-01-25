<?php
/**
 * Created by PhpStorm.
 * User: Bardo
 * Date: 2019/1/25
 * Time: 18:11
 */

namespace ByteFerry\FormulaEngine\Exceptions;

use ByteFerry\FormulaEngine\Exceptions\AbstractFormulaEngineException;

class FormulaEngineException extends AbstractFormulaEngineException
{
    public static function FormulaIsNotCorrect(){
        return new self('Formula is not correct!');
    }

    public static function CountOfVariablesIsZero(){
        return new self('Count of variables is zero!');
    }

    public static function DivisionByZero(){
        return new self('Division by zero!');
    }
}