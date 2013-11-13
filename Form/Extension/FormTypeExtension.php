<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elao\Bundle\FormBundle\Service\FormTreebuilder;

class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * Form Tree treeBuilder
     * 
     * @var FormTreebuilder
     */
    protected $treeBuilder;

    /**
     * Constructor
     * 
     * @param FormTreebuilder $treeBuilder
     */
    public function __construct(FormTreebuilder $treeBuilder = null)
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($view->vars['label'] !== false && $this->treeBuilder) {
            // @todo: Splite the logic in two distinct services: TreeBuilder and LabelBuilder
            $view->vars['label'] = implode('.', $this->treeBuilder->buildTree($view));
        }
    }
}