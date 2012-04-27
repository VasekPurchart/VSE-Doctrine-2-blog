<?php

// absolute filesystem path to the application root
define('APP_DIR', __DIR__ . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', __DIR__ . '/../libs');

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

$em = $container->getByType('Doctrine\ORM\EntityManager');

//$hash = \MyBlog\Authenticator::calculateHash('test');
//$user = new \MyBlog\Author();
//$user->setName('Vašek Purchart');
//$user->setPasswordHash($hash);
//
//$em->persist($user);
//$em->flush();

$author = $em->find('MyBlog\Author', 1);
$articles = $em->getRepository('MyBlog\Article')->findAll();
foreach($articles as $article) {
	$article->setAuthor($author);
}
$em->flush();

