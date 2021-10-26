<?php

namespace Lewczyk\IAIShopBundle\Classes;

use Lewczyk\IAIShopBundle\Soap\IAISoapClient;
use Lewczyk\IAIShopBundle\Authentication\IAIShopAuthentication;
use Lewczyk\IAIShopBundle\Parameters\IAIParam;

class IAIShopApiClient implements IAIShopApiClientInterface 
{
    /** @var string */
    private $login;
    /** @var string */
    private $password;
    /** @var string */
    private $shop;
    /** @var SoapClient */
    private $iai_soap_client;
    /** @var array */
    private $response;
    /** @var IAIParam */
    private $iai_param;
    /** @var IAIShopAuthentication */
    private $iai_connection_data;
    /** @var string */
    private $gate;
    /** @var string */
    private $method;

    function __construct(
        string $login,
        string $password,
        string $shop,
        IAISoapClient $iai_soap_client,
        IAIParam $iai_param
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->shop = $shop;
        $this->iai_soap_client = $iai_soap_client;
        $this->iai_param = $iai_param;
        $this->setIAIConnectionData($login, $password, $shop);
    }
    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments):IAIShopApiClient{
        $this->gate = $name;
        $this->method = $arguments[0];
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @param mixed $values
     * @return $this
     */
    public function param(string $name, $values) {
        $this->iai_param->$name($values);
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function all() {
        $gate = $this->gate;
        return $this->response = $this->iai_soap_client->$gate($this->method);
    }
    
    /**
     * 
     * @param string $login
     * @param string $password
     * @param string $shop
     */
    private function setIAIConnectionData(string $login, string $password, string $shop) {
        $this->iai_connection_data = IAIShopAuthentication::getConnectionData();
        $this->iai_connection_data->setIAILogin($login);
        $this->iai_connection_data->setIAIPassword($password);
        $this->iai_connection_data->setIAIShopName($shop);
    }
}