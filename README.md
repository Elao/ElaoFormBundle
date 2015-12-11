ElaoFormBundle ![](https://img.shields.io/badge/Symfony-2.3-blue.svg)
==============

__Best served with [Elao/form.js](https://github.com/Elao/form.js)!__

Tools & enhancements for Symfony 2 forms

## Installation:

Add ElaoFormBundle to your `composer.json`:

``` json
{
    "require": {
        "elao/form-bundle": "0.2.*"
    }
}
```

Now download the bundle by running the command:

``` bash
$ php composer.phar update elao/form-bundle
```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Elao\Bundle\FormBundle\ElaoFormBundle(),
    );
}
```

## Usage:

Use the provided form template, globally:

``` yaml
# Twig Configuration
twig:
    form:
        resources:
            - "ElaoFormBundle:Form:form_elao_layout.html.twig"
```

Or on a specific form:

``` twig
{% form_theme form 'ElaoFormBundle:Form:form_elao_layout.html.twig' %}
```

## Features:

Collections:
------------

Provide support for collection:

	$('[data-collection]').collection();

_Note:_ For more details, see [Elao/form.js collection documentation](https://github.com/Elao/form.js/blob/master/doc/collection.md).

Help:
--------

Provide an `help` option that automatically adds an help block to the field.
Use as below:

	$builder->add('email', 'email', array('help' => "A valid email address"));

_Note:_ The `help` string is gonna be translated by default just like the label of the field.

Buttons:
--------

Provide sortcut for adding submit and reset buttons:
All form have now an optional option "submit" and "reset", setting it to true adds a default submit/reset button

	$form = $this->createForm('post', $post, array('submit' => true, 'reset' => true));

