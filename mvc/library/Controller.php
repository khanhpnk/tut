<?php


class Controller
{
    private $template;

    public function __construct($controller, $action) {
        $this->template = new Template($controller,$action);
    }

    function __destruct() {
        $this->template->render();
    }
}