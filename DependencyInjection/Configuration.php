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
                ->append($this->addTreeNode())
            ->end();

        return $treeBuilder;
    }

    /**
     * Add the Tree related config section
     */
    public function addTreeNode()
    {
        $treeBuilder = new TreeBuilder();
        $treeNode    = $treeBuilder->root('tree');

        $treeNode
            ->info('<info>Activate the Form Tree component (used to generate label translation keys)</info>')
            ->canBeDisabled()
            ->children()
                ->booleanNode('auto_generate')
                    ->info('<info>Generate translation keys for all missing keys</info>')
                    ->defaultFalse()
                ->end()
                ->arrayNode('keys')
                    ->info('<info>Customize available keys</info>')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('form')
                            ->useAttributeAsKey('key')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('value')
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                            ->defaultValue(array('label' => "label", 'help' => "help"))
                        ->end()
                        ->arrayNode('collection')
                            ->useAttributeAsKey('key')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('value')
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                            ->defaultValue(array('label_add' => "label_add", 'label_delete' => "label_delete"))
                        ->end()
                        ->arrayNode('choice')
                            ->useAttributeAsKey('key')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('value')
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                            ->defaultValue(array('empty_value' => "empty_value"))
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('blocks')
                    ->info('<info>Customize the ways keys are built</info>')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('children')
                            ->defaultValue('children')
                            ->info('Prefix for children nodes')
                        ->end()
                        ->scalarNode('prototype')
                            ->defaultValue('prototype')
                            ->info('Prefix for prototype nodes')
                        ->end()
                        ->scalarNode('root')
                            ->defaultValue('form')
                            ->info('Prefix at the root of the key')
                        ->end()
                        ->scalarNode('separator')
                            ->defaultValue('.')
                            ->info('Separator te be used between nodes')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeNode;
    }
}
