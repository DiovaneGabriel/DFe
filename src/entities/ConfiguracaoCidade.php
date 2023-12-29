<?php

namespace Entities;

class ConfiguracaoCidade
{
    private string $cidadeCodigoIbge;
    private string $classeNFSe;
    private string $urlWebserviceProducao;
    private string $urlWebserviceHomologacao;

    public function __construct(
        string $cidadeCodigoIbge,
        string $classeNFSe,
        string $urlWebserviceProducao,
        string $urlWebserviceHomologacao = ""
    ) {
        $this->setCidadeCodigoIbge($cidadeCodigoIbge);
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
            string $urlWebserviceProducao,
            string $urlWebserviceHomologacao = ""
        ) use (&$cidades) {
            $cidades[$cidadeCodigoIbge] = new self($cidadeCodigoIbge,  $urlWebserviceProducao, $urlWebserviceHomologacao);
        };

        $addCidade("4319901",  "NFSeIPM", "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao");

        return isset($cidades[$cidadeCodigoIbge]) ? $cidades[$cidadeCodigoIbge] : null;
    }
}
