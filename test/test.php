<?php

use DBarbieri\AwsS3\AwsS3;
use DBarbieri\DFe\Config\Constants;
use DBarbieri\DFe\Entities\Emitente;
use DBarbieri\DFe\Entities\NFSeItem;
use DBarbieri\DFe\Entities\Pessoa;
use DBarbieri\DFe\NFSe;
use DBarbieri\Graylog\Graylog;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__, '../.env');
$dotenv->load();

$graylog = new Graylog('http://graylog', 12201);
$s3 = new AwsS3($_ENV['AWSS3_KEY'], $_ENV['AWSS3_SECRET'], $_ENV['AWSS3_REGION'], $_ENV['AWSS3_BUCKET']);
$s3->setGraylog($graylog);

$emitente = new Emitente("DB Serviços de Informações Ltda", 4319901, "51941986000135", $_ENV['NFSE_PASSWORD']);
$emitente->setEnderecoCidadeCodigoTom("8899");

$tomador = new Pessoa("Diovane Barbieri Gabriel");

// $tomador
//     ->setTipo('E')
//     ->setDocumentoEstrangeiro('BRBDVN92E01Z602Q')
//     ->setEnderecoCep("16030")
//     ->setEnderecoCidade("Moneglia")
//     ->setEnderecoEstado("Liguria")
//     ->setEnderecoPais("Italia")
//     ->setEnderecoBairro("Roverano Basso")
//     ->setEnderecoLogradouro("Via Casale")
//     ->setEnderecoNumero("37")
//     ->setEnderecoComplemento("Q")
//     ->setEmail("diovane.gabriel@gmail.com");

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
    ->setAwsS3($s3)
    ->setGraylog($graylog);

$nfse
    ->setTomador($tomador)
    ->setSerie(1);

$nfseItem = new NFSeItem("Prestação de serviço");

$nfseItem
    ->setCodigo("1701")
    ->setAliquota(2)
    ->setSituacaoTributaria(0)
    ->setValorTributavel(1.2)
    ->setValor(1.2);

// $nfse->setNumeroRps(23)
//     ->setValor(1.2)
//     ->addItem($nfseItem)
//     ->emitir();

// $nfse->cancelar("NFS-e emitida para teste");
$nfse->consultar("8899738882205194198620241229122023253915");

echo '<pre>';
var_dump($nfse->getXml());
var_dump($nfse->getUrlXml());
die();
