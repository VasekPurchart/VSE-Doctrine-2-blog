<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;

// Load Nette Framework
require LIBS_DIR . '/Nette/Nette/loader.php';

// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon', Nette\Config\Configurator::NONE);
$container = $configurator->createContainer();

// Setup router
$container->router[] = new Route('index.php', array(
        'module' => 'Front',
        'presenter' => 'Article',
        'action' => 'default',
), Route::ONE_WAY);

$container->router[] = new Route('admin[/<presenter>[/<action>[/<id>]]]', array(
        'module' => 'Admin',
        'presenter' => 'Article',
        'action' => 'default',
        'id' => NULL,
));

$container->router[] = new Route('[<presenter>[/<action>[/<id>]]]', array(
        'module' => 'Front',
        'presenter' => 'Article',
        'action' => 'default',
        'id' => NULL,
));

// Configure and run the application!
$container->application->run();
