<?php

namespace DBarbieri\DFe\Entities;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use DBarbieri\DFe\Config\Parameters;

class Pessoa
{
    private string $nome = "";
    private string $tipo = "";
    private ?string $cnpj = "";
    private ?string $cpf = "";
    private ?string $documentoEstrangeiro = "";
    private ?string $email = "";
    private ?string $enderecoBairro = "";
    private ?string $enderecoCep = "";
    private ?string $enderecoCidade = "";
    private ?string $enderecoCidadeCodigoIbge = "";
    private ?string $enderecoCidadeCodigoTom = "";
    private ?string $enderecoComplemento = "";
    private ?string $enderecoEstado = "";
    private ?string $enderecoLogradouro = "";
    private ?string $enderecoNumero = "";
    private ?string $enderecoPais = "";
    private ?string $inscricaoEstadual = "";
    private ?string $razaoSocial = "";

    function __construct($nome)
    {
        $this->nome = $nome;
    }

    public function getLocalDateTime(): DateTime
    {
        if (!$this->getEnderecoCidadeCodigoIbge()) {
            return null;
        }

        $timeZone = new DateTimeZone(Parameters::getFusoHorarioFromCidade($this->getEnderecoCidadeCodigoIbge()));
        $currentDateTime = new DateTimeImmutable('now', $timeZone);

        return new DateTime($currentDateTime->format('Y-m-d H:i:s'));
    }

    

    /**
     * Get the value of nome
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of cnpj
     */
    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    /**
     * Set the value of cnpj
     */
    public function setCnpj(?string $cnpj): self
    {
        $this->cnpj = preg_replace("/[^0-9]/", "", $cnpj);

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf(?string $cpf): self
    {
        $this->cpf = preg_replace("/[^0-9]/", "", $cpf);

        return $this;
    }

    /**
     * Get the value of documentoEstrangeiro
     */
    public function getDocumentoEstrangeiro(): ?string
    {
        return $this->documentoEstrangeiro;
    }

    /**
     * Set the value of documentoEstrangeiro
     */
    public function setDocumentoEstrangeiro(?string $documentoEstrangeiro): self
    {
        $this->documentoEstrangeiro = $documentoEstrangeiro;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of enderecoBairro
     */
    public function getEnderecoBairro(): ?string
    {
        return $this->enderecoBairro;
    }

    /**
     * Set the value of enderecoBairro
     */
    public function setEnderecoBairro(?string $enderecoBairro): self
    {
        $this->enderecoBairro = $enderecoBairro;

        return $this;
    }

    /**
     * Get the value of enderecoCep
     */
    public function getEnderecoCep(): ?string
    {
        return $this->enderecoCep;
    }

    /**
     * Set the value of enderecoCep
     */
    public function setEnderecoCep(?string $enderecoCep): self
    {
        $this->enderecoCep = $enderecoCep;

        return $this;
    }

    /**
     * Get the value of enderecoCidade
     */
    public function getEnderecoCidade(): ?string
    {
        return $this->enderecoCidade;
    }

    /**
     * Set the value of enderecoCidade
     */
    public function setEnderecoCidade(?string $enderecoCidade): self
    {
        $this->enderecoCidade = $enderecoCidade;

        return $this;
    }

    /**
     * Get the value of enderecoCidadeCodigoIbge
     */
    public function getEnderecoCidadeCodigoIbge(): ?string
    {
        return $this->enderecoCidadeCodigoIbge;
    }

    /**
     * Set the value of enderecoCidadeCodigoIbge
     */
    public function setEnderecoCidadeCodigoIbge(?string $enderecoCidadeCodigoIbge): self
    {
        $this->enderecoCidadeCodigoIbge = $enderecoCidadeCodigoIbge;

        return $this;
    }

    /**
     * Get the value of enderecoCidadeCodigoTom
     */
    public function getEnderecoCidadeCodigoTom(): ?string
    {
        return $this->enderecoCidadeCodigoTom;
    }

    /**
     * Set the value of enderecoCidadeCodigoTom
     */
    public function setEnderecoCidadeCodigoTom(?string $enderecoCidadeCodigoTom): self
    {
        $this->enderecoCidadeCodigoTom = $enderecoCidadeCodigoTom;

        return $this;
    }

    /**
     * Get the value of enderecoComplemento
     */
    public function getEnderecoComplemento(): ?string
    {
        return $this->enderecoComplemento;
    }

    /**
     * Set the value of enderecoComplemento
     */
    public function setEnderecoComplemento(?string $enderecoComplemento): self
    {
        $this->enderecoComplemento = $enderecoComplemento;

        return $this;
    }

    /**
     * Get the value of enderecoEstado
     */
    public function getEnderecoEstado(): ?string
    {
        return $this->enderecoEstado;
    }

    /**
     * Set the value of enderecoEstado
     */
    public function setEnderecoEstado(?string $enderecoEstado): self
    {
        $this->enderecoEstado = $enderecoEstado;

        return $this;
    }

    /**
     * Get the value of enderecoLogradouro
     */
    public function getEnderecoLogradouro(): ?string
    {
        return $this->enderecoLogradouro;
    }

    /**
     * Set the value of enderecoLogradouro
     */
    public function setEnderecoLogradouro(?string $enderecoLogradouro): self
    {
        $this->enderecoLogradouro = $enderecoLogradouro;

        return $this;
    }

    /**
     * Get the value of enderecoNumero
     */
    public function getEnderecoNumero(): ?string
    {
        return $this->enderecoNumero;
    }

    /**
     * Set the value of enderecoNumero
     */
    public function setEnderecoNumero(?string $enderecoNumero): self
    {
        $this->enderecoNumero = $enderecoNumero;

        return $this;
    }

    /**
     * Get the value of enderecoPais
     */
    public function getEnderecoPais(): ?string
    {
        return $this->enderecoPais;
    }

    /**
     * Set the value of enderecoPais
     */
    public function setEnderecoPais(?string $enderecoPais): self
    {
        $this->enderecoPais = $enderecoPais;

        return $this;
    }

    /**
     * Get the value of inscricaoEstadual
     */
    public function getInscricaoEstadual(): ?string
    {
        return $this->inscricaoEstadual;
    }

    /**
     * Set the value of inscricaoEstadual
     */
    public function setInscricaoEstadual(?string $inscricaoEstadual): self
    {
        $this->inscricaoEstadual = $inscricaoEstadual;

        return $this;
    }

    /**
     * Get the value of razaoSocial
     */
    public function getRazaoSocial(): ?string
    {
        return $this->razaoSocial;
    }

    /**
     * Set the value of razaoSocial
     */
    public function setRazaoSocial(?string $razaoSocial): self
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }
}
