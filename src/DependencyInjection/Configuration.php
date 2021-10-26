<?php

namespace Lewczyk\IAIShopBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('iai_shop');
        
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('shop')
                    ->isRequired()
                    ->info('Your iai shop name')
                ->end()
                ->scalarNode('login')
                    ->isRequired()
                    ->info('Your iai user with api access login')
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                    ->info('Your iai user password')
                ->end()
            ->end();

        return $treeBuilder;
    }
}