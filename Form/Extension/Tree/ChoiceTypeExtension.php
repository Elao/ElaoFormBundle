<?php

namespace Elao\Bundle\FormBundle\Form\Extension\Tree;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->autoGenerate) {
            $resolver->replaceDefaults(array('empty_value' => true));
        }
    }
}
