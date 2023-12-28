<?php

namespace DFe;

use DFe\NFSe\NFSeIPM;
use Entities\Emissor;

abstract class NFSe extends DFe
{
    // public function cancelar()
    // {
    // }

    // public function emitir()
    // {
    // }

    public static function getInstance(Emissor $emissor, int $ambiente = self::AMBIENTE_HOMOLOGACAO): NFSeIPM
    {
        if ($emissor->getCidadeCodigoIbge() == 4319901) {
            return new NFSeIPM($emissor, $ambiente);
        }
        return null;
    }

    protected function getUrl()
    {
        $urls = [
            DFe::AMBIENTE_PRODUCAO => [
                "4319901" => "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao"
            ],
            DFe::AMBIENTE_HOMOLOGACAO => [
                "4319901" => "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao"
            ]
        ];

        return $urls[$this->getAmbiente()][$this->getEmissor()->getCidadeCodigoIbge()];
    }
}
