<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = \App\DependencyContainer::i();

$boot = $container->getByType(\App\Boot::class); // o por nombre: $boot = $container->getByName('boot');
$boot->startup();

$output = $container->getByType(\App\UI\Output::class);
$output->show();
