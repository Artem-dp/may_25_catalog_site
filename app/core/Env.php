<?php

namespace app\core;

use app\exceptions\EnvException;
use app\interfaces\EnvInterface;

/**
 * .env file parser
 */
class Env implements EnvInterface
{
    /**
     * @return void
     * @throws EnvException
     */
    static public function init() : void
    {
        $file = ROOT_PATH . '.env';
        
        if(!file_exists($file)){
            throw new EnvException('.ENV file not found');
        }
        
        $confString = file_get_contents($file);
    
        if ($confString === false) {
            throw new EnvException('Failed to read .ENV file');
        }
        
        $rowList = explode(PHP_EOL, $confString);
        $rows = array_filter($rowList, function ($row){
            return !empty($row) && !str_starts_with($row, '#');
        });
        
        foreach ($rows as $row){
            $rowComponents = explode('=', $row);
            
            array_walk($rowComponents, function (&$component){
                $component = trim($component);
            });

            putenv(implode('=', $rowComponents));
        }
    }

    /**
     * @param string $name
     * @return string
     * @throws EnvException
     */
    static public function config(string $name) : string
    {
        $value = getenv($name);

        if ($value === false) {
            throw new EnvException("Environment variable '{$name}' not found");
        }

        return $value;
    }
}