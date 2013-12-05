ElaoFormBundle
==============

Collections:
------------

Provide support for collection:

	$('[data-collection]').each(function (key, element) { new Collection(element); });

Buttons:
------------

Provide sortcut for adding submit and reset buttons:
All form have now an optional option "submit" and "reset", setting it to true adds a default submit/reset button

	$form = $this->createForm('post', $post, array('submit' => true, 'reset' => true));

The Form Tree:
--------------

The Form Tree feature provide a nice way of generating logic translation keys for form fields.
It's used mainly to generate automatic labels on fields but can be use to built any key.

_For example, for a given form RegisterType named "register" the key for its field 'email' would be "form.register.email.label"._

The way keys are built can be customized to suit your needs:

#### Customize the keys:

	elao_form:
	    tree:
			blocks:
	            # Prefix for children nodes
	            children: 	"children"
	            
	            # Prefix for prototype nodes
	            prototype: 	"prototype"

	            # Prefix at the root of the key
	            root: 		"form"

	            # Separator te be used between nodes
	            separator: 	"."

#### Labels

If you set the for the "label" option of a form field to __true__, a key will be generated and set as the field label.

__Otherwise: We don't touch your label!__

If you want to generate keys for all you label you can set the use the "auto_generate_label" option :

	elao_form:
	    tree:
	        auto_generate: true

This will set default label value to __true__ so keys will be generated for every labels.
If you still need to set some specific fields a custom label, easy: set the label otpion in the form and that value will be used, no key will be generated.

#### Default configuration:

	elao_form:
	    tree:
	        enabled: true

	        # Generate translation keys for all missing labels
	        auto_generate_label: false

	        # Customize available keys
	        keys:
		        form:
		        	label: 	"label"
		        	help:  	"help"
		        	# Add yours ...
		        collection:
		        	label_add: 		"label_add"
		        	label_delete: 	"label_delete"
		        	# Add yours ...

	        # Customize the ways keys are built
	        blocks:

	            # Prefix for prototype nodes
	            prototype: 	"prototype"

	            # Prefix for children nodes
	            children: 	"children"

	            # Prefix at the root of the key
	            root: 		"form"

	            # Separator te be used between nodes
	            separator: 	"."

#### Desactivate the Tree feature:

You can simply desactivate the whole Tree feature:

	elao_form:
	    tree: false
