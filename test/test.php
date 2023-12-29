<?php

require __DIR__ . '/../vendor/autoload.php';

use DFe\NFSe;
use Entities\Emitente;
use Entities\Pessoa;
use Libraries\Constants;

$emitente = new Emitente("DB Serviços de Informações Ltda", 4319901, "51941986000135", "Db51941!");
$emitente->setEnderecoCidadeCodigoTom("8899");

$tomador = new Pessoa("Diovane");
$tomador
    ->setTipo('F')
    ->setCpf('83532226049')
    ->setSobrenome("Barbieri Gabriel")
    ->setEnderecoLogradouro("Avenida Antão de Farias")
    ->setEmail("diovane.gabriel@gmail.com")
    ->setEnderecoNumero("1267")
    ->setEnderecoComplemento("Apto 301 Bloco D")
    ->setEnderecoBairro("Centro")
    ->setEnderecoCidadeCodigoTom("8899")
    ->setEnderecoCep("93800126");

$nfe = new NFSe($emitente, $tomador, Constants::AMBIENTE_PRODUCAO);
$nfe->emitir();

echo '<pre>';
var_dump($emitente);
die();
