<?php

namespace App\Models\Serasa;
use Illuminate\Support\Facades\Http;

class Prorede
{

    private static $PRODUCAO = false;

    public static function isProducao()
    {
        return self::$PRODUCAO;
    }

    public static function getUrl($type)
    {
        if(self::$PRODUCAO) {

            switch ($type) {
                case 'analyse_sales':
                    return 'https://api.serasaexperian.com.br/sales/v1/analyse-sales-distributor/';
                break;
            }

        }else{

            switch ($type) {
                case 'analyse_sales':
                    return 'https://uat-api.serasaexperian.com.br/sales/v1/analyse-sales-distributor/';
                break;
            }

        }

    }

    public static function getAnalyseSales($data = null)
    {
        try {


            $Bearer = Serasa::getLoginApiSerasa(self::$PRODUCAO);

            $url = self::getUrl('analyse_sales') . '';
            $res = Http::get($url);

            if ($res->getStatusCode() == 200){
                $response_data = $res->json();
            }else{
                $response_data = null;
            }

            return $response_data;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
