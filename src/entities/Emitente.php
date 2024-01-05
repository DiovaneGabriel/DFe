<?php

namespace DBarbieri\DFe\Entities;

class Emitente extends Pessoa
{
    private string $senhaWebservice;

    function __construct(string $nome, string $cidadeCodigoIbge, string $cnpj, string $senhaWebservice)
    {
        parent::__construct($nome);

        $this->setEnderecoCidadeCodigoIbge($cidadeCodigoIbge);
        $this->setSenhaWebservice($senhaWebservice);

        $this->setCnpj($cnpj);
    }

    /**
     * Get the value of senhaWebservice
     */
    public function getSenhaWebservice(): string
    {
        return $this->senhaWebservice;
    }

    /**
     * Set the value of senhaWebservice
     */
    public function setSenhaWebservice(string $senhaWebservice): self
    {
        $this->senhaWebservice = $senhaWebservice;

        return $this;
    }
}
