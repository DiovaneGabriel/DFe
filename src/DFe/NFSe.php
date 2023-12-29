<?php

namespace DFe;

use Entities\ConfiguracaoCidade;
use Entities\Emitente;
use Exception;
use Libraries\Constants;

class NFSe extends DFe
{
    private NFSe $nfse;

    public function __construct(Emitente $emitente, int $ambiente = Constants::AMBIENTE_HOMOLOGACAO, bool $calledByChild = false)
    {
        $configuracaoCidade = ConfiguracaoCidade::getConfiguracaoCidade($emitente->getCidadeCodigoIbge());

        if (!$configuracaoCidade) {
            throw new Exception("Configuração para a cidade " . $emitente->getCidadeCodigoIbge() . " inexistente!");
        }

        if ($calledByChild) {
            if (
                ($ambiente == Constants::AMBIENTE_PRODUCAO && !$configuracaoCidade->getUrlWebserviceProducao()) ||
                ($ambiente == Constants::AMBIENTE_HOMOLOGACAO && !$configuracaoCidade->getUrlWebserviceHomologacao())
            ) {
                throw new Exception("Url do ambiente de " .
                    ($ambiente == Constants::AMBIENTE_PRODUCAO ?
                        "produção" :
                        "homologação") . " inexistente!");
            }

            $emitente->setCidadeCodigoTom($configuracaoCidade->getCidadeCodigoTom());

            $this->setUrlWebservice(
                Constants::AMBIENTE_PRODUCAO ?
                    $configuracaoCidade->getUrlWebserviceProducao() :
                    $configuracaoCidade->getUrlWebserviceHomologacao()
            );

            parent::__construct($emitente, $ambiente);
        } else {
            $this->nfse = new ("DFe\\NFSe\\" . $configuracaoCidade->getClasseNFSe())($emitente, $ambiente, true);
        }
    }

    /**
     * Get the value of nfse
     */
    public function getNfse(): NFSe
    {
        return $this->nfse;
    }

    /**
     * Set the value of nfse
     */
    public function setNfse(NFSe $nfse): self
    {
        $this->nfse = $nfse;

        return $this;
    }

    public function cancelar(int $numero, int $serie, string $motivo)
    {
        return $this->nfse->cancelar($numero, $serie, $motivo);
    }

    public function emitir()
    {
        return $this->nfse->emitir();
    }
}
