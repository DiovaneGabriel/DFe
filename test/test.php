<?php

require __DIR__ . '/../vendor/autoload.php';

use DFe\NFSe;
use Entities\Emitente;
use Libraries\Constants;

$emitente = new Emitente("DB Serviços de Informações Ltda", 4319901, "51941986000135", "Db51941!");

$nfe = new NFSe($emitente, Constants::AMBIENTE_PRODUCAO);
$nfe->emitir();

echo '<pre>';
var_dump($emitente);
die();