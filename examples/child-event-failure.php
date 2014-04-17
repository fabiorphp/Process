<?php

declare(ticks=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Arara\Process\Action\Action;
use Arara\Process\Action\Callback;
use Arara\Process\Child;
use Arara\Process\Control;

$action = new Callback(function (Control $control) {
    throw new Exception('An exception was thrown');
});
$action->bind(Action::EVENT_FAILURE, function (Control $control, array $context) {
    echo 'Failure: ' . json_encode($context, (defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0)) . PHP_EOL;
});

$control = new Control();
$child = new Child($action, $control);
$child->start();
$child->wait();
