<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Exention for the FormType, provides:
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefined(self::getButtons());
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $buttons = self::getButtons();

        foreach ($buttons as $button) {
            if (isset($options[$button]) && $options[$button] && !$builder->has($button)) {
                $builder->add($button, $button);
            }
        }
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
