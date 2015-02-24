<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ElaoForm extension
 */
class ElaoFormExtension extends Extension
{
    /**
     * Features
     *
     * @var array
     */
    private $features;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->features = array(
            'collection'    => "collection.xml",
            'choice'        => "choice.xml",
            'buttons'       => "buttons.xml",
            'help'          => "help.xml",
            'label_tooltip' => "label_tooltip.xml",
        );
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        $loader        = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($this->features as $option => $xml) {
            if ($config[$option]) {
                $loader->load($xml);
            }
        }
    }
}
