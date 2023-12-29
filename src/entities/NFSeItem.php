<?php

namespace Entities;

class NFSeItem
{
    private int $tributacaoMunicipioTomador;
    private float $valor;
    private string $codigo;
    private string $codigoAtividade;
    private string $descricao;
    private float $aliquota;
    private int $situacaoTributaria;
    private float $valorTributavel;
    private float $valorDeducao;
    private float $valorIssrf;

    public function __construct(string $descricao)
    {
        $this->setDescricao($descricao);

        $this->setTributacaoMunicipioTomador(0);
        $this->setValor(0);
        $this->setCodigo('');
        $this->setCodigoAtividade('');
        $this->setAliquota(0);
        $this->setSituacaoTributaria(0);
        $this->setValorTributavel(0);
        $this->setValorDeducao(0);
        $this->setValorIssrf(0);
    }

    /**
     * Get the value of tributacaoMunicipioTomador
     */
    public function getTributacaoMunicipioTomador(): int
    {
        return $this->tributacaoMunicipioTomador;
    }

    /**
     * Set the value of tributacaoMunicipioTomador
     */
    public function setTributacaoMunicipioTomador(int $tributacaoMunicipioTomador): self
    {
        $this->tributacaoMunicipioTomador = $tributacaoMunicipioTomador;

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
     * Get the value of codigo
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of codigoAtividade
     */
    public function getCodigoAtividade(): string
    {
        return $this->codigoAtividade;
    }

    /**
     * Set the value of codigoAtividade
     */
    public function setCodigoAtividade(string $codigoAtividade): self
    {
        $this->codigoAtividade = $codigoAtividade;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of aliquota
     */
    public function getAliquota(): float
    {
        return $this->aliquota;
    }

    /**
     * Set the value of aliquota
     */
    public function setAliquota(float $aliquota): self
    {
        $this->aliquota = $aliquota;

        return $this;
    }

    /**
     * Get the value of situacaoTributaria
     */
    public function getSituacaoTributaria(): int
    {
        return $this->situacaoTributaria;
    }

    /**
     * Set the value of situacaoTributaria
     */
    public function setSituacaoTributaria(int $situacaoTributaria): self
    {
        $this->situacaoTributaria = $situacaoTributaria;

        return $this;
    }

    /**
     * Get the value of valorTributavel
     */
    public function getValorTributavel(): float
    {
        return $this->valorTributavel;
    }

    /**
     * Set the value of valorTributavel
     */
    public function setValorTributavel(float $valorTributavel): self
    {
        $this->valorTributavel = $valorTributavel;

        return $this;
    }

    /**
     * Get the value of valorDeducao
     */
    public function getValorDeducao(): float
    {
        return $this->valorDeducao;
    }

    /**
     * Set the value of valorDeducao
     */
    public function setValorDeducao(float $valorDeducao): self
    {
        $this->valorDeducao = $valorDeducao;

        return $this;
    }

    /**
     * Get the value of valorIssrf
     */
    public function getValorIssrf(): float
    {
        return $this->valorIssrf;
    }

    /**
     * Set the value of valorIssrf
     */
    public function setValorIssrf(float $valorIssrf): self
    {
        $this->valorIssrf = $valorIssrf;

        return $this;
    }
}
