ElaoFormBundle
==============

Collections:
------------

Provide support for collection:

	$('[data-collection]').each(function (key, element) { new Collection(element); });

Buttons:
--------

Provide sortcut for adding submit and reset buttons:
All form have now an optional option "submit" and "reset", setting it to true adds a default submit/reset button

	$form = $this->createForm('post', $post, array('submit' => true, 'reset' => true));

Automatic 'other' field display:
--------------------------------

Add an "**other_choice**" option to forms allowing you to set a trigget/target field display based on values.

The "**other_choice**" expect 3 keys:

* __trigger__ (string): The field that value should be watched
* __target__ (string): The field to hide/show
* __value__ (scalar|array): The value(s) that should display the 'target' field

In the following example, the "state" entity only when the selected country is 'us':

	<?php

	namespace Acme\DemoBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;

	class AddressType extends AbstractType
	{
	    /**
	     * @param FormBuilderInterface $builder
	     * @param array $options
	     */
	    public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	    	$builder
		    	->add(
		    		'country',
		    		'choice',
		    		array(
		    			'choices' => array(
		    				'us' => 'USA',
		    				'gb' => 'Great Britain',
		    				'fr' => 'France'
		    			)
		    		)
		    	)
		    	->add('state');
	    }

	    /**
	     * @param OptionsResolverInterface $resolver
	     */
	    public function setDefaultOptions(OptionsResolverInterface $resolver)
	    {
	        $resolver->setDefaults(array(
	            'data_class'   => 'Acme\DemoBundle\Entity\Address',
	            'other_choice' => ['trigger' => 'country', 'target' => 'state', 'value' => 'us'],
	        ));
	    }
	}
