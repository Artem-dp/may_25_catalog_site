<?php

namespace app\exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = "Route not found")
    {
        parent::__construct($message);
    }
}