<?php

namespace Entities;

abstract class Pessoa
{
    protected $nome;
    protected $cidadeCodigoIbge;

    private $cnpj;
    // private $cpf;

    function __construct($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCidadeCodigoIbge()
    {
        return $this->cidadeCodigoIbge;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = preg_replace("/[^0-9]/", "", $cnpj);
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }
}
