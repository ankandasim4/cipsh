<?php

// Define the environment
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

// Error reporting
switch (ENVIRONMENT) {
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
		} else {
			error_reporting(E_ALL & ~E_NOTICE);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

// Paths
$system_path = '../system';
$application_folder = '../application';
$view_folder = '';

// Resolve the system path
if (($_temp = realpath($system_path)) !== FALSE) {
	$system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
	$system_path = rtrim($system_path, '/') . DIRECTORY_SEPARATOR;
}

if (!is_dir($system_path)) {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

// Main path constants
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', str_replace('\\', '/', $system_path));
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SYSDIR', trim(strrchr(trim(BASEPATH, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR));

if (is_dir($application_folder)) {
	define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);
} else {
	if (!is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
		exit(3); // EXIT_CONFIG
	}

	define('APPPATH', BASEPATH . $application_folder . DIRECTORY_SEPARATOR);
}

if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
	if (($_temp = realpath($view_folder)) !== FALSE) {
		$view_folder = $_temp;
	} else {
		$view_folder = rtrim($view_folder, '/\\');
	}
} elseif (!is_dir(BASEPATH . $view_folder . DIRECTORY_SEPARATOR)) {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);

// Load the Composer autoload file
require_once FCPATH . '../vendor/autoload.php';

// Load the bootstrap file
require_once BASEPATH . 'core/CodeIgniter.php';
