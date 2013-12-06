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
        if ($this->treeBuilder && $this->keyBuilder && $view->vars['prototype']) {
            $view->vars['prototype']->vars['tree']  = $this->treeBuilder->getTree($view->vars['prototype']);
            $view->vars['prototype']->vars['label'] = $this->keyBuilder->buildKeyFromTree($view->vars['prototype']->vars['tree'], 'label');
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
