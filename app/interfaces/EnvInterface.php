<?php
    
namespace app\interfaces;

/**
 * Interface for .env file parser
 */
interface EnvInterface
{
    /**
     * @return void
     */
    static public function init() : void;

    /**
     * @param string $name
     * @return string
     */
    static public function config(string $name) : string;
}