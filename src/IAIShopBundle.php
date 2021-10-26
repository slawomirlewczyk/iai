<?php

namespace Lewczyk\IAIShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
//use Lewczyk\IAIShopBundle\DependencyInjection\IAIShopExtension;

class IAIShopBundle extends Bundle
{    
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
    
    /*public function getContainerExtension()
    {
        return new IAIShopExtension();
    }*/
}
