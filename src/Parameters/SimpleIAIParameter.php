<?php

namespace lewczyk\iai\src\Parameters;

use lewczyk\iai\src\Parameters\SoapParameter;

class SimpleIAIParameter extends SoapParameter{
    public function setParam($paramName, $value){
        $this->param[$paramName] = $value;
    }
}