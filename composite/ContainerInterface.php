<?php
namespace LibraryView;

interface ContainerInterface
{
    public function __set($field, $value);
    public function __get($field);
    public function __isset($field);
    public function __unset($field);
}