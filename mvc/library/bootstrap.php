<?php

require_once (ROOT . DS . 'config' . DS . 'config.php');

/** Check if environment is development and display errors **/
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {} else {}
}
setReporting();

/** Autoload any classes that are required **/
function __autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'library' . DS . $className . '.php');
    } else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    }
}

$url = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
array_shift($url);array_shift($url);array_shift($url);

$controller = isset($url[0]) ? $url[0] : '';
array_shift($url);
$action = isset($url[0]) ? $url[0] : '';
array_shift($url);
$query = $url;


$controllerName = ucwords($controller) . 'Controller';
$controllerObject = new $controllerName($controller, $action);
$controllerObject->$action();
