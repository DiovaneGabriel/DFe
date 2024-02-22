<?php

namespace DBarbieri\DFe\Config;

class Constants
{
    const AMBIENTE_PRODUCAO = 1;
    const AMBIENTE_HOMOLOGACAO = 2;

    const SITUACAO_AGUARDANDO = 0;
    const SITUACAO_EMITIDO = 1;
    const SITUACAO_CANCELADO = 2;

    const DESCRICOES_SITUACAO = [
        self::SITUACAO_AGUARDANDO => "Aguardando",
        self::SITUACAO_EMITIDO => "Emitido",
        self::SITUACAO_CANCELADO => "Cancelado",
    ];

    const DOCUMENTO_RPS = 'rps';
    const DOCUMENTO_NFSE = 'nfse';

    const PESSOA_TIPO_FISICA = 'f';
    const PESSOA_TIPO_JURIDICA = 'j';
    const PESSOA_TIPO_ESTRANGEIRA = 'e';
}
