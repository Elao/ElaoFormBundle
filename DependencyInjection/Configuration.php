<?php

namespace Elao\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elao_form');

        $rootNode
            ->children()
                ->enumNode('form_layout')
                    ->defaultValue('twitter-bootstrap-3')
                    ->values(
                        array(
                            'twitter-bootstrap-3',
                            'elao',
                            false
                        )
                    )
                    ->info('<info>What layout should be used to render forms?</info>')
                    ->example('
                        Can be any of these:
                        - <comment>twitter-bootstrap-3</comment>: The provided Twitter Bootstrap 3 layout (extends the elao layout)
                        - <comment>elao</comment>: The provided default layout
                        - <comment>false</comment>: To use neither of these (and fallback to the twig configuration)')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
