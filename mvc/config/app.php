<?php
define ('DEVELOPMENT_ENVIRONMENT',true);

define('APP_NAME', 'Simple MVC');
define('APP_DOMAIN', 'http://192.168.50.20');
define('APP_INNER_DIRECTORY', '/mix/mvc');
define('APP_ROOT', __DIR__.'/..');

define('APP_CONTROLLER_NAMESPACE', 'Controller\\');
define('APP_DEFAULT_CONTROLLER', 'Home');
define('APP_DEFAULT_CONTROLLER_METHOD', 'index');
define('APP_CONTROLLER_METHOD_SUFFIX', 'Method');

define('DB_HOST', 'localhost');
define('DB_NAME', 'simplemvc');
define('DB_USER', 'root');
define('DB_PASS', 'root');
