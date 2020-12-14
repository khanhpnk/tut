<?php
$url = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

$controller = isset($url[0]) ? $url[0] : '';
array_shift($url);
$action = isset($url[0]) ? $url[0] : '';
array_shift($url);
$query = $url;