<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ElaoForm bundle configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('elao_form');

        $rootNode
            ->children()
                ->booleanNode('collection')
                    ->info('<info>Activate the Collection feature</info>')
                    ->defaultTrue()
                ->end()
                ->booleanNode('buttons')
                    ->info('<info>Activate the Form Buttons feature</info>')
                    ->defaultTrue()
                ->end()
                ->booleanNode('other_choice')
                    ->info('<info>Activate the Other Choice feature</info>')
                    ->defaultTrue()
                ->end()
            ->end()

        return $treeBuilder;
    }
}
