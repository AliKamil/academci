#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/../vendor/autoload.php';
use App\Console\Command;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Command());
$application->run();