# sndsgd/form

[![Latest Version](https://img.shields.io/github/release/sndsgd/form.svg?style=flat-square)](https://github.com/sndsgd/form/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/sndsgd/form/LICENSE)
[![Build Status](https://img.shields.io/travis/sndsgd/form/master.svg?style=flat-square)](https://travis-ci.org/sndsgd/form)
[![Coverage Status](https://img.shields.io/coveralls/sndsgd/form.svg?style=flat-square)](https://coveralls.io/r/sndsgd/form?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/sndsgd/form.svg?style=flat-square)](https://packagist.org/packages/sndsgd/form)

Structured data validation for PHP.


## Requirements

This project is unstable and subject to changes from release to release.

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
        (new field\StringField("name"))
            ->setDescription(_("The user's name"))
            ->addRules(
                new rule\RequiredRule()
            ),
        (new field\StringField("email"))
            ->setDescription(_("The user's email address"))
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
    "whoami" => "'whoami' should be unexpected",
];

$validator = new \sndsgd\form\Validator($form);
try {
    $values = $validator->validate($inputValues);
    $message = "all values were valid";
} catch (\sndsgd\form\ValidationException $ex) {
    $message = "validation errors encountered";
    $errors = $ex->getErrors();
}

echo json_encode([
    "message" => $message,
    "data" => $data ?? null,
    "errors" => $errors ?? [],
], \sndsgd\Json::HUMAN);

```
```json
{
    "message": "validation errors encountered",
    "data": null,
    "errors": [
        {
            "message": "required",
            "code": 0,
            "field": "name"
        },
        {
            "message": "unknown field",
            "code": 0,
            "field": "whoami"
        }
    ]
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
# this field defines what is expected for each value in the array
$nicknamesValue = (new field\StringField())
    ->addRules(
        new rule\MaxLengthRule(64),
        (new rule\RegexRule("/^[a-z0-9 ]+$/i"))
            ->setErrorMessage(_("must contain only letters, numbers, or spaces"))
    );

# create an array field as the parent of the value field
# note: the rules are for validating all values as a group; if you need to
# validated each value, add the relevant rules to thee value field
$nicknamesField = (new field\ArrayField("nicknames", $nicknamesValue))
    ->setDescription(_("The user's nicknames"))
    ->addRules(
        new rule\MaxValueCountRule(5)
    );
```


#### `\sndsgd\form\field\MapField`

Use a `MapField` whenever you need to validate both the keys and values of an object.

```php
# define what is expected for a key in the map
$phoneKey = (new field\StringField())
    ->setDescription(_("A label for a phone number"))
    ->addRule(new rule\AlphaNumRule());

# define what is expected for a value in the map
$phoneValue = (new field\StringField())
    ->setDescription(_("A phone number"))
    ->addRule(new rule\MinLengthRule(10));

# create a map field using the key and value fields
# as with the array field, any rules added to a map field are used for 
# validating all the values as a group
$phonesField = (new field\MapField("phoneNumbers", $phoneKey, $phoneValue))
    ->setDescription(_("The user's phone numbers"))
    ->addRule(new rule\MaxValueCountRule(5));
```


#### `\sndsgd\form\field\ObjectField`

Use `ObjectField` whenever you need to validate only the values of an object. It'll use the name of any fields you add to it as the keys.

```php
$field = (new field\ObjectField())
    ->addFields(
        $ageField,
        $nicknamesField,
        $phonesField
    );
```

#### 



## Documentation


```php
$detail = $field->getDetail();
echo json_encode($detail, \sndsgd\Json::HUMAN);
```
```json
[
    {
        "name": "age",
        "type": "int",
        "signature": "int",
        "description": "The user's age in years",
        "default": null,
        "rules": {
            "values": [
                {
                    "description": "type:integer",
                    "errorMessage": "must be an integer"
                },
                {
                    "description": "min:0",
                    "errorMessage": "must be at least 0"
                },
                {
                    "description": "max:150",
                    "errorMessage": "must be no greater than 150"
                }
            ]
        }
    },
    {
        "name": "nicknames",
        "type": "array",
        "signature": "array<string>",
        "description": "The user's nicknames",
        "default": [],
        "rules": {
            "values": [
                {
                    "description": "max-length:64",
                    "errorMessage": "must be no more than 64 characters"
                },
                {
                    "description": "regex:/^[a-z0-9 ]+$/i",
                    "errorMessage": "must contain only letters, numbers, or spaces"
                },
                {
                    "description": "max-values:5",
                    "errorMessage": "must be no more than 5 values"
                }
            ]
        }
    },
    {
        "name": "phoneNumbers",
        "type": "map",
        "signature": "map<string,string>",
        "description": "The user's phone numbers",
        "default": null,
        "rules": {
            "keys": [
                {
                    "description": "alphanumeric",
                    "errorMessage": "must contain only alphanumeric characters"
                }
            ],
            "values": [
                {
                    "description": "min-length:10",
                    "errorMessage": "must be at least 10 characters"
                },
                {
                    "description": "max-values:5",
                    "errorMessage": "must be no more than 5 values"
                }
            ]
        }
    }
]
```
