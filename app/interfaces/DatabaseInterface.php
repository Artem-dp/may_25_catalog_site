<?php

namespace app\interfaces;

use mysqli;

/**
 * Interface for database connection management
 */
interface DatabaseInterface
{
    /**
     * Connect to database
     *
     * @return mysqli
     */
    public function connect(): mysqli;

}