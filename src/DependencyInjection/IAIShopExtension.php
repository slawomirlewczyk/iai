<?php

namespace Lewczyk\IAIShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class IAIShopExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
        
        foreach($config as $key => $value){
            $container->setParameter(sprintf('iai.params.%s', $key), $value);
        }

        $serviceDefinition = new Definition(\Lewczyk\IAIShopBundle\Classes\IAIShopApiClient::class);
        $serviceDefinition->setArguments([
            '%iai.params.login%',
            '%iai.params.password%',
            '%iai.params.shop%',
            new Reference('iai_shop_soap_client'),
            new Reference('iai_shop_soap_param'),
        ]);

        $container->setDefinition('iai.service.client', $serviceDefinition);
    }
}