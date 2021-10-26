<?php

namespace lewczyk\iai\src\Parameters;

use lewczyk\iai\src\Parameters\SoapParameter;

class ParameterManager extends SoapParameter{
    private static $instance;

    private function __construct() {}
    
    public function addParam(SoapParameter $param){
        $this->params[] = $param; //i.e. $this->params['productIsVisible'] = 'y';
    }
    
    public function setParam($param, $values){
        return;
    }
    
    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new ParameterManager();
        }
        return self::$instance;
    }
    
    public function getParams(){
        return $this->paramToArray();
    }
    public function hasParam($paramName){
        return isset($this->params[$paramName]);
    }
    public function resetParams(){
        return $this->params = array();
    }
    private function paramToArray(){
        $parametersArray = array('results_page' => 0, 'resultsPage' => 0);
        foreach($this->params as $param){
            //$parametersArray = array_merge($parametersArray, $param->getParam());
            foreach($param->getParam() as $key => $value){
                if(is_array($value)){
                    foreach($value as $p){
                        $parametersArray[$key][] = $p;
                    }
                }
                else{
                    $parametersArray[$key] = $value;
                }
            } 
        }
        //print_r($this->params);
        return $parametersArray;
    }
}
