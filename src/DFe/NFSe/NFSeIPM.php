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
                    "cidade" => $this->getEmitente()->getEnderecoCidadeCodigoTom()
                ]
            ]
        ];

        $this->xml = XML::createFromArray($nfse);

        return $this->sendRequest();
    }

    public function emitir()
    {

        $pessoaEmitente = $this->getEmitente();
        $pessoaTomador = $this->getTomador();

        $id = 123;
        $nroRps = "123";
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

        $tributacaoMunicipioTomador = 0;
        $codigoSubitemListaServico = '123';
        $codigoAtividade = '123';
        $descritivo = 'Prestação de serviço';
        $aliquota = '2';
        $situacaoTributaria = '0100';
        $valorDeducao = '';
        $valorIssrf = '';

        $nf = null;
        $serie ? $nf["serie_nfse"] = $serie : null;
        $data ? $nf["data_fato_gerador"] = $data : null;
        $nf["valor_total"] = $valor;
        $valorDesconto ? $nf["valor_desconto"] = $valorDesconto : null;
        $valorIr ? $nf["valor_ir"] = $valorIr : null;
        $valorInss ? $nf["valor_inss"] = $valorInss : null;
        $valorContribuicaoSocial ? $nf["valor_contribuicao_social"] = $valorContribuicaoSocial : null;
        $valorRps ? $nf["valor_rps"] = $valorRps : null;
        $valorPis ? $nf["valor_pis"] = $valorPis : null;
        $valorCofins ? $nf["valor_cofins"] = $valorCofins : null;
        $observacao ? $nf["observacao"] = $observacao : null;

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

        for ($i = 0; $i <= 0; $i++) {

            $item = null;
            $item["tributa_municipio_prestador"] = $tributacaoMunicipioTomador;
            $item["codigo_local_prestacao_servico"] = $tributacaoMunicipioTomador ? $pessoaTomador->getEnderecoCidadeCodigoTom() : $pessoaEmitente->getEnderecoCidadeCodigoTom();
            // $item["unidade_codigo"=>"sr"
            // $item["unidade_quantidade"=>1,
            $valor ? $item["unidade_valor_unitario"] = $valor : null;
            $item["codigo_item_lista_servico"] = $codigoSubitemListaServico;
            $codigoAtividade ? $item["codigo_atividade"] = $codigoAtividade : null;
            $item["descritivo"] = $descritivo;
            $item["aliquota_item_lista_servico"] = $aliquota;
            $item["situacao_tributaria"] = $situacaoTributaria;
            $item["valor_tributavel"] = $valor;
            $valorDeducao ? $item["valor_deducao"] = $valorDeducao : null;
            $valorIssrf ? $item["valor_issrf"] = $valorIssrf : null;

            $itens["lista" . $i] = $item;
        }

        $nfse = [
            "nfse" => [
                "identificador" => $id,
                "rps" => [
                    "nro_recibo_provisorio" => $nroRps,
                    "serie_recibo_provisorio" => $serie,
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
