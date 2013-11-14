<?php

namespace Elao\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ElaoFormExtension extends Extension
{
    const TREE_BUILDER = 'elao.form.tree_builder';
    const KEY_BUILDER  = 'elao.form.key_builder';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter(
            'twig.form.resources',
            array_merge(
                $container->getParameter('twig.form.resources'),
                array('ElaoFormBundle:Form:form_elao_layout.html.twig')
            )
        );

        $this->loadTreeConfig($container, $loader, $config['tree']);
    }

    /**
     * Load Tree configuration
     * @param  array $config [description]
     */
    private function loadTreeConfig(ContainerBuilder $container, LoaderInterface $loader, array $config)
    {
        if ($config['enabled']) {
            $loader->load('tree.xml');

            /* Set up the Key Builder */
            $keyBuilder = $container->getDefinition(self::KEY_BUILDER);
            $keyBuilder
                ->addArgument($config['blocks']['separator'])
                ->addArgument($config['blocks']['root'])
                ->addArgument($config['blocks']['children']);

            /* Set up the Form extension */
            $formExtension = $container->getDefinition('elao.form.extension.form_type_extension');
            $formExtension->addMethodCall('setAutoGenerateLabel', array($config['auto_generate_label']));
            $formExtension->addMethodCall('setKeys', array($config['keys']));
            $formExtension->addMethodCall('setTreebuilder', array(new Reference(self::TREE_BUILDER)));
            $formExtension->addMethodCall('setKeybuilder', array(new Reference(self::KEY_BUILDER)));
        }
    }
}
