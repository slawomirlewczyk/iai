<?php

namespace Lewczyk\IAIShopBundle\Parameters;

use Lewczyk\IAIShopBundle\Parameters\SoapParameter;

class SimpleIAIParameter extends SoapParameter{
    public function setParam($paramName, $value){
        $this->param[$paramName] = $value;
    }
}