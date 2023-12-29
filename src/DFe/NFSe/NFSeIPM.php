<?php

namespace DFe\NFSe;

use DateTime;
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
                    "cidade" => $this->getEmitente()->getEnderecoCidadeCodigoTom()
                ]
            ]
        ];

        $this->xml = XML::createFromArray($nfse);

        return $this->sendRequest();
    }

    public function emitir(): self
    {
        $pessoaEmitente = $this->getEmitente();
        $pessoaTomador = $this->getTomador();

        $nf = null;
        $this->getSerie() ? $nf["serie_nfse"] = $this->getSerie() : null;
        $this->getDataFatoGerador() ? $nf["data_fato_gerador"] = $this->getDataFatoGerador()->format('d/m/Y') : null;
        $nf["valor_total"] = $this->getValor();
        $this->getValorDesconto() ? $nf["valor_desconto"] = $this->getValorDesconto() : null;
        $this->getValorIr() ? $nf["valor_ir"] = $this->getValorIr() : null;
        $this->getValorInss() ? $nf["valor_inss"] = $this->getValorInss() : null;
        $this->getValorContribuicaoSocial() ? $nf["valor_contribuicao_social"] = $this->getValorContribuicaoSocial() : null;
        $this->getValorRps() ? $nf["valor_rps"] = $this->getValorRps() : null;
        $this->getValorPis() ? $nf["valor_pis"] = $this->getValorPis() : null;
        $this->getValorCofins() ? $nf["valor_cofins"] = $this->getValorCofins() : null;
        $this->getObservacao() ? $nf["observacao"] = $this->getObservacao() : null;

        $tomador = null;
        $tomador["endereco_informado"] = $pessoaTomador->getEnderecoLogradouro() ? 1 : 0;
        $tomador["tipo"] = strtoupper($pessoaTomador->getTipo());

        if (strtolower($pessoaTomador->getTipo()) == 'e') {
            $pessoaTomador->getDocumentoEstrangeiro() ? $tomador["identificador"] = $pessoaTomador->getDocumentoEstrangeiro() : null;
            $pessoaTomador->getEnderecoEstado() ? $tomador["estado"] = $pessoaTomador->getEnderecoEstado() : null;
            $pessoaTomador->getEnderecoPais() ? $tomador["pais"] = $pessoaTomador->getEnderecoPais() : null;
        }

        if (strtolower($pessoaTomador->getTipo()) == 'f') {
            $pessoaTomador->getCpf() ? $tomador["cpfcnpj"] =  $pessoaTomador->getCpf() : null;
            $pessoaTomador->getNome() ? $tomador["nome_razao_social"] =  $pessoaTomador->getNome() : null;
            $pessoaTomador->getSobrenome() ? $tomador["sobrenome_nome_fantasia"] =  $pessoaTomador->getSobrenome() : null;
        } elseif (strtolower($pessoaTomador->getTipo()) == 'j') {
            $pessoaTomador->getCnpj() ? $tomador["cpfcnpj"] =  $pessoaTomador->getCnpj() : null;
            $pessoaTomador->getInscricaoEstadual() ? $tomador["ie"] =  $pessoaTomador->getInscricaoEstadual() : null;
            $pessoaTomador->getRazaoSocial() ? $tomador["nome_razao_social"] =  $pessoaTomador->getRazaoSocial() : null;
            $pessoaTomador->getNome() ? $tomador["sobrenome_nome_fantasia"] =  $pessoaTomador->getNome() : null;
        }

        $pessoaTomador->getEnderecoLogradouro() ? $tomador["logradouro"] =  $pessoaTomador->getEnderecoLogradouro() : null;
        $pessoaTomador->getEmail() ? $tomador["email"] =  $pessoaTomador->getEmail() : null;

        if ($pessoaTomador->getEnderecoLogradouro()) {
            $tomador["numero_residencia"] =  $pessoaTomador->getEnderecoNumero();
            $pessoaTomador->getEnderecoComplemento() ? $tomador["complemento"] =  $pessoaTomador->getEnderecoComplemento() : null;
            $tomador["bairro"] =  $pessoaTomador->getEnderecoBairro();
            $tomador["cidade"] =  strtolower($pessoaTomador->getTipo()) == 'e' ? $pessoaTomador->getEnderecoCidade() : $pessoaTomador->getEnderecoCidadeCodigoTom();
            $pessoaTomador->getEnderecoCep() ? $tomador["cep"] =  $pessoaTomador->getEnderecoCep() : null;
        }

        $itens = null;

        $nfseItens = $this->getItens();

        foreach ($nfseItens as $i => $nfseItem) {

            $item = null;
            $item["tributa_municipio_prestador"] = $nfseItem->getTributacaoMunicipioTomador();
            $item["codigo_local_prestacao_servico"] = $nfseItem->getTributacaoMunicipioTomador() ? $pessoaTomador->getEnderecoCidadeCodigoTom() : $pessoaEmitente->getEnderecoCidadeCodigoTom();
            // $item["unidade_codigo"=>"sr"
            // $item["unidade_quantidade"=>1,
            $nfseItem->getValor() ? $item["unidade_valor_unitario"] = $nfseItem->getValor() : null;
            $item["codigo_item_lista_servico"] = $nfseItem->getCodigo();
            $nfseItem->getCodigoAtividade() ? $item["codigo_atividade"] = $nfseItem->getCodigoAtividade() : null;
            $item["descritivo"] = $nfseItem->getDescricao();
            $item["aliquota_item_lista_servico"] = $nfseItem->getAliquota();
            $item["situacao_tributaria"] = $nfseItem->getSituacaoTributaria();
            $item["valor_tributavel"] = $nfseItem->getValorTributavel();
            $nfseItem->getValorDeducao() ? $item["valor_deducao"] = $nfseItem->getValorDeducao() : null;
            $nfseItem->getValorIssrf() ? $item["valor_issrf"] = $nfseItem->getValorIssrf() : null;

            $itens["lista" . $i] = $item;
        }

        $nfse = [
            "nfse" => [
                // "identificador" => $id,
                "rps" => [
                    "nro_recibo_provisorio" => $this->getNumeroRps(),
                    "serie_recibo_provisorio" => $this->getSerie(),
                    "data_emissao_recibo_provisorio" => date("d/m/Y"),
                    "hora_emissao_recibo_provisorio" => date("H:i:s")
                ],
                "nf" => $nf,
                "prestador" => [
                    "cpfcnpj" => $pessoaEmitente->getCnpj(),
                    "cidade" => $pessoaEmitente->getEnderecoCidadeCodigoTom()
                ],
                "tomador" => $tomador,
                "itens" => $itens
            ]
        ];

        $this->xml = XML::createFromArray($nfse, '', ['lista']);

        if ($response = $this->sendRequest()) {
            $xmlResponse = simplexml_load_string($response);

            $this->setNumero(((array)$xmlResponse->numero_nfse)[0]);
            $this->setDataEmissao(DateTime::createFromFormat('d/m/Y H:i:s',((array)$xmlResponse->data_nfse)[0] . " " . ((array)$xmlResponse->hora_nfse)[0]));
            $this->setUrlDanfse(((array)$xmlResponse->link_nfse)[0]);
            $this->setProtocoloAutorizacao(((array)$xmlResponse->cod_verificador_autenticidade)[0]);
        }

        return $this;
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

        if (self::decodeResponse($response)) {
            return $response->return;
        }
        return false;
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
