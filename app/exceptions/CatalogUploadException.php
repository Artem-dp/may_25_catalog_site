<?php

namespace app\exceptions;

class CatalogUploadException extends \Exception
{
    public function __construct($message = "Upload error")
    {
        parent::__construct($message);
    }
}