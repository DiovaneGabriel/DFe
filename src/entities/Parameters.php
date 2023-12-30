<?php

namespace Entities;

use Exception;
use Libraries\Constants;

class Parameters
{
    private const NFSE_CLASSE_CIDADE = [
        "NFSeIPM" => ["4319901"]
    ];

    private const NFSE_ENDPOINT_CIDADE = [
        "4319901" => [
            Constants::AMBIENTE_PRODUCAO => "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao",
            Constants::AMBIENTE_HOMOLOGACAO => "https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao"
        ]
    ];

    private const DFE_FUSO_HORARIO_ESTADO = [
        "America/Sao_Paulo" => ["43"]
    ];

    public static function getClasseNFSeFromCidade(string $cidadeCodigoIbge): string
    {
        foreach (self::NFSE_CLASSE_CIDADE as $classe => $cidades) {
            if (in_array($cidadeCodigoIbge, $cidades)) {
                return "DFe\\NFSe\\" . $classe;
            }
        }

        throw new Exception("Parametrização de classe inexistente para a cidade " . $cidadeCodigoIbge . "!");
    }

    public static function  getEndpointFromCidade(string $cidadeCodigoIbge, int $ambiente): string
    {
        if (empty(self::NFSE_ENDPOINT_CIDADE[$cidadeCodigoIbge][$ambiente])) {
            throw new Exception("Parametrização de endpoint de " . (Constants::AMBIENTE_PRODUCAO == $ambiente ? "produção" : "homologação") . " inexistente para a cidade " . $cidadeCodigoIbge . "!");
        }

        return self::NFSE_ENDPOINT_CIDADE[$cidadeCodigoIbge][$ambiente];
    }

    public static function getFusoHorarioFromCidade(string $cidadeCodigoIbge): string
    {
        foreach (self::DFE_FUSO_HORARIO_ESTADO as $fuso => $estados) {
            if (in_array(substr($cidadeCodigoIbge, 0, 2), $estados)) {
                return $fuso;
            }
        }

        throw new Exception("Parametrização de fuso horário inexistente para a cidade " . $cidadeCodigoIbge . "!");
    }
}
