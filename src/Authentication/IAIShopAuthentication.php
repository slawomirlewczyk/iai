<?php

namespace lewczyk\iai\src\Authentication;

/**
 * Singleton for iai-shop connection data
 */
class IAIShopAuthentication{
    
    private static IAIShopAuthentication $connection_data;
    private string $iai_login = '';
    private string $iai_password = '';
    private string $iai_shop_name = '';
    private int $iai_api_version = 150;
    
    /**
     * Disable constructing
     */
    protected function __construct() {}
    
    /**
     * Disable cloning
     */
    protected function __clone() {}
    
    /**
     * Disable unserializing
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    
    /**
     * 
     * @return IAIShopAuthentication
     */
    public static function getConnectionData():IAIShopAuthentication{
        if(!isset(self::$connection_data)){
            self::$connection_data = new static();
        }
        return self::$connection_data;
    }
    
    public function getIAILogin(): string {
        return $this->iai_login;
    }

    public function getIAIPassword(): string {
        return $this->iai_password;
    }

    public function getIAIShopName(): string {
        return $this->iai_shop_name;
    }

    public function setIAILogin(string $iai_login): void {
        $this->iai_login = $iai_login;
    }

    public function setIAIPassword(string $iai_password): void {
        $this->iai_password = $iai_password;
    }

    public function setIAIShopName(string $iai_shop_name): void {
        $this->iai_shop_name = $iai_shop_name;
    }

    /**
     * Get the value of iai_api_version
     */ 
    public function getIAIApiVersion()
    {
        return $this->iai_api_version;
    }

    /**
     * Set the value of iai_api_version
     *
     * @return  self
     */ 
    public function setIAIApiVersion($iai_api_version)
    {
        $this->iai_api_version = $iai_api_version;

        return $this;
    }
}

