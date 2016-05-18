# sndsgd/form

[![Latest Version](https://img.shields.io/github/release/sndsgd/sndsgd-form.svg?style=flat-square)](https://github.com/sndsgd/sndsgd-form/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/sndsgd/sndsgd-form/LICENSE)
[![Build Status](https://img.shields.io/travis/sndsgd/sndsgd-form/master.svg?style=flat-square)](https://travis-ci.org/sndsgd/sndsgd-form)
[![Coverage Status](https://img.shields.io/coveralls/sndsgd/sndsgd-form.svg?style=flat-square)](https://coveralls.io/r/sndsgd/sndsgd-form?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/sndsgd/form.svg?style=flat-square)](https://packagist.org/packages/sndsgd/form)

Structured data validation for PHP.


## Requirements

This project is unstable and subject to changes from release to release. If you intend to depend on this project, be sure to make note of and specify the version in your project's `composer.json`. Doing so will ensure any breaking changes do not break your project.

You need **PHP >= 7.0** to use this library, however, the latest stable version of PHP is recommended.


## Install

Install `sndsgd/form` using [Composer](https://getcomposer.org/).

```
composer require sndsgd/form
```


## Examples

A simple login form

```php
<?php

use \sndsgd\form\field;
use \sndsgd\form\rule;

require __DIR__."/vendor/autoload.php";

$form = (new \sndsgd\Form())
    ->addFields(
        (new field\ValueField("email"))
            ->setDescription("your account email address")
            ->addRules(
                new rule\RequiredRule(),
                new rule\EmailRule()
            ),
        (new field\ValueField("password"))
            ->setDescription("your account password")
            ->addRules(
                new rule\RequiredRule()
            ),
        (new field\ValueField("remember"))
            ->setDescription("whether to create an extended session")
            ->setDefaultValue(false)
            ->addRules(
                new rule\BooleanRule()
            )
    );     

$inputValues = [
    "email" => "asd@asd.com",
    "password" => "thing",
    "remember" => 1,
];

$validator = new \sndsgd\form\Validator($form);
try {
    print_r($validator->validate($inputValues));
} catch (\sndsgd\form\ValidationException $ex) {
    print_r($ex->getErrors());
}
```
