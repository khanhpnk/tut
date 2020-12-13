<?php
use LibraryLoaderAutoloader,
    LibraryViewView,
    LibraryViewCompositeView;

require_once __DIR__ . "/Library/Loader/Autoloader.php";
$autoloader = new Autoloader;
$autoloader->register();

$header = new View("header");
$header->content = "This is my fancy header section";
$header->ip = function () {
    return $_SERVER["REMOTE_ADDR"];
};

$body = new View("body");
$body->content = "This is my fancy body section";

$footer = new View("footer");
$footer->content = "This is my fancy footer section";

$compositeView = new CompositeView;

echo $compositeView->attachView($header)
    ->attachView($body)
    ->attachView($footer)
    ->render();