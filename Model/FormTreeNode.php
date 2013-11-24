<?php

namespace Elao\Bundle\FormBundle\Model;

/**
 * A node of the form Tree
 */
class FormTreeNode
{
	/**
	 * The name of the node
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Weither the node has labeled children or not.
	 *
	 * @var boolean
	 */
	private $children;

	/**
	 * Constructor
	 *
	 * @param  string  $name
	 * @param  boolean $children
	 */
	public function __construct($name, $children = false)
	{
		$this->name     = (string) $name;
		$this->children = (boolean) $children;
	}

	/**
	 * Get the name of the node
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the name of the node
	 *
	 * @return boolean
	 */
	public function hasChildren()
	{
		return $this->children;
	}
}
