<?php

namespace Entities;

class Emissor extends Pessoa
{
    private $senhaWebservice;

    function __construct($nome, $cidadeCodigoIbge, $cnpj, $senhaWebservice)
    {
        parent::__construct($nome);
        $this->cidadeCodigoIbge = $cidadeCodigoIbge;
        $this->senhaWebservice = $senhaWebservice;

        $this->setCnpj($cnpj);
    }

    public function getSenhaWebservice()
    {
        return $this->senhaWebservice;
    }

    public function getCidadeCodigoTom()
    {
        $codes = ["4319901" => "8899"];

        return $codes[$this->getCidadeCodigoIbge()];
    }
}
