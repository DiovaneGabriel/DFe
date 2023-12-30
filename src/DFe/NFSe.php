<?php

namespace DFe;

use DateTime;
use Entities\Emitente;
use Entities\NFSeItem;
use Entities\Parameters;
use Entities\Pessoa;
use Libraries\Constants;

abstract class NFSe extends DFe
{
    private array $itens = [];
    private int $numeroRps = 0;
    private string $urlDanfse = "";
    private float $valorContribuicaoSocial = 0;
    private float $valorInss = 0;
    private float $valorIr = 0;
    private float $valorRps = 0;

    private ?DateTime $dataFatoGerador = null;
    private ?Pessoa $tomador = null;

    public static function getInstance(Emitente $emitente, int $ambiente = Constants::AMBIENTE_HOMOLOGACAO): NFSe
    {
        $className = Parameters::getClasseNFSeFromCidade($emitente->getEnderecoCidadeCodigoIbge());
        return new $className($emitente, $ambiente);
    }

    /**
     * Get the value of itens
     */
    public function getItens(): array
    {
        return $this->itens;
    }

    /**
     * Set the value of itens
     */
    public function setItens(array $itens): self
    {
        $this->itens = [];

        foreach ($itens as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    public function addItem(NFSeItem $item): self
    {
        $this->itens[] = $item;

        return $this;
    }

    /**
     * Get the value of numeroRps
     */
    public function getNumeroRps(): int
    {
        return $this->numeroRps;
    }

    /**
     * Set the value of numeroRps
     */
    public function setNumeroRps(int $numeroRps): self
    {
        $this->numeroRps = $numeroRps;

        return $this;
    }

    /**
     * Get the value of urlDanfse
     */
    public function getUrlDanfse(): string
    {
        return $this->urlDanfse;
    }

    /**
     * Set the value of urlDanfse
     */
    public function setUrlDanfse(string $urlDanfse): self
    {
        $this->urlDanfse = $urlDanfse;

        return $this;
    }

    /**
     * Get the value of valorContribuicaoSocial
     */
    public function getValorContribuicaoSocial(): float
    {
        return $this->valorContribuicaoSocial;
    }

    /**
     * Set the value of valorContribuicaoSocial
     */
    public function setValorContribuicaoSocial(float $valorContribuicaoSocial): self
    {
        $this->valorContribuicaoSocial = $valorContribuicaoSocial;

        return $this;
    }

    /**
     * Get the value of valorInss
     */
    public function getValorInss(): float
    {
        return $this->valorInss;
    }

    /**
     * Set the value of valorInss
     */
    public function setValorInss(float $valorInss): self
    {
        $this->valorInss = $valorInss;

        return $this;
    }

    /**
     * Get the value of valorIr
     */
    public function getValorIr(): float
    {
        return $this->valorIr;
    }

    /**
     * Set the value of valorIr
     */
    public function setValorIr(float $valorIr): self
    {
        $this->valorIr = $valorIr;

        return $this;
    }

    /**
     * Get the value of valorRps
     */
    public function getValorRps(): float
    {
        return $this->valorRps;
    }

    /**
     * Set the value of valorRps
     */
    public function setValorRps(float $valorRps): self
    {
        $this->valorRps = $valorRps;

        return $this;
    }

    /**
     * Get the value of dataFatoGerador
     */
    public function getDataFatoGerador(): ?DateTime
    {
        return $this->dataFatoGerador;
    }

    /**
     * Set the value of dataFatoGerador
     */
    public function setDataFatoGerador(?DateTime $dataFatoGerador): self
    {
        $this->dataFatoGerador = $dataFatoGerador;

        return $this;
    }

    /**
     * Get the value of tomador
     */
    public function getTomador(): ?Pessoa
    {
        return $this->tomador;
    }

    /**
     * Set the value of tomador
     */
    public function setTomador(?Pessoa $tomador): self
    {
        $this->tomador = $tomador;

        return $this;
    }
}
