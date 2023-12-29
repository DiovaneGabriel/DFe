<?php

namespace Entities;

class ConfiguracaoCidade
{
    private string $cidadeCodigoIbge;
    private string $cidadeCodigoTom;
    private string $classeNFSe;
    private string $urlWebserviceProducao;
    private string $urlWebserviceHomologacao;

    public function __construct(
        string $cidadeCodigoIbge,
        string $cidadeCodigoTom,
        string $classeNFSe,
        string $urlWebserviceProducao,
        string $urlWebserviceHomologacao = ""
    ) {
        $this->setCidadeCodigoIbge($cidadeCodigoIbge);
        $this->setCidadeCodigoTom($cidadeCodigoTom);
        $this->setClasseNFSe($classeNFSe);
        $this->setUrlWebserviceProducao($urlWebserviceProducao);
        $this->setUrlWebserviceHomologacao($urlWebserviceHomologacao);
    }

    /**
     * Get the value of cidadeCodigoIbge
     */
    public function getCidadeCodigoIbge(): string
    {
        return $this->cidadeCodigoIbge;
    }

    /**
     * Set the value of cidadeCodigoIbge
     */
    public function setCidadeCodigoIbge(string $cidadeCodigoIbge): self
    {
        $this->cidadeCodigoIbge = $cidadeCodigoIbge;

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

    /**
     * Get the value of classe
     */
    public function getClasseNFSe(): string
    {
        return $this->classeNFSe;
    }

    /**
     * Set the value of classe
     */
    public function setClasseNFSe(string $classeNFSe): self
    {
        $this->classeNFSe = $classeNFSe;

        return $this;
    }

    /**
     * Get the value of urlWebserviceProducao
     */
    public function getUrlWebserviceProducao(): string
    {
        return $this->urlWebserviceProducao;
    }

    /**
     * Set the value of urlWebserviceProducao
     */
    public function setUrlWebserviceProducao(string $urlWebserviceProducao): self
    {
        $this->urlWebserviceProducao = $urlWebserviceProducao;

        return $this;
    }

    /**
     * Get the value of urlWebserviceHomologacao
     */
    public function getUrlWebserviceHomologacao(): string
    {
        return $this->urlWebserviceHomologacao;
    }

    /**
     * Set the value of urlWebserviceHomologacao
     */
    public function setUrlWebserviceHomologacao(string $urlWebserviceHomologacao): self
    {
        $this->urlWebserviceHomologacao = $urlWebserviceHomologacao;

        return $this;
    }

    public static function getConfiguracaoCidade(string $cidadeCodigoIbge): self
    {
        $cidades = [];
        $addCidade = function (
            string $cidadeCodigoIbge,
            string $cidadeCodigoTom,
            string $urlWebserviceProducao,
            string $urlWebserviceHomologacao = ""
        ) use (&$cidades) {
            $cidades[$cidadeCodigoIbge] = new self($cidadeCodigoIbge, $cidadeCodigoTom, $urlWebserviceProducao, $urlWebserviceHomologacao);
        };

        $addCidade("4319901", "8899", "NFSeIPM", "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao");

        return isset($cidades[$cidadeCodigoIbge]) ? $cidades[$cidadeCodigoIbge] : null;
    }
}
