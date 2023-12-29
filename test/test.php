<?php

require __DIR__ . '/../vendor/autoload.php';

use DFe\NFSe;
use Entities\Emitente;
use Entities\NFSeItem;
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


// $id = 123;
$nroRps = "4";
$serie = "1";
$data = "28/12/2023"; //TODO: criar formatador
$valor = 1;
$valorDesconto = 0;
$valorIr = 0;
$valorInss = 0;
$valorContribuicaoSocial = 0;
$valorRps = 0;
$valorPis = 0;
$valorCofins = 0;
$observacao = "";

$nfse = new NFSe($emitente, Constants::AMBIENTE_PRODUCAO);
$nfse->setTomador($tomador);

$nfseItem = new NFSeItem("Prestação de serviço");

$nfseItem
    ->setCodigo("1701")
    ->setAliquota(2)
    ->setSituacaoTributaria(0)
    ->setValorTributavel(1)
    ->setValor(1);

$nfse
    ->setNumeroRps(7)
    ->setSerie(1)
    ->setDataFatoGerador(new DateTime(date("Y-m-d H:i:s")))
    ->setValor(1)
    ->addItem($nfseItem);

// $retorno = $nfse->emitir();

// $retorno = $nfse->cancelar(11, 1, "NFS-e emitida para teste");

echo '<pre>';
var_dump($retorno);
die();
