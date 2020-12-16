<?php

require_once (ROOT . DS . 'config' . DS . 'app.php');

/** Check if environment is development and display errors **/
function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {} else {}
}
setReporting();

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
