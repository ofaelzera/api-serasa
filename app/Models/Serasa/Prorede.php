<?php

namespace App\Models\Serasa;

use App\Models\Positiva\BaseTabCidade;
use App\Models\Positiva\ConCliente;
use App\Models\Positiva\ConContrato;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Positiva\ConEmpresa;

class Prorede
{

    private static $PRODUCAO = TRUE;

    public static function isProducao()
    {
        return (auth('api')->user()->isProducao == 1) ? true : false;
    }

    public static function getUrl($type)
    {
        if(self::isProducao()) {

            switch ($type) {
                case 'analyse_sales':
                    return 'https://api.serasaexperian.com.br/sales/v1/analyse-sales-distributor/';
                break;
                case 'partners_orders':
                    return 'https://api.serasaexperian.com.br/sales/v1/partners/orders/';
                break;
            }

        }else{

            switch ($type) {
                case 'analyse_sales':
                    return 'https://uat-api.serasaexperian.com.br/sales/v1/analyse-sales-distributor/';
                break;
                case 'partners_orders':
                    return 'https://uat-api.serasaexperian.com.br/sales/v1/partners/orders/';
                break;
            }

        }

    }

    public static function getAnalyseSales($data = null)
    {
        try {
            $Bearer         = Serasa::getLoginApiSerasa(self::$PRODUCAO);
            $url            = self::getUrl('analyse_sales') . '';
            $client         = new Client();
            $modelEmpresa   = ConEmpresa::find(1);
            $cnpj           = 0 . Serasa::getReplace($modelEmpresa->aCnpj, 8);
            $cnpjCli        = 0 . Serasa::getReplace($data['cnpjIndireto'], 8);
            $email          = (isset($data['emailIndireto']) ? $data['emailIndireto'] : '');

            $URL            = $url . $cnpj. '?indirectCustomerDocument=' . $cnpjCli . '&indirectCustomerEmail=' . $email;

            $res = $client->request('GET', $URL, [
                'headers' => [
                    'content-type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $Bearer['accessToken'],
                ]
            ]);

            if ($res->getStatusCode() == 200){
                $response_data = json_decode($res->getBody()->getContents(), true);
            }else{
                $response_data = null;
            }

            return $response_data;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function getPartnersOrders($data = null)
    {
        try {

            $Bearer         = Serasa::getLoginApiSerasa(self::isProducao());
            $url            = self::getUrl('partners_orders') . '';
            $client         = new Client();
            $modelEmpresa   = ConEmpresa::find(1);
            $cnpj           = 0 . Serasa::getReplace($modelEmpresa->aCnpj, 8);
            $contrato       = ConContrato::find($data['n_conttrato']);
            $cliente        = ConCliente::find($contrato->nIdCliente);
            $cidade         = BaseTabCidade::find($cliente->nIdCidade);

            $URL            = $url . $cnpj ;

            $cnpj_client =   Serasa::getReplace($cliente->aCNPJ, 14);

            $body = \json_encode(
                [
                    'tipoRegistro'              => Serasa::getSoNumeroZeroEsquerda(1, 3),
                    'cnpjIndireto'              => 0 . Serasa::getReplace($cliente->aCNPJ, 8),
                    'filialIndireto'            => substr($cnpj_client, 8, 4),
                    'digitoIndireto'            => substr($cnpj_client, 12, 2),
                    'razaoSocialIndireto'       => $cliente->aRazao,
                    'nomeFantasia'              => $cliente->aFantasia,
                    'enderecoIndireto'          => $cliente->aEndereco,
                    'bairro'                    => $cliente->aBairro,
                    //'cep'                       => $cliente->nCEP,
                    'cep'                       => Serasa::getSoNumeroZeroEsquerda($cliente->nCEP, 8),
                    'cidade'                    => $cidade->aMunicipio,
                    'uf'                        => $cidade->aUF,
                    'ddd'                       => Serasa::getSoNumeroZeroEsquerda($cliente->nDDD, 5),
                    'telefone'                  => Serasa::getSoNumeroZeroEsquerda($cliente->aFone, 9),
                    'ramal'                     => null,
                    'contato'                   => $cliente->aContato,
                    'agencia'                   => $cliente->nAgencia,
                    'contaCorrente'             => $cliente->nContaCorrente,
                    'email'                     => $cliente->aEmail,
                ]
                ,true);

            $res = $client->request('POST', $URL, [
                'headers' => [
                    'content-type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $Bearer['accessToken'],
                ],
                'body' => $body
            ]);

            if ($res->getStatusCode() == 200){
                $response_data = json_decode($res->getBody()->getContents(), true);
            }
            else if ($res->getStatusCode() == 201){
                $response_data = json_decode($res->getBody()->getContents(), true);
            }
            else{
                $response_data = null;
            }

            return $response_data;

        } catch (\Throwable $th) {
            return ['error' => $th->getMessage(), 'code' => $th->getCode()];
        }
    }

}
