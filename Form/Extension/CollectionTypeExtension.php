<?php

namespace Elao\Bundle\FormBundle\Form\Extension;

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
        $resolver->setOptional(
            array(
                'label_add',
                'label_delete',
            )
        );
    }
}
