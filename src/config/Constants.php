<?php

namespace DBarbieri\DFe\Config;

class Constants
{
    const AMBIENTE_PRODUCAO = 1;
    const AMBIENTE_HOMOLOGACAO = 2;

    const SITUACAO_AGUARDANDO = 0;
    const SITUACAO_EMITIDO = 1;
    const SITUACAO_CANCELADO = 2;

    const DOCUMENTO_RPS = 'rps';
    const DOCUMENTO_NFSE = 'nfse';
}
