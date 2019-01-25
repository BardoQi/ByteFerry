<?php

namespace ByteFerry\FormulaEngine;

use ByteFerry\FormulaEngine\Exceptions\FormulaEngineException;

/**
 * Class FormulaEngine
 * @package ByteFerry\DataDiagram
 */
class FormulaEngine
{

    /**
     * FormulaEngine::calculate($formula, $variables)
     * calculate the formula
     *
     * @param $formula
     * @param array $variables
     * @return mixed
     * @throws \Exception
     */
    public static function calculate($formula, $variables = array()){
        if ( false === preg_match_all( '/(\w+)/', $formula, $result, PREG_PATTERN_ORDER ) ){
            throw FormulaEngineException::FormulaIsNotCorrect();
        }
        if(empty($variables)){
            throw FormulaEngineException::CountOfVariablesIsZero();
        }
        $keys = $result[0];
        if (!isset($variables['true'])){
            $variables['true'] = 1;
        }
        if (!isset( $variables['false'])){
            $variables['false'] = 0;
        }
        $varArray = array();
        $pos = 0;
        foreach ($keys as $value){
            if ((is_numeric( $value )) || (is_callable($value))){
                continue;
            }
            if (isset($variables[$value])){
                $pos = strpos($formula, $value, $pos);
                $formula = substr_replace($formula, '$', $pos, 0);
                $pos += strlen($value) + 1;
                $varArray[$value] = $variables[$value];
            }else{
                throw new \Exception($value . ' not fund!');
            }
        }
        $result = function($varArray) use ($formula) {
            extract($varArray);
            return @eval($formula);
        };

        if ((false===$result)||(INF == $result)){
            throw FormulaEngineException::DivisionByZero();
        }
        return 0 + $result;
    }

}