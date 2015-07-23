<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Extension for the FormType, provides:
 * - Submit and Reset buttons
 */
class FormButtonTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(self::getButtons());
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $buttons = self::getButtons();
            $form    = $event->getForm();

            foreach ($buttons as $button) {
                if (isset($options[$button]) && $options[$button] && !$form->has($button)) {
                    $form->add($button, $button);
                }
            }
        });
    }

    /**
     * Get buttons
     *
     * @return array
     */
    private static function getButtons()
    {
        return array('submit', 'reset');
    }
}
