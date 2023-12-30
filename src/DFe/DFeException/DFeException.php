<?php

namespace DFe\DFeException;

use Exception;

class DFeException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
