<?php

/*
 * Start output buffering
 */
ob_start();

/*
 * maximize memory limit
 */
ini_set('memory_limit', -1);

/*
 * set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting( E_ALL | E_STRICT );

/*
 * set default timezone
 */
date_default_timezone_set('GMT');

/*
 * set base path
 */
defined('BASE_PATH')
    or define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

/*
 * set application path
 */
defined('APPLICATION_PATH')
    or define('APPLICATION_PATH', BASE_PATH . '/application');

/*
 * set application enviroment
 */
defined('APPLICATION_ENV')
    or define('APPLICATION_ENV', 'testing');

/*
 * set test path
 */
defined('TEST_PATH')
    or define('TEST_PATH', BASE_PATH . '/tests');

/*
 * define datestamp if we want to log
 * @todo JEB move this to a config of some kind
 */
defined('APPLICATION_DATESTAMP_LOGROTATE')
    or define('APPLICATION_DATESTAMP_LOGROTATE', date('Ymd'));

/*
 * setup include path to include our abstract application tests & library
 */
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(TEST_PATH . '/application'),
    realpath(BASE_PATH . '/library'),
    get_include_path(),
)));

/**
 * Zend Autoloader
 */
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
