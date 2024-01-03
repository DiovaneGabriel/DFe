<?php

namespace DFe\NFSe;

use DateTime;
use DFe\Exception\NFSeIPMException;
use DFe\NFSe;
use Entities\Parameters;
use Exception;
use Graylog\Graylog;
use Libraries\Cache;
use Libraries\Constants;
use Libraries\Format;
use Libraries\Request;
use Libraries\XML;

class NFSeIPM extends NFSe
{

    public function consultar(string $protocoloAutorizacao = null)
    {
        $protocoloAutorizacao ? $this->setProtocoloAutorizacao($protocoloAutorizacao) : null;

        $xml = [
            "nfse" => [
                "pesquisa" => [
                    "codigo_autenticidade" => $this->getProtocoloAutorizacao()
                ]
            ]
        ];

        $this->setXml(XML::createFromArray($xml));

        if ($response = $this->sendRequest()) {
            $this->setXml(XML::minify($response));

            if ($this->getAwsS3()) {
                $target = $this->getEmitente()->getCnpj() . '/NFSe/' . $this->getProtocoloAutorizacao() . ".xml";

                if ($urlXml = $this->getAwsS3()->send($this->getXml(), $target, true)) {
                    $this->setUrlXml($urlXml);
                }
            }
        }

        return $this;
    }

    public function cancelar(string $motivo, int $numero = null, int $serie = null)
    {
        $numero ? $this->setNumero($numero) : null;
        $serie ? $this->setSerie($serie) : null;

        $xml = [
            "nfse" =>
            [
                "nf" => [
                    "numero" => $this->getNumero(),
                    "serie_nfse" => $this->getSerie(),
                    "situacao" => "C",
                    "observacao" => $motivo
                ],
                "prestador" => [
                    "cpfcnpj" => $this->getEmitente()->getCnpj(),
                    "cidade" => $this->getEmitente()->getEnderecoCidadeCodigoTom()
                ]
            ]
        ];

        $this->setXml(XML::createFromArray($xml));

        if ($this->getAmbiente() == Constants::AMBIENTE_HOMOLOGACAO) {
            $this->setDataCancelamento($this->getEmitente()->getLocalDateTime());
            $this->setSituacao(Constants::SITUACAO_CANCELADO);
        } else {
            if ($response = $this->sendRequest()) {
                $xmlResponse = simplexml_load_string($response);

                $this->setDataCancelamento($this->getEmitente()->getLocalDateTime());
                $this->setProtocoloAutorizacao(((array)$xmlResponse->cod_verificador_autenticidade)[0]);
                $this->setSituacao(Constants::SITUACAO_CANCELADO);

                $this->consultar();
            }
        }

        return $this;
    }

    public function emitir(): self
    {
        $pessoaEmitente = $this->getEmitente();

        $xml = null;

        $this->getAmbiente() == Constants::AMBIENTE_HOMOLOGACAO ? $xml["nfse_teste"] = 1 : null;

        $xml["rps"] = [
            "nro_recibo_provisorio" => $this->getNumeroRps(),
            "serie_recibo_provisorio" => $this->getSerie(),
            "data_emissao_recibo_provisorio" => $pessoaEmitente->getLocalDateTime()->format("d/m/Y"),
            "hora_emissao_recibo_provisorio" => $pessoaEmitente->getLocalDateTime()->format("H:i:s")
        ];
        $xml["nf"] = $this->buildTagNf();
        $xml["prestador"] = [
            "cpfcnpj" => $pessoaEmitente->getCnpj(),
            "cidade" => $pessoaEmitente->getEnderecoCidadeCodigoTom()
        ];
        $xml["tomador"] = $this->buildTagTomador();
        $xml["itens"] = $this->buildTagItens();

        $this->setXml(XML::createFromArray([$xml], 'nfse', ['lista']));

        if ($response = $this->sendRequest()) {
            $xmlResponse = simplexml_load_string($response);

            $this->setNumero(((array)$xmlResponse->numero_nfse)[0]);
            $this->setDataEmissao(DateTime::createFromFormat('d/m/Y H:i:s', ((array)$xmlResponse->data_nfse)[0] . " " . ((array)$xmlResponse->hora_nfse)[0]));
            $this->setUrlDanfse(((array)$xmlResponse->link_nfse)[0]);
            $this->setProtocoloAutorizacao(((array)$xmlResponse->cod_verificador_autenticidade)[0]);
            $this->setSituacao(Constants::SITUACAO_EMITIDO);

            if ($this->getAmbiente() == Constants::AMBIENTE_PRODUCAO) {
                $this->consultar();
            }
        }

        return $this;
    }

    private function buildTagNf(): array
    {
        $nf = null;
        $this->getSerie() ? $nf["serie_nfse"] = $this->getSerie() : null;
        $this->getDataFatoGerador() ? $nf["data_fato_gerador"] = $this->getDataFatoGerador()->format('d/m/Y') : null;
        $nf["valor_total"] = Format::floatWithComa($this->getValor());
        $this->getValorDesconto() ? $nf["valor_desconto"] = Format::floatWithComa($this->getValorDesconto()) : null;
        $this->getValorIr() ? $nf["valor_ir"] = Format::floatWithComa($this->getValorIr()) : null;
        $this->getValorInss() ? $nf["valor_inss"] = Format::floatWithComa($this->getValorInss()) : null;
        $this->getValorContribuicaoSocial() ? $nf["valor_contribuicao_social"] = Format::floatWithComa($this->getValorContribuicaoSocial()) : null;
        $this->getValorRps() ? $nf["valor_rps"] = Format::floatWithComa($this->getValorRps()) : null;
        $this->getValorPis() ? $nf["valor_pis"] = Format::floatWithComa($this->getValorPis()) : null;
        $this->getValorCofins() ? $nf["valor_cofins"] = Format::floatWithComa($this->getValorCofins()) : null;
        $this->getObservacao() ? $nf["observacao"] = Format::floatWithComa($this->getObservacao()) : null;

        return $nf;
    }

    private function buildTagTomador(): array
    {
        $pessoaTomador = $this->getTomador();

        $tomador = null;
        $tomador["endereco_informado"] = $pessoaTomador->getEnderecoLogradouro() ? 1 : 0;
        $tomador["tipo"] = strtoupper($pessoaTomador->getTipo());

        if (strtolower($pessoaTomador->getTipo()) == 'f') {
            $pessoaTomador->getCpf() ? $tomador["cpfcnpj"] =  $pessoaTomador->getCpf() : null;
            $pessoaTomador->getNome() ? $tomador["nome_razao_social"] =  $pessoaTomador->getNome() : null;
        } elseif (strtolower($pessoaTomador->getTipo()) == 'j') {
            $pessoaTomador->getCnpj() ? $tomador["cpfcnpj"] =  $pessoaTomador->getCnpj() : null;
            $pessoaTomador->getInscricaoEstadual() ? $tomador["ie"] =  $pessoaTomador->getInscricaoEstadual() : null;
            $pessoaTomador->getRazaoSocial() ? $tomador["nome_razao_social"] =  $pessoaTomador->getRazaoSocial() : null;
            $pessoaTomador->getNome() ? $tomador["sobrenome_nome_fantasia"] =  $pessoaTomador->getNome() : null;
        } elseif (strtolower($pessoaTomador->getTipo()) == 'e') {
            $pessoaTomador->getDocumentoEstrangeiro() ? $tomador["identificador"] = $pessoaTomador->getDocumentoEstrangeiro() : null;
            $pessoaTomador->getEnderecoEstado() ? $tomador["estado"] = $pessoaTomador->getEnderecoEstado() : null;
            $pessoaTomador->getEnderecoPais() ? $tomador["pais"] = $pessoaTomador->getEnderecoPais() : null;
            $pessoaTomador->getNome() ? $tomador["nome_razao_social"] =  $pessoaTomador->getNome() : null;
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

        return $tomador;
    }

    private function buildTagItens(): array
    {
        $pessoaEmitente = $this->getEmitente();
        $pessoaTomador = $this->getTomador();

        $nfseItens = $this->getItens();

        $itens = null;

        foreach ($nfseItens as $i => $nfseItem) {

            $item = null;
            $item["tributa_municipio_prestador"] = $nfseItem->getTributacaoMunicipioTomador();
            $item["codigo_local_prestacao_servico"] = $nfseItem->getTributacaoMunicipioTomador() ? $pessoaTomador->getEnderecoCidadeCodigoTom() : $pessoaEmitente->getEnderecoCidadeCodigoTom();
            // $item["unidade_codigo"=>"sr"
            // $item["unidade_quantidade"=>1,
            $nfseItem->getValor() ? $item["unidade_valor_unitario"] = Format::floatWithComa($nfseItem->getValor()) : null;
            $item["codigo_item_lista_servico"] = $nfseItem->getCodigo();
            $nfseItem->getCodigoAtividade() ? $item["codigo_atividade"] = $nfseItem->getCodigoAtividade() : null;
            $item["descritivo"] = $nfseItem->getDescricao();
            $item["aliquota_item_lista_servico"] = $nfseItem->getAliquota();
            $item["situacao_tributaria"] = $nfseItem->getSituacaoTributaria();
            $item["valor_tributavel"] = Format::floatWithComa($nfseItem->getValorTributavel());
            $nfseItem->getValorDeducao() ? $item["valor_deducao"] = Format::floatWithComa($nfseItem->getValorDeducao()) : null;
            $nfseItem->getValorIssrf() ? $item["valor_issrf"] = Format::floatWithComa($nfseItem->getValorIssrf()) : null;

            $itens["lista" . $i] = $item;
        }

        return $itens;
    }

    private function sendRequest()
    {
        $endpoint = Parameters::getEndpointFromCidade($this->getEmitente()->getEnderecoCidadeCodigoIbge(), $this->getAmbiente());

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
        fwrite($file, $this->getXml());
        fclose($file);

        $fileName = curl_file_create($tempFile, 'text/xml', 'arquivo');

        $response = Request::post($endpoint, ['xml' => $fileName], $headers, TRUE);

        unlink($tempFile);

        if (!$cookie) {
            $cookie = self::getCookie($response);
            if ($cookie) {
                Cache::saveToCache($cookieCacheKey, $cookie);
            }
        }

        if ($this->decodeResponse($response)) {
            return $response->return;
        }

        return false;
    }

    private function decodeResponse($response)
    {
        if ($response->code == 200) {
            $response = $response->return;
            $obj = simplexml_load_string($response);

            if ($this->getAmbiente() == Constants::AMBIENTE_PRODUCAO) {
                if (!empty($obj->mensagem->codigo)) {
                    $codigo = substr(((array)$obj->mensagem->codigo)[0], 0, 5);

                    if ($codigo != '00001') {
                        $this->createLog($this->getXml(), XML::minify($response), Graylog::LEVEL_ERROR);
                        throw new NFSeIPMException((array)$obj->mensagem->codigo);
                    }
                }
            } elseif (empty($obj->situacao_descricao_nfse) && empty($obj->nf->situacao_descricao_nfse)) {
                $this->createLog($this->getXml(), XML::minify($response), Graylog::LEVEL_ERROR);
                throw new NFSeIPMException((array)$obj->mensagem->codigo);
            }
        } else {
            $this->createLog($this->getXml(), $response->return ? $response->return : $response->code, Graylog::LEVEL_FATAL);
            throw new Exception($response->return);
        }

        $this->createLog($this->getXml(), XML::minify($response));

        return true;
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
