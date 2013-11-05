<?php

namespace Elao\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ElaoFormExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $formLayout = self::getFormLayout($config['form_layout']);

        if ($formLayout) {

            // @todo Find a way to make sure the template exists: $container->get('templating')->exists($formLayout);
            
            $container->setParameter(
                'twig.form.resources', 
                array_merge(
                    $container->getParameter('twig.form.resources'),
                    (array) $formLayout
                )
            );
        }
    }

    /**
     * Get form layout form the config value
     * 
     * @param string $value The given configuration value
     * 
     * @return string       The form layout that should be used
     */
    private static function getFormLayout($value)
    {
        if (!$value) {
            return false;
        }

        switch ($value) {
            case 'twitter-bootstrap-3':
                return 'ElaoFormBundle:Form:form_bootstrap3_layout.html.twig';

            case 'elao':
                return 'ElaoFormBundle:Form:form_elao_layout.html.twig';
            
            default:
                return $value;
        }
    }
}
