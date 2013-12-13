<?php

namespace Elao\Bundle\FormBundle\Form\Extension\Tree;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->treeBuilder && $this->keyBuilder && $options['allow_add'] && $options['prototype']) {

            if ($view->vars['prototype']->vars['label'] == $options['prototype_name'].'label__') {
                $view->vars['prototype']->vars['label'] = $options['label'];
                $options['options']['label'] = $options['label'];
            }

            foreach ($this->keys as $key => $value) {
                if (isset($options['options'][$key]) && $options['options'][$key] === true) {
                    $this->generateKey($view, $key, $value);
                    $this->generateKey($view->vars['prototype'], $key, $value);
                }
            }
        }

        parent::finishView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->autoGenerate) {
            $resolver->replaceDefaults(
                array(
                    'label_add'    => true,
                    'label_delete' => true,
                )
            );
        }
    }
}
