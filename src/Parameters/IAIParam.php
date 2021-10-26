<?php

namespace lewczyk\iai\src\Parameters;

use lewczyk\iai\src\Parameters\ParameterManager;
use lewczyk\iai\src\Parameters\SimpleIAIParameter;
use lewczyk\iai\src\Parameters\ArrayIAIParameter;
use lewczyk\iai\src\Parameters\ExtendedArrayIAIParameter;

/**
 * Setting parameters for api calls
 */
class IAIParam{
    const SIMPLE = 1;
    const SIMPLEARRAY = 2;
    const EXTENDEDARRAY = 3;
    /** @var ParameterManager */
    private $params;
    /**
     * Handling following cases:
     * 1. parameter can only have one value e.g. $this->params['productIsVisible'] = "productIsVisible";
     * 2. parameter values are a one-dimensional array e.g. $this->params['returnElements'][0] = "returnElements";
     * 3. parameter values ara one dimensional array with named value e.g. $this->params['productIndexes'][0]['productIndex'] = "productIndex";
     * Other cases require existing method, like productIndexes method
     * This is valid for version 150 of iai-shop api
     * @param type $param
     * @param type $values - array[index 0: parameter value, index 1: additional associative array key names array]
     */
    public function __construct() {
        $this->params = ParameterManager::getInstance();
    }
    public function __call($paramName, $values) {
        //print_r($this->resolveParamType($values));
        //die;
        switch($this->resolveParamType($values)){
            case self::SIMPLE:
                $this->params->addParam(new SimpleIAIParameter($paramName, $values[0]));
                break;
            case self::SIMPLEARRAY:
                $this->params->addParam(new ArrayIAIParameter($paramName, $values[0]));
                break;
            case self::EXTENDEDARRAY:
                $this->params->addParam(new ExtendedArrayIAIParameter($paramName, $values[0]));
                break;
            default:
                $this->params->addParam(new SimpleIAIParameter($paramName, $values[0]));
        }
    }
    /**
     * 
     * @return array
     */
    public function getParams():array{
        return $this->params->getParams();
    }
    /**
     * @return array
     */
    public function resetParams():array{
        return $this->params->resetParams();
    }
    /**
     * @param type $paramName
     * @return bool
     */
    public function hasParam($paramName):bool{
        return $this->params->hasParam($paramName);
    }
    /**
     * 
     * @param type $param
     * @return int
     */
    private function resolveParamType($param){
        if(!is_array($param[0])){
            return $this::SIMPLE;
        }
        else if(is_string(array_keys($param[0])[0])){
            return $this::EXTENDEDARRAY;
        }
        return $this::SIMPLEARRAY;
    }
}