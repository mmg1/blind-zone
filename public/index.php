<?php

// session start
ini_set('session.cookie_httponly', 1);
session_start();

// set a constant that holds the project's folder path, like "/var/www/".
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

// set domain
define('DOMAIN', 'blind.zone');

// load application config (error reporting etc.)
require APP . 'config/config.php';

// load application class
require APP . 'core/application.php';
require APP . 'core/controller.php';

// create token for csrf protection
if(empty($_SESSION['token']))
	$_SESSION['token'] = bin2hex(random_bytes(16));

// start the application
$app = new Application(true, ['127.0.0.1']);
