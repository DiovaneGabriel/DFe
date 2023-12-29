<?php

namespace DFe\NFSe;

use DFe\NFSe;
use Exception;
use Libraries\Cache;
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
                    "cpfcnpj" => $this->getEmitente()->getCnpj(),
                    "cidade" => $this->getEmitente()->getCidadeCodigoTom()
                ]
            ]
        ];

        $this->xml = XML::createFromArray($nfse);

        return $this->sendRequest();
    }

    public function emitir()
    {
        $id = 123;
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

        $enderecoInformado = 1;
        $fisicaJuridica = 'F';
        $documentoEstrangeiro = '123abc';
        $estadoEstrangeiro = 'LG';
        $paisEstrangeiro = 'Italia';
        $cpfCnpj = '83532226049';
        $ie = '';
        $nomeRazaoSocial = '';
        $sobrenomeNomeFantasia = '';
        $logradouro = '';
        $email = '';
        $numeroResidencial = '';
        $complemento = '';
        $bairro = '';
        $cidadeCodigoTom = '';
        $cep = '';

        $codigoSubitemListaServico = '';
        $codigoAtividade = '';
        $descritivo = '';
        $aliquota = '';
        $situacaoTributaria = '';
        $valorTributavel = '';
        $valorDeducao = '';
        $valorIssrf = '';

        $nfse = [
            "nfse" => [
                "identificador" => $id,
                "nf" => [
                    "serie_nfse" => $serie,
                    "data_fato_gerador" => $data,
                    "valor_total" => $valor,
                    "valor_desconto" => $valorDesconto,
                    "valor_ir" => $valorIr,
                    "valor_inss" => $valorInss,
                    "valor_contribuicao_social" => $valorContribuicaoSocial,
                    "valor_rps" => $valorRps,
                    "valor_pis" => $valorPis,
                    "valor_cofins" => $valorCofins,
                    "observacao" => $observacao
                ],
                "prestador" => [
                    "cpfcnpj" => $this->getEmitente()->getCnpj(),
                    "cidade" => $this->getEmitente()->getCidadeCodigoTom()
                ],
                "tomador" => [
                    "endereco_informado" => $enderecoInformado,
                    "tipo" => $fisicaJuridica, //F,J ou E (estrangeiro)
                    // "identificador" => $documentoEstrangeiro,
                    // "estado" => $estadoEstrangeiro,
                    // "pais" => $paisEstrangeiro,
                    "cpfcnpj" => $cpfCnpj,
                    "ie" => $ie,
                    "nome_razao_social" => $nomeRazaoSocial,
                    "sobrenome_nome_fantasia" => $sobrenomeNomeFantasia,
                    "logradouro" => $logradouro,
                    "email" => $email,
                    "numero_residencia" => $numeroResidencial,
                    "complemento" => $complemento,
                    "bairro" => $bairro,
                    "cidade" => $cidadeCodigoTom,
                    "cep" => $cep

                ],
                "itens" => [
                    "lista" => [
                        0 => [
                            "tributa_municipio_prestador" => 1,
                            "codigo_local_prestacao_servico" => $cidadeCodigoTom,
                            // "unidade_codigo"=>"sr"
                            // "unidade_quantidade"=>1,
                            "unidade_valor_unitario" => $valor,
                            "codigo_item_lista_servico" => $codigoSubitemListaServico,
                            "codigo_atividade" => $codigoAtividade,
                            "descritivo" => $descritivo,
                            "aliquota_item_lista_servico" => $aliquota,
                            "situacao_tributaria" => $situacaoTributaria,
                            "valor_tributavel" => $valorTributavel,
                            "valor_deducao" => $valorDeducao,
                            "valor_issrf" => $valorIssrf
                        ]
                    ]
                ]
            ]
        ];

        $this->xml = XML::createFromArray($nfse);

        // echo '<pre>';
        // var_dump($this->xml);
        // die();

        return $this->sendRequest();
    }

    private function sendRequest()
    {
        $cookieCacheKey = "cookieNFSeIPM" . $this->getEmitente()->getCnpj();
        $auth = base64_encode(Format::cnpj($this->getEmitente()->getCnpj()) . ':' . $this->getEmitente()->getSenhaWebservice());
        $cookie = Cache::getFromCache($cookieCacheKey);

        $headers = [];
        $headers[] = 'Authorization: Basic ' . $auth;
        $headers[] = 'Content-Type: multipart/form-data';

        if ($cookie) {
            $headers[] = 'Cookie: PHPSESSID=' . $cookie;
        }

        # cria arquivo temporario
        $tempFile = tempnam(sys_get_temp_dir(), $this->getEmitente()->getCnpj() . '_');
        $file = fopen($tempFile, 'w');
        fwrite($file, $this->xml);
        fclose($file);

        $fileName = curl_file_create($tempFile, 'text/xml', 'arquivo');
        $response = Request::post($this->getUrlWebservice(), ['xml' => $fileName], $headers, TRUE);

        unlink($tempFile);

        if (!$cookie) {
            $cookie = self::getCookie($response);
            if ($cookie) {
                Cache::saveToCache($cookieCacheKey, $cookie);
            }
        }

        return self::decodeResponse($response);
    }

    private static function decodeResponse($response)
    {
        if ($response->code == 200) {
            $response = $response->return;
            $obj = simplexml_load_string($response);

            if (!empty($obj->mensagem->codigo)) {
                $codigo = substr(((array)$obj->mensagem->codigo)[0], 0, 5);

                if ($codigo == '00001') {
                    return true;
                } else {
                    $mensagem = "";
                    foreach ((array)$obj->mensagem->codigo as $i => $m) {
                        $mensagem .= ($i > 0 ? "\n" : '') . trim($m);
                    }

                    throw new Exception($mensagem);
                }
            }
        } else {
            throw new Exception($response->return);
        }
    }

    private static function getCookie($response)
    {
        if (strpos($response->header, "PHPSESSID") !== false) {
            preg_match_all('/Set-Cookie:\s*([^;]*)/mi', $response->header, $matches);

            $cookies = [];
            foreach ($matches[1] as $item) {
                parse_str($item, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }

            if (isset($cookies['PHPSESSID'])) {
                return $cookies['PHPSESSID'];
            }
        }

        return null;
    }
}
