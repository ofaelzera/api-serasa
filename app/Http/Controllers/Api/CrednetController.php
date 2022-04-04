<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serasa\Crednet;
use Illuminate\Http\Request;

class CrednetController extends Controller
{

    public function index()
    {
        $data = [
            'cnpj_consulta'     => '08092175977',
            'cnpj_consultante'  => '37530040000155',
            'logon'             => '25632993',
            'tipo_pessoa'       => 'F',
            'P002'              => [
                'RELB',     //Localizador
                'CLC7',     //Limite de Credito
                'CGFN',     //Gasto Estimado
                'MSM5',     //Segmentação mosaic
                'REDC',     //Recomenda crédito
                'REIC',     //Indicador de recuperação de credito
                'RMF9',     //Indice de relacionamente mercado setor
                'PCDJ',     //Histórico Pagamento Comercial - Básico
                'REHM',     //Serasa Score PF
                'REHMHSPN', //Novo modelo de score positivo
                'RERD',     //Renda Estimada – PF
                'REPG',     //Capacidade de Pagamento – PF
                'RETM',     //Comprometimento de Renda - PF
            ],
            'N003'              => [
                'REIF',     //Alerta de cheque
                'CAFY',     //Alerta de identidade
                'RXCF',     //Anotações Completas
                'RMF3',     //IRM
                'AL24',     //Alerta de óbito
                'CRPN',     //Renda Presumida
                'RXPS',     //Participação societária
                'RECP',     //Score Serasa PF
            ]
        ];

        return response($data, 200);
    }

    public function consulta_pessoa(Request $request)
    {
        $dados = $request->all();
        $consulta = Crednet::getConsultaCredNet($dados);
        //$consulta = Crednet::getConsultaCredNet_($dados);

        if($consulta['success'] == true){
            return response(['success' => $consulta['data']], 200);
            //return response(['error' => $consulta['data']], 400);
        }else{
            return response(['error' => $consulta['data']], 400);
        }
    }
}
