<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elao\Bundle\FormBundle\Service\FormTreebuilder;
use Elao\Bundle\FormBundle\Service\FormKeybuilder;

class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * Form Tree treeBuilder
     *
     * @var FormTreebuilder
     */
    protected $treeBuilder;

    /**
     * Form Key treeBuilder
     *
     * @var FormKeybuilder
     */
    protected $keyBuilder;

    /**
     * Buildable keys list
     * 
     * @var array
     */
    protected $keys;

    /**
     * Wheither automatic generation of missing label is enabled or not
     * 
     * @var boolean
     */
    protected $autoGenerateLabel = false;

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * Set Tree Builder
     * 
     * @param FormTreebuilder $treeBuilder
     */
    public function setTreebuilder(FormTreebuilder $treeBuilder = null)
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * Set Key Builder
     * 
     * @param FormKeybuilder $keyBuilder
     */
    public function setKeybuilder(FormKeybuilder $keyBuilder = null)
    {
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * Set buildable keys
     * 
     * @param array $keys
     */
    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * Enable or disable automatic generation of missing labels
     * 
     * @param boolean $enabled 
     */
    public function setAutoGenerateLabel($enabled)
    {
        $this->autoGenerateLabel = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('help' => false));

        if ($this->autoGenerateLabel) {
            $resolver->replaceDefaults(array('label' => true));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->treeBuilder && $this->keyBuilder) {

            $tree = null;

            foreach ($this->keys as $key => $value) {
                if (isset($options[$key]) && $options[$key] === true) {
                    if (!$tree) {
                        $tree = $this->treeBuilder->getTree($view);
                    }
                    $view->vars[$key] = $this->keyBuilder->buildKeyFromTree($tree, $value);
                }
            }
        }
    }
}