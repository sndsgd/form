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


## Usage


#### Define a form

```php
<?php

use \sndsgd\form\field;
use \sndsgd\form\rule;

require __DIR__."/../vendor/autoload.php";

$form = (new \sndsgd\Form())
    ->addFields(
        (new field\ValueField("name"))
            ->setDescription(_("your name"))
            ->addRules(
                new rule\RequiredRule(),
                new rule\EmailRule()
            ),
        (new field\ValueField("email"))
            ->setDescription(_("your email address"))
            ->addRules(
                new rule\RequiredRule(),
                new rule\EmailRule()
            )
    );
```


#### Validate input

```php
$inputValues = [
    "name" => "",
    "email" => "asd@asd.com",
];

$validator = new \sndsgd\form\Validator($form);
try {
    $validatedValues = $validator->validate($inputValues);
    echo "all values were valid\n";
    json_encode($validatedValues, \sndsgd\Json::HUMAN);
} catch (\sndsgd\form\ValidationException $ex) {
    echo "validation errors encountered\n";
    json_encode($ex->getErrors(), \sndsgd\Json::HUMAN);
}
```


#### Get details for docs

```php
$detail = $form->getDetail();
echo json_encode($detail, \sndsgd\Json::HUMAN);
```
```json
[
    {
        "name": "name",
        "type": "string",
        "signature": "string",
        "description": "your name",
        "default": null,
        "rules": {
            "values": [
                {
                    "description": "required",
                    "errorMessage": "required"
                },
                {
                    "description": "email",
                    "errorMessage": "must be a valid email address"
                }
            ]
        }
    },
    {
        "name": "email",
        "type": "string",
        "signature": "string",
        "description": "your email address",
        "default": null,
        "rules": {
            "values": [
                {
                    "description": "required",
                    "errorMessage": "required"
                },
                {
                    "description": "email",
                    "errorMessage": "must be a valid email address"
                }
            ]
        }
    }
]
```


## Field Types


### Single Value Fields


#### `\sndsgd\form\field\ValueField`

This field type can be used to store a single value of various types. In most cases it'll be the base class for any custom fields that you want to create.

```php
$ageField = (new field\ValueField("age"))
    ->setDescription(_("The user's age in years"))
    ->addRules(
        new rule\IntegerRule(),
        new rule\MinRule(0),
        new rule\MaxRule(150)
    );
```

We've created several subclasses of `ValueField` for commonly used types. Note that whenever you use one of these fields, you can skip adding the corresponding type rule.

- `\sndsgd\form\field\BooleanField`
- `\sndsgd\form\field\FloatField`
- `\sndsgd\form\field\IntegerField`
- `\sndsgd\form\field\StringField`


### Multiple Value Fields

Whenever you need a field that will have multiple values, you'll need to define a field that will contain one or more fields for each value. This allows for each distinct value to be validated on its own, and then all values to be validated with each other.


#### `\sndsgd\form\field\ArrayField`

Use an `ArrayField` whenever you have a need for multiple values of the same type.

```php
$nicknamesValue = (new field\StringField())
    ->addRules(
        new rule\MaxLengthRule(64),
        (new rule\RegexRule("/^[a-z0-9 ]+$/i"))
            ->setErrorMessage(_("must contain only letters, numbers, or spaces"))
    );

$nicknamesField = (new field\ArrayField("nicknames", $nicknamesValue))
    ->setDescription(_("The user's nicknames"))
    ->addRules(
        new rule\MaxValueCountRule(5)
    );
```


#### \sndsgd\form\field\MapField

Use a `MapField` whenever you need to validate both the keys and values of an object.

```json
{
    "home": "+1 123-456-7890",
    "work": "+1 321-654-0987 x123"
}
```

```php
$phoneKey = (new field\StringField())
    ->setDescription(_("A label for a phone number"))
    ->addRule(new rule\AlphaNumRule());

$phoneValue = (new field\StringField())
    ->setDescription(_("A phone number"))
    ->addRule(new rule\MinLengthRule(10));

$phonesField = (new field\MapField("phoneNumbers", $phoneKey, $phoneValue))
    ->setDescription(_("The user's phone numbers"))
    ->addRule(new rule\MaxValueCountRule(5));
```


#### \sndsgd\form\field\ObjectField

Use `ObjectField` whenever you need to validate only the values of an object. It'll use the name of any fields you add to it as the keys.

```php
$field = (new field\ObjectField())
    ->addFields(
        $ageField,
        $nicknamesField,
        $phonesField
    );
```


## Documentation


```php
$detail = $field->getDetail();
echo json_encode($detail, \sndsgd\Json::HUMAN);
```
