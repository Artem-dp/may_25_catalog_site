<?php
define('ROOT_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR);

/**
 * class autoloader
 */
spl_autoload_register(function ($class){
   $file = ROOT_PATH . str_replace('\\', DIRECTORY_SEPARATOR, $class) . 'php';
   if (file_exists($file)){
       include_once $file;
       return true;
   }
   return false;
});