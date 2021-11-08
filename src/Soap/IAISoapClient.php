<?php

namespace lewczyk\iai\src\Soap;

use lewczyk\iai\src\Parameters\IAIParam;
use lewczyk\iai\src\Soap\IAISoapError;
use lewczyk\iai\src\Authentication\IAIShopAuthentication;

/**
 * Make request to iai-shop.com via Soap
 * 
 * @property const APIVERSION iai-shop api version
 */
class IAISoapClient
{
    const APIVERSION = 150;
    private \SoapClient $client;
    private string $apiGate;
    private string $apiMethod;
    private IAIShopAuthentication $connection_data;
    private array $request;
    private array $response;
    private int $resultNumberPage;
    public IAIParam $params;

    /**
     * 
     * @param mixed $params - parameters for api method
     * @param type $shop - shop url
     */
    public function __construct()
    {
        $this->connection_data = IAIShopAuthentication::getConnectionData();
        $this->params = new IAIParam();
    }
    /**
     * @param type $apiGate - api gate, e.g. 'products'
     * @param type $apiMethod - api method, e.g 'get'
     * @return type
     */
    public function __call($apiGate, $apiMethod)
    {
        try{
            $this->apiGate = $apiGate;
            $this->apiMethod = $apiMethod[0];
            $this->setClient();
            $this->setRequest();
            $this->setResponse();
            $this->setResultNumberPage();
            //$this->resetParams();
            return $this->getResponses();
        }
        catch(\SoapFault $e){
            //print_r($e);
            $errors = new IAISoapError($e);
            return ['errors' => $errors, 'gate' => $this->apiGate, 'method' => $this->apiMethod];
        }
    }
    public function __get($name)
    {
        $method_name = 'get'.$name;
        if(method_exists($this->params, 'get'.$method_name))
        {
            return $this->params->$method_name();
        }
    }
    public function resetParams(){
        $this->params->resetParams();
    }
    /**
     * Return all responses merged to one array
     * @return type array
     */
    private function getResponses():array
    {
        if($this->resultNumberPage > 1)
        {
            $responses = $this->response;
            for($page=1;$page<$this->resultNumberPage;$page++)
            {
                $this->setRequest($page);
                $response = (array)$this->client->__soapCall($this->apiMethod, $this->request);
                $responses = $this->resultsMerge($responses, $response);
            }
            return $responses;
        }
        return (array)$this->response;
    }
    private function setResponse()
    {
        try
        {
            $this->response = (array)$this->client->__soapCall($this->apiMethod, $this->request);
        }
        catch(\SoapFault $fault)
        {
            $this->response = ['results' => [], 'errors' => $fault];
        }
    }
    private function setRequest($page = 0)
    {
        $this->setPage($page);
        $password = sha1(date('Ymd') . sha1($this->connection_data->getIAIPassword()));
        $request = array();
        $request[$this->apiMethod] = array();
        $request[$this->apiMethod]['authenticate'] = array();
        $request[$this->apiMethod]['authenticate']['userLogin'] = $this->connection_data->getIAILogin();
        $request[$this->apiMethod]['authenticate']['authenticateKey'] = $password;
        $request[$this->apiMethod]['authenticate']['system_login'] = $this->connection_data->getIAILogin();
        $request[$this->apiMethod]['authenticate']['system_key'] = $password;
        $request[$this->apiMethod]['params'] = $this->params->getParams();
        $this->request = $request;
    }
    private function setClient()
    {
        $address = 'https://'.$this->connection_data->getIAIShopName().'.iai-shop.com/api/?gate='.$this->apiGate.'/'.$this->apiMethod.'/'.$this->connection_data->getIAIApiVersion().'/soap';
        $wsdl = $address . '/wsdl';
        $binding = array();
        $binding['location'] = $address;
        $binding['trace'] = true;
        $this->client = new \SoapClient($wsdl, $binding);
    }
    private function setPage($page) 
    {
        if($this->params->hasParam('results_page'))
        {
            $this->params->results_page($page);
        }
        if($this->params->hasParam('resultsPage'))
        {
            $this->params->resultsPage($page);
        } 
    }
    private function setResultNumberPage()
    {
        if(isset($this->response['results_number_page']))
        {
            $this->resultNumberPage = $this->response['results_number_page'];
        }
        if(isset($this->response['resultsNumberPage']))
        {
            $this->resultNumberPage = $this->response['resultsNumberPage'];
        }
    }
    private function resultsMerge( array &$array1, array &$array2 ):array{
          $merged = $array1;
          foreach ( $array2 as $key => &$value ){
            if(is_array($value) && isset($merged[$key]) && is_array($merged[$key])){
              $merged[$key] = $this->resultsMerge($merged[$key], $value);
            }
            elseif($merged[$key] == $value){
              $merged[$key] = $value;
            }
            else{
                $merged[] = $value;
            }
        }
        return $merged;
    }
}