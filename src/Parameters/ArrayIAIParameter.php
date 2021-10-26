<?php

namespace lewczyk\iai\src\Parameters;

use lewczyk\iai\src\Parameters\SoapParameter;

class ArrayIAIParameter extends SoapParameter{
    public function setParam($paramName, $values){
        if(is_array($values)){
            foreach($values as $value){
                $this->param[$paramName][] = $value;
            }
        }
        else{
            $this->param[$paramName][] = $values;
        }
    }
}
