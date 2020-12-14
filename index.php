<?php
$url = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

// The first part of the URL is the controller name
$controller = isset($url[0]) ? $url[0] : '';
array_shift($url);

// The second part is the method name
$action = isset($url[0]) ? $url[0] : '';
array_shift($url);

// if controller is empty, redirect to default controller
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