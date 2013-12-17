<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionTypeExtension extends AbstractTypeExtension
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
                'label_add'    => 'Add',
                'label_delete' => 'Delete',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        foreach ($view as $child) {
            $child->vars['block_prefixes'][] = 'collection_item';
            $child->vars['block_prefixes'][] = $form->getName() . '_item';
        }

        if ($options['allow_add'] && $options['prototype']) {

            $view->vars['prototype']->vars['block_prefixes'][] = 'collection_item';
            $view->vars['prototype']->vars['block_prefixes'][] = $form->getName() . '_item';

            if ($view->vars['prototype']->vars['label'] == $options['prototype_name'].'label__') {
                $view->vars['prototype']->vars['label'] = $options['label'];
                $options['options']['label'] = $options['label'];
            }
        }
    }
}
