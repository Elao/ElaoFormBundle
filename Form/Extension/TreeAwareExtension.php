<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractTypeExtension;
use Elao\Bundle\FormBundle\Service\FormTreebuilder;
use Elao\Bundle\FormBundle\Service\FormKeybuilder;

abstract class TreeAwareExtension extends AbstractTypeExtension
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
     * Wheither automatic generation of missing keys is enabled or not
     *
     * @var boolean
     */
    protected $autoGenerate = false;

    /**
     * Enable or disable automatic generation of missing labels
     *
     * @param boolean $enabled
     */
    public function setAutoGenerate($enabled)
    {
        $this->autoGenerate = $enabled;
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
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->treeBuilder && $this->keyBuilder) {
            foreach ($this->keys as $key => $value) {
                if (isset($options[$key]) && $options[$key] === true) {
                    if (!isset($view->vars['tree'])) {
                        $view->vars['tree'] = $this->treeBuilder->getTree($view);
                    }
                    $view->vars[$key] = $this->keyBuilder->buildKeyFromTree($view->vars['tree'], $value);
                }
            }
        }
    }
}
