<?php

require __DIR__."/../vendor/autoload.php";

$file = \sndsgd\Fs::file(__DIR__."/../README.md");
$blocks = [];
if (preg_match_all("/```php(.*?)```/ms", $file->read(), $matches, PREG_SET_ORDER)) {
    foreach ($matches as list($all, $code)) {
        $blocks[] = $code;
    }
}

$tempFile = \sndsgd\fs\Temp::createFile("example");
$contents = implode(PHP_EOL, $blocks).PHP_EOL;
$search = 'require __DIR__."/../vendor/autoload.php"';
$replace = 'require "'.realpath(__DIR__."/../vendor/autoload.php").'"';
$contents = str_replace($search, $replace, $contents);
$tempFile->write($contents);

require $tempFile;
