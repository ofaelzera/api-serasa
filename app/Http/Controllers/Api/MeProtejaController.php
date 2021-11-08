<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Positiva\ConCliente;
use App\Models\Positiva\ConContrato;

use App\Models\Serasa\MeProteja;


class MeProtejaController extends Controller
{
    public function incluirEmpresa(Request $request)
    {
        try {

            $request->validate([
                'cnpj'                  => 'required',
                'plano_monitoramento'   => 'required',
                'modalidade_cobranca'   => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }

            */

            $result = MeProteja::incluir_empresa($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

    public function excluirEmpresa(Request $request)
    {
        try {
            $request->validate([
                'cnpj'                  => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }

            */

            $result = MeProteja::excluir_empresa($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

    public function consultarEmpresa(Request $request)
    {
        try {
            $request->validate([
                'cnpj'                  => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }

            */

            $result = MeProteja::consultar_empresa($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

    public function incluirSocio(Request $request)
    {
        try {
            $request->validate([
                'cnpj'              => 'required',
                'tipo_pessoa'       => 'required',
                'documento_socio'   => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }
            */

            $result = MeProteja::incluir_socio($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

    public function excluirSocio(Request $request)
    {
        try {
            $request->validate([
                'cnpj'              => 'required',
                'tipo_pessoa'       => 'required',
                'documento_socio'   => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }
            */

            $result = MeProteja::excluir_socio($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

    public function consultarSocio(Request $request)
    {
        try {
            $request->validate([
                'cnpj'              => 'required',
                'tipo_pessoa'       => 'required',
                'documento_socio'   => 'required',
            ]);

            /*
            $Cliente = ConCliente::where('aCNPJ', '=', $request['cnpj'])->where('nStatus', '<>', 99)->first();

            if($Cliente == null){
                return response(['error' => 'o cnpj não existem em nossa base de dados!'], 400);
            }else{
                $Contrato = ConContrato::where('nIdCliente', '=', $Cliente->ID)->where('nStatus', '<>', 99)->first();
            }

            if($Contrato == null){
                return response(['error' => 'o cnpj não contem contrato ativo!'], 400);
            }
            */

            $result = MeProteja::consultar_socio($request->all());

            if($result['success'] == 'true'){
                return response(['success' => 'OK', 'data' => $result['data']], 200);
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 200);
        }
    }

}
