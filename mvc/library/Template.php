<?php


class Template
{
    protected $controller;
    protected $action;

    function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
    }

    function render() {
//        extract($this->variables);
        include (ROOT . DS . 'app' . DS . 'views' . DS . $this->controller . DS . $this->action . '.php');
    }
}