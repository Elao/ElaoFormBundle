<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension for the CollectionType, provides:
 * - Label options for Add and Delete buttons
 * - Block prefixes for the collection and its items
 */
class CollectionTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return CollectionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['min', 'max']);
        $resolver->setDefaults([
            'label_add'    => 'Add',
            'label_delete' => 'Delete',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        foreach ($view as $child) {
            $this->addBlockPrefix($child, 'collection_item');
            $this->addBlockPrefix($child, $form->getName() . '_item');
        }

        if ($options['allow_add'] && $options['prototype']) {
            $prototype = $view->vars['prototype'];
            $this->addBlockPrefix($prototype, 'collection_item');
            $this->addBlockPrefix($prototype, $form->getName() . '_item');

            if ($prototype->vars['label'] == $options['prototype_name'].'label__') {
                $prototype->vars['label'] = $options['label'];
                $options['options']['label'] = $options['label'];
            }
        }

        if (isset($options['min'])) {
            $view->vars['attr']['data-collection-min'] = intval($options['min']);
        }

        if (isset($options['max'])) {
            $view->vars['attr']['data-collection-max'] = intval($options['max']);
        }

        $view->vars['label_add'] = $options['label_add'];
        $view->vars['label_delete'] = $options['label_delete'];
    }
}
