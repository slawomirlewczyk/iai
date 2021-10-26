<?php

namespace Lewczyk\IAIShopBundle\Parameters;

use Lewczyk\IAIShopBundle\Parameters\SoapParameter;

/**
 * Trzeba zrobić test czy jest $values[1](jeśli nie jest to nie robimy pętli, $this->param[$paramName][$values[2]] = $values[1];)  i $values[2] tablicą i obsłużyć różne długości tablicy
 */
class ExtendedArrayIAIParameter extends SoapParameter{
    public function setParam($paramName, $values){
        //print_r($values);
        //die;
        if(count($values[array_keys($values)[0]]) > 1){
            foreach($values[array_keys($values)[0]] as $value){
                $this->param[$paramName][][array_keys($values)[0]] = $value;
            }
        }
        else{
            $this->param[$paramName][][array_keys($values)[0]] = $values[array_keys($values)[0]][0];
        }
    }
}
