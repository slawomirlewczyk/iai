<?php

namespace Lewczyk\IAIShopBundle\Parameters;

abstract class SoapParameter{
    protected $params = array();
    protected $param = array();
    
    public function __construct($paramName, $values) {
        $this->setParam($paramName, $values);
    }
    abstract public function setParam($paramName, $values);
    public function addParam(SoapParameter $param){
        throw new Exception(get_class($this).' nie może przechowywać parametrów.');
    }
    public function getParam(){
        return $this->param;
    }
}
