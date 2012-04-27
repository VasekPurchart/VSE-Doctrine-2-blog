#!/usr/local/bin/php
<?php

// absolute filesystem path to the application root
define('APP_DIR', __DIR__ . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', __DIR__ . '/../libs');

// Load Nette Framework
require LIBS_DIR . '/Nette/Nette/loader.php';

// Configure application
$configurator = new Nette\Config\Configurator;

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(APP_DIR . '/config/config.neon', Nette\Config\Configurator::NONE);
$container = $configurator->createContainer();

$entityManager = $container->getByType('Doctrine\ORM\EntityManager');

// symfony console app helpers
$helperSet = new Symfony\Component\Console\Helper\HelperSet();
$helperSet->set(new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()), 'db');
$helperSet->set(new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager), 'em');

// symfony console app
$cli = new Symfony\Component\Console\Application('Doctrine Command Line Interface', Doctrine\ORM\Version::VERSION);
$cli->setCatchExceptions(FALSE);
$cli->setHelperSet($helperSet);
$cli->addCommands(array(
	// DBAL Commands
	new Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
	new Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

	// ORM Commands
	new Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
	new Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
	new Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
	new Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
	new Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
	new Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
	new Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
	new Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
	new Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
	new Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
));
$cli->run();
