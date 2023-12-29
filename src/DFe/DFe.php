<?php

namespace DFe;

use Entities\Emitente;
use Libraries\Constants;

abstract class DFe
{
    protected $xml;

    private int $ambiente;
    private Emitente $emitente;
    private string $urlWebservice;

    abstract public function cancelar(int $numero, int $serie, string $motivo);
    abstract public function emitir();

    function __construct(Emitente $emitente, int $ambiente = Constants::AMBIENTE_HOMOLOGACAO)
    {
        $this->setEmitente($emitente);
        $this->setAmbiente($ambiente);
    }

    /**
     * Get the value of ambiente
     */
    public function getAmbiente(): int
    {
        return $this->ambiente;
    }

    /**
     * Set the value of ambiente
     */
    public function setAmbiente(int $ambiente): self
    {
        $this->ambiente = $ambiente;

        return $this;
    }

    /**
     * Get the value of Emitente
     */
    public function getEmitente(): Emitente
    {
        return $this->emitente;
    }

    /**
     * Set the value of Emitente
     */
    public function setEmitente(Emitente $emitente): self
    {
        $this->emitente = $emitente;

        return $this;
    }

    /**
     * Get the value of urlWebservice
     */
    public function getUrlWebservice(): string
    {
        return $this->urlWebservice;
    }

    /**
     * Set the value of urlWebservice
     */
    public function setUrlWebservice(string $urlWebservice): self
    {
        $this->urlWebservice = $urlWebservice;

        return $this;
    }
}
