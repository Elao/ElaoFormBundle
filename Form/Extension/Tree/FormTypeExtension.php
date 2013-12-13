<?php

namespace Elao\Bundle\FormBundle\Form\Extension\Tree;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormTypeExtension extends TreeAwareExtension
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
        $resolver->setDefaults(array('help' => false));

        if ($this->autoGenerate) {
            $resolver->replaceDefaults(array('label' => true));
        }
    }
}