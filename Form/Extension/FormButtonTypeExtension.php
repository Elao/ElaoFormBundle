<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        $resolver->setOptional(self::getButtons());
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $buttons = self::getButtons();

        foreach ($buttons as $button) {
            if (isset($options[$button]) && $options[$button] && !$builder->has($button)) {
                $builder->add('submit', 'submit');
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
