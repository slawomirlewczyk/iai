<?php

namespace Lewczyk\IAIShopBundle\Authentication;

/**
 * Singleton for iai-shop connection data
 */
class IAIShopAuthentication{
    
    /** @var IAIShopAuthentication */
    private static $connection_data;
    /** @var string */
    private $iai_login = '';
    /** @var string */
    private $iai_password = '';
    /** @var string */
    private $iai_shop_name = '';
    
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
}

