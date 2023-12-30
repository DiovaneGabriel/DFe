<?php

namespace DFe;

use DateTime;
use Entities\Emitente;
use Libraries\Constants;

abstract class DFe
{

    private int $ambiente;
    private Emitente $emitente;
    private int $numero = 0;
    private string $observacao = "";
    private string $protocoloAutorizacao = "";
    private string $protocoloCancelamento = "";
    private string $serie = "";
    private int $situacao = 0;
    private float $valor = 0;
    private float $valorCofins = 0;
    private float $valorDesconto = 0;
    private float $valorPis = 0;
    private string $xml = "";

    private ?DateTime $dataEmissao = null;
    private ?DateTime $dataCancelamento = null;

    abstract public function cancelar(string $motivo, int $numero = null, int $serie = null);
    abstract public function emitir();

    function __construct(Emitente $emitente, int $ambiente = Constants::AMBIENTE_HOMOLOGACAO)
    {
        $this->setAmbiente($ambiente);
        $this->setEmitente($emitente);
    }

    /**
     * Get the value of xml
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Set the value of xml
     */
    public function setXml($xml): self
    {
        $this->xml = $xml;

        return $this;
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
     * Get the value of emitente
     */
    public function getEmitente(): Emitente
    {
        return $this->emitente;
    }

    /**
     * Set the value of emitente
     */
    public function setEmitente(Emitente $emitente): self
    {
        $this->emitente = $emitente;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     */
    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of observacao
     */
    public function getObservacao(): string
    {
        return $this->observacao;
    }

    /**
     * Set the value of observacao
     */
    public function setObservacao(string $observacao): self
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get the value of protocoloAutorizacao
     */
    public function getProtocoloAutorizacao(): string
    {
        return $this->protocoloAutorizacao;
    }

    /**
     * Set the value of protocoloAutorizacao
     */
    public function setProtocoloAutorizacao(string $protocoloAutorizacao): self
    {
        $this->protocoloAutorizacao = $protocoloAutorizacao;

        return $this;
    }

    /**
     * Get the value of protocoloCancelamento
     */
    public function getProtocoloCancelamento(): string
    {
        return $this->protocoloCancelamento;
    }

    /**
     * Set the value of protocoloCancelamento
     */
    public function setProtocoloCancelamento(string $protocoloCancelamento): self
    {
        $this->protocoloCancelamento = $protocoloCancelamento;

        return $this;
    }

    /**
     * Get the value of serie
     */
    public function getSerie(): string
    {
        return $this->serie;
    }

    /**
     * Set the value of serie
     */
    public function setSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get the value of situacao
     */
    public function getSituacao(): int
    {
        return $this->situacao;
    }

    /**
     * Set the value of situacao
     */
    public function setSituacao(int $situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get the value of valor
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     */
    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of valorCofins
     */
    public function getValorCofins(): float
    {
        return $this->valorCofins;
    }

    /**
     * Set the value of valorCofins
     */
    public function setValorCofins(float $valorCofins): self
    {
        $this->valorCofins = $valorCofins;

        return $this;
    }

    /**
     * Get the value of valorDesconto
     */
    public function getValorDesconto(): float
    {
        return $this->valorDesconto;
    }

    /**
     * Set the value of valorDesconto
     */
    public function setValorDesconto(float $valorDesconto): self
    {
        $this->valorDesconto = $valorDesconto;

        return $this;
    }

    /**
     * Get the value of valorPis
     */
    public function getValorPis(): float
    {
        return $this->valorPis;
    }

    /**
     * Set the value of valorPis
     */
    public function setValorPis(float $valorPis): self
    {
        $this->valorPis = $valorPis;

        return $this;
    }

    /**
     * Get the value of dataEmissao
     */
    public function getDataEmissao(): ?DateTime
    {
        return $this->dataEmissao;
    }

    /**
     * Set the value of dataEmissao
     */
    public function setDataEmissao(?DateTime $dataEmissao): self
    {
        $this->dataEmissao = $dataEmissao;

        return $this;
    }

    /**
     * Get the value of dataCancelamento
     */
    public function getDataCancelamento(): ?DateTime
    {
        return $this->dataCancelamento;
    }

    /**
     * Set the value of dataCancelamento
     */
    public function setDataCancelamento(?DateTime $dataCancelamento): self
    {
        $this->dataCancelamento = $dataCancelamento;

        return $this;
    }
}
