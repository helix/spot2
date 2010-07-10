<?php
/**
 * @package Spot
 * @link http://spot.os.ly
 */

if (!file_exists(dirname(__FILE__).'/config.php')) {
	$error =<<<EOF
Error: config.php not found !
1. In the tests directory, copy "config.example.php" to "config.php"
2. Fill "config.php" with good parameters
3. Launch the tests-suite with : "phpunit tests/AllTests.php"
EOF;
	die("$error\n");
}
$GLOBALS['cfg'] = require_once 'config.php';

# Include path
$GLOBALS['cfg']['include_path'][] = get_include_path();
set_include_path(join(PATH_SEPARATOR, $GLOBALS['cfg']['include_path']));

// Require PHPUnit
require_once 'PHPUnit/Framework.php';

// Require Spot_Config
require_once 'Spot/Config.php';

// Date setup
date_default_timezone_set('America/Chicago');


/**
 * Setup available adapters for testing
 */
$spotConfig = new Spot_Config();

// MySQL
$cnf =& $GLOBALS['cfg']['adapter']['mysql'];
$adapter = $spotConfig->addConnection('test_mysql', sprintf('mysql://%s:%s@%s/%s', $cnf['user'], $cnf['pass'], $cnf['host'], $cnf['db']));

// MongoDB with adapter options
$cnf =& $GLOBALS['cfg']['adapter']['mysql'];
$adapter = $spotConfig->addConnection('test_mongodb', sprintf('mongodb://%s:%s', $cnf['host'], $cnf['port']), array(
	'cursor' => array(
		'timeout' => 10
	),
	'mapper' => array(
		'translate_id' => true
	)
));


/**
 * Return Spot mapper for use
 */
$mapper = new Spot_Mapper($spotConfig);
function test_spot_mapper() {
	global $mapper;
	return $mapper;
}


/**
 * Autoload test fixtures
 */
function test_spot_autoloader($className) {
	// Don't attempt to autoload PHPUnit classes
	if(strpos($className, 'PHPUnit') !== false) {
		return false;
	}
	$classFile = str_replace('_', '/', $className) . '.php';
	require dirname(__FILE__) . '/' . $classFile;
}
spl_autoload_register('test_spot_autoloader');