<?php

namespace app\core;

use app\interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    public function connect(): \mysqli{
        return new \mysqli(Env::config('DB_HOST'), Env::config('DB_USER'), Env::config('DB_PASS'), Env::config('DB_NAME'));
    }
}