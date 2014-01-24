<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Exention for the FormType, provides:
 * - Other choice feature
 */
class FormOtherTypeExtension extends AbstractTypeExtension
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
        $resolver->setOptional(array('other_choice', 'visible'));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['other_choice'])) {
            if (isset($options['other_choice']['trigger'])) {
                $options['other_choice'] = array($options['other_choice']);
            }

            foreach ($options['other_choice'] as $other) {
                $this->checkExists($form, $other['trigger']);
                $this->checkExists($form, $other['target']);

                if ($view[$other['trigger']]->vars['value'] != $other['value']) {
                    $view[$other['target']]->vars['visible'] = false;
                }

                $attr = array(
                    'data-other-value'   => json_encode($other['value']),
                    'data-other-trigger' => json_encode($this->getIdentifier($view[$other['trigger']])),
                    'data-other-target'  => $view[$other['target']]->vars['id'] . '-group',
                );

                $view[$other['trigger']]->vars['attr'] = array_merge($view[$other['trigger']]->vars['attr'], $attr);
            }
        }
    }

    /**
     * Check that the given form has the given child
     *
     * @param FormInterface $form  The form
     * @param string        $child The child
     *
     * @throws \Exception If the child can't be found
     */
    private function checkExists(FormInterface $form, $child)
    {
        if (!$form->has($child)) {
            throw new \Exception(sprintf("Uknow field '%s' in form '%s'", $child, $form->getName()));
        }
    }

    /**
     * Get identifier
     *
     * @param FormView $view The FormView
     *
     * @return array
     */
    private function getIdentifier(FormView $view, $idSuffix = null)
    {
        $multiple = isset($view->vars['multiple']) && $view->vars['multiple'];
        $expanded = isset($view->vars['expanded']) && $view->vars['expanded'];

        return array(
            'id'   => $view->vars['id'],
            'name' => $view->vars['full_name'] . ($multiple && $expanded ? '[]' : null),
        );
    }
}
