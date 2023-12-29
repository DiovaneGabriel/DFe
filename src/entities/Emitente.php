<?php

namespace Entities;

class Emitente extends Pessoa
{
    private string $senhaWebservice;
    private string $cidadeCodigoTom;

    function __construct(string $nome, string $cidadeCodigoIbge, string $cnpj, string $senhaWebservice)
    {
        parent::__construct($nome);

        $this->setCidadeCodigoIbge($cidadeCodigoIbge);
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

    /**
     * Get the value of cidadeCodigoTom
     */
    public function getCidadeCodigoTom(): string
    {
        return $this->cidadeCodigoTom;
    }

    /**
     * Set the value of cidadeCodigoTom
     */
    public function setCidadeCodigoTom(string $cidadeCodigoTom): self
    {
        $this->cidadeCodigoTom = $cidadeCodigoTom;

        return $this;
    }
}
