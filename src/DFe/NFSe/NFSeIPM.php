<?php

namespace DFe\NFSe;

use DFe\NFSe;
use Libraries\Format;
use Libraries\Request;
use Libraries\XML;

class NFSeIPM extends NFSe
{


    public function cancelar(int $numero, int $serie, string $motivo)
    {
        $nfse = [
            "nfse" =>
            [
                "nf" => [
                    "numero" => $numero,
                    "serie_nfse" => $serie,
                    "situacao" => "C",
                    "observacao" => $motivo
                ],
                "prestador" => [
                    "cpfcnpj" => $this->getEmissor()->getCnpj(),
                    "cidade" => $this->getEmissor()->getCidadeCodigoTom()
                ]
            ]
        ];

        $this->xml = XML::createFromArray($nfse);

        $this->sendRequest();
    }

    public function emitir()
    {
    }

    private function sendRequest()
    {
        $auth = base64_encode(Format::cnpj($this->getEmissor()->getCnpj()) . ':' . $this->getEmissor()->getSenhaWebservice());

        $headers = [];
        $headers[] = 'Authorization: Basic ' . $auth;
        $headers[] = 'Content-Type: multipart/form-data';


        // TODO: salvar cookie no cache
        // if ($cookie) {
        //     $headers[] = 'Cookie: PHPSESSID=' . $cookie;
        // }


        $tempFile = tempnam(sys_get_temp_dir(), $this->getEmissor()->getCnpj() . '_');
        $file = fopen($tempFile, 'w');
        fwrite($file, $this->xml);
        fclose($file);


        // Abre o arquivo temporário para escrita

        // Escreve algo no arquivo

        // Fecha o manipulador do arquivo

        // $fileName = "./consulta_$codigo_autenticidade.xml";
        // echo '<pre>';
        // var_dump($auth);
        // die();

        // save_xml_submit($fileName, $xml);

        $fileName = curl_file_create($tempFile, 'text/xml', 'arquivo');
        $return = Request::post($this->getUrl(), ['xml' => $fileName], $headers, TRUE);

        echo '<pre>';
        var_dump($return);
        die();
    }
}
