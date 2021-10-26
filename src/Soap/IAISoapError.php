<?php

namespace Lewczyk\IAIShopBundle\Soap;

class IAISoapError{
    private $faultCode;
    private $faultString;
    /**
     * 
     * @param int $faultCode
     * @param string $faultString
     */
    public function __construct(\SoapFault $e) {
        $this->faultCode = $e->faultcode;
        $this->faultString = 'NO GATE OR METHOD FOUD: '.$e->faultstring;
    }
    public function getFaultCode():string{
        return $this->faultCode;
    }
    /**
     * 
     * @return string
     */
    public function getFaultString():string{
        return $this->faultString;
    }
    public function __get($name) {
        $method_name = 'get'.$name;
        if(method_exists($this, $method_name)){
            return $this->$method_name();
        }
    }
}

