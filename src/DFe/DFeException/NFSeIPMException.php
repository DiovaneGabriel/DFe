<?php

namespace DFe\DFeException;

use DFe\DFeException\NFSeException;

class NFSeIPMException extends NFSeException
{
    public function __construct(array $response)
    {
        $mensagem = "";
        foreach ($response as $i => $m) {
            $mensagem .= ($i > 0 ? "\n" : '') . trim($m);
        }

        parent::__construct($mensagem);
    }
}
