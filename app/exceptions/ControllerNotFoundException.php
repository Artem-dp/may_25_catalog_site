<?php

namespace app\exceptions;

class ControllerNotFoundException extends \Exception
{
    public function __construct($controller)
    {
        parent::__construct("Controller '$controller' not found");
    }

}