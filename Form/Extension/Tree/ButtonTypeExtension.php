<?php

namespace Elao\Bundle\FormBundle\Form\Extension\Tree;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ButtonTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'button';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->autoGenerate) {
            $resolver->replaceDefaults(array('label' => true));
        }
    }
}
