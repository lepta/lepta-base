<?php
define('DS', DIRECTORY_SEPARATOR);
/*
 * shortcut for $_SERVER['DOCUMENT_ROOT'];
 */
define('ROOT', str_replace('\\',DS,dirname(__FILE__)) . DS);

/**
 *  application path
 */
define('APP_PATH', ROOT . 'application' . DS);

/**
 * define system path, where all the system libs and framework components are
 */
define('SYSTEM_PATH', ROOT . 'system' . DS);

/**
 * define the path to the basic framework components
 */
define('BASESYS_PATH', SYSTEM_PATH . 'basic' . DS);

/**
 * defines the app mode
 */
define('DEBUG', true);

DEBUG ? error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT) : error_reporting(0);

/**
 * register the autoloader
 */
require_once BASESYS_PATH . "Autoloader.php";

/**
 * init the application
 */
try {
    $app = \system\App::getInstance();
    $app->run();
} catch (\system\basic\exceptions\BaseException $e) {
    DEBUG ? var_dump( $e->getTrace() ) : '';
    die($e->getMessage());
}
register_shutdown_function('fatal_handler');

function fatal_handler()
{
    $error = error_get_last();

    if( $error !== NULL) {
        $errno   = $error["type"];
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr  = $error["message"];
    }

    $f = fopen(ROOT . 'logs/fatal.log', 'a+');
    fwrite($f, $errstr . ' - ' . $errno . ' - ' . $errfile . ' - ' . $errline . ' - ' . "\n");
    fclose($f);
}