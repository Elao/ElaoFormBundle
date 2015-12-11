<?php

/**
 * This file is part of the ElaoForm bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormBundle\Form\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractTypeExtension as Base;

/**
 * Abstract Type Extension
 */
abstract class AbstractTypeExtension extends Base
{
    /**
     * Add block prefix
     *
     * @param FormView $view
     * @param string $blockPrefix
     */
    protected function addBlockPrefix(FormView $view, $blockPrefix)
    {
        if (!in_array($blockPrefix, $view->vars['block_prefixes'])) {
            $view->vars['block_prefixes'][] = $blockPrefix;
        }
    }
}
