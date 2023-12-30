<?php

require __DIR__ . '/../vendor/autoload.php';

use DFe\NFSe;
use Entities\Emitente;
use Entities\NFSeItem;
use Entities\Pessoa;
use Libraries\Constants;

$emitente = new Emitente("DB Serviços de Informações Ltda", 4319901, "51941986000135", "Db51941!");
$emitente->setEnderecoCidadeCodigoTom("8899");

$tomador = new Pessoa("Diovane Barbieri Gabriel");
$tomador
    ->setTipo('F')
    ->setCpf('83532226049')
    ->setEnderecoLogradouro("Avenida Antão de Farias")
    ->setEmail("diovane.gabriel@gmail.com")
    ->setEnderecoNumero("1267")
    ->setEnderecoComplemento("Apto 301 Bloco D")
    ->setEnderecoBairro("Centro")
    ->setEnderecoCidadeCodigoTom("8899")
    ->setEnderecoCep("93800126");

$nfse = NFSe::getInstance($emitente, Constants::AMBIENTE_PRODUCAO);
$nfse
    ->setTomador($tomador)
    ->setSerie(1);

$nfseItem = new NFSeItem("Prestação de serviço");

$nfseItem
    ->setCodigo("1701")
    ->setAliquota(2)
    ->setSituacaoTributaria(0)
    ->setValorTributavel(1)
    ->setValor(1);

$nfse->setNumeroRps(18)
    ->setValor(1)
    ->addItem($nfseItem)
    ->emitir();

$nfse->cancelar("NFS-e emitida para teste");

echo '<pre>';
var_dump($nfse);
die();
