<?php

namespace lewczyk\iai\src\Parameters;

use lewczyk\iai\src\Parameters\SoapParameter;

/**
 * Extended array
 */
class ExtendedArrayIAIParameter extends SoapParameter{
    public function setParam($paramName, $values){
        //echo "<pre>";
        //print_r($values);
        //print_r($values[array_keys($values)[0]]);
        //die;
        if(count($values) > 1){
            foreach($values as $key => $v){
                if(is_array($values[$key])){
                    if(count($values[$key]) > 1){
                        foreach($v as $value){
                            $this->param[$paramName][''][$key][] = $value;
                        }
                    }
                    else{
                        $this->param[$paramName][''][$key][] = $values[$key][0];
                    }
                }
                else{
                    $this->param[$paramName][''][$key] = $values[$key];
                }
            }
        }
        else{
            foreach($values as $key => $v){
                if(count($values[$key]) > 1){
                    foreach($v as $value){
                        $this->param[$paramName][][$key] = $value;
                    }
                }
                else{
                    $this->param[$paramName][][$key] = $values[$key][0];
                }
            }
        }
    }
}
