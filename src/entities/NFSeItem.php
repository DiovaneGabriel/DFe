<?php

namespace DBarbieri\DFe\Entities;

class NFSeItem
{
    private float $aliquota = 0;
    private string $codigo = "";
    private string $codigoAtividade = "";
    private string $descricao = "";
    private int $situacaoTributaria = 0;
    private int $tributacaoMunicipioTomador = 0;
    private float $valor = 0;
    private float $valorTributavel = 0;
    private float $valorDeducao = 0;
    private float $valorIssrf = 0;

    public function __construct(string $descricao)
    {
        $this->setDescricao($descricao);
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
