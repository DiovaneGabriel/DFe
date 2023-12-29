<?php

namespace Entities;

abstract class Pessoa
{
    private $cidadeCodigoIbge;
    private $cnpj;
    private $cpf;
    private $nome;

    function __construct($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of cidadeCodigoIbge
     */
    public function getCidadeCodigoIbge()
    {
        return $this->cidadeCodigoIbge;
    }

    /**
     * Set the value of cidadeCodigoIbge
     */
    public function setCidadeCodigoIbge($cidadeCodigoIbge): self
    {
        $this->cidadeCodigoIbge = $cidadeCodigoIbge;

        return $this;
    }

    /**
     * Get the value of cnpj
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set the value of cnpj
     */
    public function setCnpj($cnpj): self
    {
        $this->cnpj = preg_replace("/[^0-9]/", "", $cnpj);

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf($cpf): self
    {
        $this->cpf = preg_replace("/[^0-9]/", "", $cpf);

        return $this;
    }
}
