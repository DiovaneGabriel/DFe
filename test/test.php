<?php

require __DIR__ . '/../vendor/autoload.php';

use DFe\NFSe;
use Entities\Emissor;
use Libraries\Request;
use Libraries\XML;

// function save_xml_submit($file, $xml)
// {
//     $dir = explode("\\", $file);
//     $dir = array_slice($dir, 0, count($dir) - 1);
//     $dir = implode("\\", $dir);

//     if ($dir && !is_dir($dir)) {
//         mkdir($dir, 0777, true);
//     }

//     $myfile = fopen($file, "w") or die("Unable to open file!");
//     fwrite($myfile, $xml);
//     fclose($myfile);

//     return $file;
// }

$emissor = new Emissor("DB Serviços de Informações Ltda", 4319901, "51941986000135", "Db51941!");

$nfe = NFSe::getInstance($emissor);
$nfe->cancelar(123,123,"teste de cancelamento");

echo '<pre>';
var_dump($emissor);
die();

// $url = 'https://nfse-sapiranga.atende.net/atende.php?pg=rest&service=WNERestServiceNFSe&cidade=padrao';
// $auth = base64_encode("51.941.986/0001-35:Db51941!");
// $cookie = "806f22trm9r65erdeq6e8bagi3";
// $codigo_autenticidade = 123;

// $nfse = [];
// $nfse['pesquisa']['codigo_autenticidade'] = $codigo_autenticidade;

// $xml = XML::createFromArray([$nfse], 'nfse');

$headers = [];
$headers[] = 'Authorization: Basic ' . $auth;
$headers[] = 'Content-Type: multipart/form-data';

if ($cookie) {
    $headers[] = 'Cookie: PHPSESSID=' . $cookie;
}


$fileName = "./consulta_$codigo_autenticidade.xml";

save_xml_submit($fileName, $xml);

$fileName = curl_file_create($fileName, 'text/xml', 'arquivo');
$return = Request::post($url, ['xml' => $fileName], $headers, TRUE);

echo '<pre>';
var_dump($return);
die();
