<?php

namespace lewczyk\iai;

use lewczyk\iai\src\Soap\IAISoapClient;
use lewczyk\iai\src\Authentication\IAIShopAuthentication;
use lewczyk\iai\src\Parameters\IAIParam;
use lewczyk\iai\src\Classes\IAIShopApiClientInterface;

/**
 * 
 */
class IAI implements IAIShopApiClientInterface
{
    private string $login;
    private string $password;
    private string $shop;
    private IAISoapClient $iai_soap_client;
    private array $response;
    private IAIParam $iai_param;
    private IAIShopAuthentication $iai_connection_data;
    private string $gate;
    private string $method;

    function __construct(
        string $shop,
        string $login,
        string $password,
        string $api_version
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->shop = $shop;
        $this->iai_soap_client = new IAISoapClient();
        $this->iai_param = new IAIParam();
        $this->setIAIConnectionData($login, $password, $shop, $api_version);
    }
    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments):IAI{
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
     * @param string $api_version
     */
    private function setIAIConnectionData(string $login, string $password, string $shop, int $api_version) {
        $this->iai_connection_data = IAIShopAuthentication::getConnectionData();
        $this->iai_connection_data->setIAILogin($login);
        $this->iai_connection_data->setIAIPassword($password);
        $this->iai_connection_data->setIAIShopName($shop);
        $this->iai_connection_data->getIAIApiVersion($api_version);
    }
}
