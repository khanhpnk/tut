<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

//require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');
    //require_once (ROOT . DS . 'config' . DS . 'config.php');
/** Check if environment is development and display errors **/

//function setReporting() {
//    if (DEVELOPMENT_ENVIRONMENT == true) {
//        error_reporting(E_ALL);
//        ini_set('display_errors','On');
//    } else {
//        error_reporting(E_ALL);
//        ini_set('display_errors','Off');
//        ini_set('log_errors', 'On');
//        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
//    }
//}
/** Autoload any classes that are required **/

//function __autoload($className) {
//    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
//        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
//    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
//        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
//    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
//        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
//    } else {
//        /* Error Generation Code Here */
//    }
//}



if(empty($controller)) {
    $controller = 'IndexController';
}

// if action is empty, redirect to index page
if(empty($action)) {
    $action = 'index';
}

$controller_name = $controller;
$controller = ucwords($controller);
$dispatch = new $controller($controller_name,$action);

var_dump($controller);
var_dump($action);
die;