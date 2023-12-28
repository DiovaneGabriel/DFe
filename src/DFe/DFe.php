<?php

namespace DFe;

use Entities\Emissor;

abstract class DFe
{

    const AMBIENTE_PRODUCAO = 1;
    const AMBIENTE_HOMOLOGACAO = 2;

    protected $xml;

    private int $ambiente;
    private Emissor $emissor;

    abstract public function cancelar(int $numero, int $serie, string $motivo);
    abstract public function emitir();

    abstract protected function getUrl();

    abstract public static function getInstance(Emissor $emissor, int $ambiente = self::AMBIENTE_HOMOLOGACAO);

    function __construct(Emissor $emissor, int $ambiente = self::AMBIENTE_HOMOLOGACAO)
    {
        $this->emissor = $emissor;
        $this->ambiente = $ambiente;
    }

    public function setAmbiente(int $ambiente)
    {
        $this->ambiente = $ambiente;
    }
    public function getAmbiente(): int
    {
        return $this->ambiente;
    }

    public function setEmissor(Emissor $emissor)
    {
        $this->emissor = $emissor;
    }
    public function getEmissor(): Emissor
    {
        return $this->emissor;
    }
}
