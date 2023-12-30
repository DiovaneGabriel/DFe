<?php

namespace DFe;

use DateTime;
use Entities\Emitente;
use Entities\NFSeItem;
use Entities\Parameters;
use Entities\Pessoa;
use Exception;
use Libraries\Constants;
use ReflectionMethod;

class NFSe extends DFe
{
    private DateTime $dataFatoGerador;
    private array $itens;
    private int $numeroRps;
    private Pessoa $tomador;
    private string $urlDanfse;
    private float $valorContribuicaoSocial;
    private float $valorInss;
    private float $valorIr;
    private float $valorRps;

    public function __construct(Emitente $emitente, int $ambiente = Constants::AMBIENTE_HOMOLOGACAO/*, bool $calledByChild = false*/)
    {
        parent::__construct($emitente, $ambiente);

        // $this->setAmbiente($ambiente);
        $this->itens = [];

        $this->setDataFatoGerador($this->getEmitente()->getLocalDateTime());
        $this->setNumeroRps(0);
        $this->setProtocoloAutorizacao('');
        $this->setUrlDanfse('');
        $this->setValorContribuicaoSocial(0);
        $this->setValorInss(0);
        $this->setValorIr(0);
        $this->setValorRps(0);

        $this->setEmitente($emitente);

        // if ($calledByChild) {
        // } else {
        //     $this = new ("DFe\\NFSe\\" . $this->getClasseNFSe())($emitente, $ambiente, true);
        // }
    }

    private function procreate(): NFSe
    {
        $className = Parameters::getClasseNFSeFromCidade($this->getEmitente()->getEnderecoCidadeCodigoIbge());

        $child = new $className($this->getEmitente(), $this->getAmbiente());

        $parentMethods = get_class_methods($this);
        $parentMethods = array_filter($parentMethods, function ($method) {
            return strpos($method, 'get') === 0;
        });

        $childMethods = get_class_methods($child);

        foreach ($parentMethods as $method) {
            $get = $method;
            $set = 'set' . substr($method, 3);

            if (in_array($set, $childMethods)) {
                $reflectionParent = new ReflectionMethod($this, $get);
                $reflectionParent->setAccessible(true);

                $reflectionChild = new ReflectionMethod($child, $set);
                $reflectionChild->setAccessible(true);

                if (!$reflectionParent->isPrivate() && !$reflectionChild->isPrivate()) {
                    $child->{$set}($this->{$get}());
                }
            }
        }

        return $child;
    }

    public function cancelar(string $motivo, int $numero = null, int $serie = null)
    {
        $nfse = $this->procreate();
        return $nfse->cancelar($motivo, $numero, $serie);
    }

    public function emitir()
    {
        $nfse = $this->procreate();
        return $nfse->emitir();
    }

    /**
     * Get the value of dataFatoGerador
     */
    public function getDataFatoGerador(): DateTime
    {
        return $this->dataFatoGerador;
    }

    /**
     * Set the value of dataFatoGerador
     */
    public function setDataFatoGerador(DateTime $dataFatoGerador): self
    {
        $this->dataFatoGerador = $dataFatoGerador;

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
     * Get the value of tomador
     */
    public function getTomador(): Pessoa
    {
        return $this->tomador;
    }

    /**
     * Set the value of tomador
     */
    public function setTomador(Pessoa $tomador): self
    {
        $this->tomador = $tomador;

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
}
