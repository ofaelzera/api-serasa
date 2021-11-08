<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Positiva\ConCliente;
use App\Models\Positiva\ConContrato;
use App\Models\Serasa\Concentre;
use App\Models\Util\RotGen;
use Illuminate\Support\Facades\Auth;

class ConcentreController extends Controller
{
    public function consulta_cnpj(Request $request){

        $id_client = Auth::guard('api')->user()->id_empresa;
        $Cliente = ConCliente::where('ID', '=', $id_client)->where('nStatus', '<>', 99)->first();
        if($Cliente == null){
            return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
        }else{
            $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
        }
        if($Contrato == null){
            return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
        }
        if(!$this->valida_request($request->all()[0])){
            return response(['error' => 'dados informado inválido'], 400);
        }

        $cnpj_consulta      = RotGen::limpaString($request['cnpj_consulta']);
        $cnpj_consultante   = RotGen::limpaString($Cliente->aCNPJ);
        $logon_consultante  = json_decode($Contrato->aArrayLogonSenha, true);

        $data = $request->all()[0];

        //inicio bloco p002
        $P002[0] = 'RSPU';
        if(count($data['P002']) > 0){
            foreach($data['P002'] as $feat){
                array_push($P002, $feat);
            }
        }
        //end bloco p002

        //inicio do bloco i001
        $I001 = [];
        foreach($data['I001'] as $feat){
            foreach($feat as $key => $ft){
                $I001[$key] = $ft;
            }
        }
        //end do bloco i001

        $aConsulta = [
            'DOCCONSULTA'       => $cnpj_consulta,
            'TIPOPESSOA'        => 'J',
            'CONSULTANTE'       => $cnpj_consultante,
            'LOGON'             => $logon_consultante[0]['aLogon'],
            'I001'              => $I001,
            'P002'              => $P002,
        ];

        $consulta = Concentre::getConsultaConcentre($aConsulta);

    }

    public function consulta_cpf(){

    }

    private static function valida_request($request)
    {
        if(!isset($request['cnpj_consulta'])){ return false; }
        if(!isset($request['P002'])){ return false; }
        if(!isset($request['I001'])){ return false; }

        return true;
    }

}
