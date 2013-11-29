<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elao\Bundle\FormBundle\Form\Extension\TreeAwareExtension;
use Elao\Bundle\FormBundle\Service\FormTreebuilder;
use Elao\Bundle\FormBundle\Service\FormKeybuilder;

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'label_add'    => $this->autoGenerate ? true : 'Add',
                'label_delete' => $this->autoGenerate ? true : 'Delete',
            )
        );
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
}
