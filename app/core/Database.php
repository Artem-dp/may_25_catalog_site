<?php

namespace app\core;

use app\interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    public function connect(): \mysqli{
        return new \mysqli('localhost', 'root', 'root', 'may_0000');
    }
}