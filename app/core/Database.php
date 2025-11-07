<?php

namespace app\core;

use app\interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    public function connect(): \mysqli{
        return new \mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
    }
}