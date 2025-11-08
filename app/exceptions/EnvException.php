<?php
    
namespace app\exceptions;

/**
 * Exception for .env file parser
 */
class EnvException extends \Exception
{
    public function __construct(string $message = "")
    {
        parent::__construct($message);
    }
}