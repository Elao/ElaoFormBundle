<?php

namespace Elao\Bundle\FormBundle\Service;

use Symfony\Component\Form\FormView;

/**
 * Responsible form building tree for forms.
 */
class FormTreeBuilder
{
	/**
	 * Form type with no children labels
	 * 
	 * @var array
	 */
	private $noChildren = array('date', 'time', 'datetime');

	/**
	 * Key for the label node in the tree
	 * 
	 * @var string
	 */
	private $labelKey = "label";

	/**
	 * Key for the children node in the tree
	 * 
	 * @var string
	 */
	private $childrenKey = "children";

	/**
	 * Build the given form a tree
	 * 
	 * @param FormView $view 
	 */
    public function buildTree(FormView &$view)
    {
    	return array_merge(
    		$this->getTree($view),
    		$this->getLabel($view)
    	);
    }

    private function getTree(FormView &$view)
    {
    	if ($view->parent === null || $view->vars['label']) {
    		return array();
    	}

		$tree = array_merge(
			$this->getTree($view->parent),
			$this->getChildPrefix($view->parent)
		);

    	return $tree;
    }

    private function getChildPrefix(FormView $view)
    {
    	$prefix = array($view->vars['label'] ?: $view->vars['name']);

    	if ($this->hasChildrenWithLabel($view)) {
    		$prefix[] = $this->childrenKey;
    	}

    	return $prefix;
    }

    /**
     * Get the name of the 
     * @param  FormView $view [description]
     * @return [type]         [description]
     */
    private function getLabel(FormView $view)
    {
    	$name = array(
    		 $view->vars[$this->labelKey] ?: $view->vars['name']
    	);

    	if ($this->hasChildrenWithLabel($view)) {
    		$name[] = $this->labelKey;
    	}

    	return $name;
    }

    /**
     * Test if the given form view has children with labels
     * 
     * @param FormView $view 
     * @return boolean        
     */
    private function hasChildrenWithLabel(FormView $view)
    {
    	if ($view->parent === null || !$view->vars['compound']) {
    		return false;
    	}

    	foreach ($view->vars['block_prefixes'] as $prefix) {
    		if (in_array($prefix, $this->noChildren)) {
    			return false;
    		}
    	}

    	return true;
    }
}