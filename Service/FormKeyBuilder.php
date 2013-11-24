<?php

namespace Elao\Bundle\FormBundle\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use Elao\Bundle\FormBundle\Model\FormTree;

/**
 * Responsible form building tree for forms.
 */
class FormKeyBuilder
{
    /**
     * Separator te be used between nodes
     *
     * @var string
     */
    protected $separator;

    /**
     * Prefix at the root of the key
     *
     * @var string
     */
    protected $root;

    /**
     * Prefix for children nodes
     *
     * @var string
     */
    protected $children;

    /**
     * Constructor
     *
     * @param string $separator
     * @param string $root
     * @param string $children
     */
    public function __construct($separator = ".", $root = "form", $children = "children")
    {
        $this->separator = $separator;
        $this->root      = $root;
        $this->children  = $children;
    }

    /**
     * Build the key corresponding to a given tree
     *
     * @param FormTree $tree   The tree
     * @param string   $parent Suffix for nodes that have children
     * @return string The key
     */
    public function buildKeyFromTree(FormTree $tree, $parent)
    {
        $key = array();

        if ($this->root) {
            $key[] = $this->root;
        }

        $last = count($tree) - 1;

        foreach ($tree as $index => $node) {
            $key[] = $node->getName();

            if ($node->hasChildren()) {
                $value = $last === $index ? $parent : $this->children;

                if ($value) {
                    $key[] = $value;
                }
            }
        }

        return implode($this->separator, $key);
    }
}
