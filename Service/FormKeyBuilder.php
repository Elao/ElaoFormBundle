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
     * Prefix for prototype nodes
     *
     * @var string
     */
    protected $prototype;

    /**
     * Constructor
     *
     * @param string $separator
     * @param string $root
     * @param string $children
     */
    public function __construct($separator = ".", $root = "form", $children = "children", $prototype = "prototype")
    {
        $this->separator = $separator;
        $this->root      = $root;
        $this->children  = $children;
        $this->prototype = $prototype;
    }

    /**
     * Build the key corresponding to a given tree
     *
     * @param FormTree $tree   The tree
     * @param string   $parent Suffix for nodes that have children
     *
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

            if (!$node->isPrototype()) {
                $key[] = $node->getName();
            }

            $children = false;

            if ($node->hasChildren()) {
                $children = $node->isCollection() ? $this->prototype : $this->children;
            }

            $value = $last === $index ? $parent : $children;

            if ($value) {
                $key[] = $value;
            }
        }

        return implode($this->separator, $key);
    }
}
