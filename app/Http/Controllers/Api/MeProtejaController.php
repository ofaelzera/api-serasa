<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Serasa\MeProteja;
use App\Models\Positiva\ConCliente;
use App\Http\Controllers\Controller;
use App\Mail\MailSendMeProteja;
use App\Mail\MeProteja as MailMeProteja;
use App\Models\Positiva\ConContrato;
use App\Models\Positiva\ConMeProteja;
use App\Models\Positiva\ConMeProtejaRelatorio;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;




class MeProtejaController extends Controller
{
    public function incluirEmpresa(Request $request)
    {
        try {

            $request->validate([
                'cnpj'                  => 'required',
                'plano_monitoramento'   => 'required',
                'modalidade_cobranca'   => 'required',
                'email'                 => 'required',
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
                try {
                    //Mail::to('')->send('');
                    $email = $request->all()['email'];
                    Mail::to($email)->send(new MailMeProteja($result));
                    return response(['success' => 'OK', 'data' => $result['data']], 200);
                } catch (\Throwable $th) {
                    return response(['error' => $result['code'], 'data' => $result['message']], 400);
                }
            }else{
                return response(['error' => $result['code'], 'data' => $result['message']], 400);
            }

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 400);
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

    public function incluir_dados(Request $request)
    {
        try {

            $request->validate([
                'cliente'       => 'required',
                'distribuidor'  => 'required',
                'json'          => 'required',
            ]);

            $data = MeProteja::incluir_dados($request->all());

            if(isset($data['error'])){
                return response(
                    [
                        'error'     => 'Mensagem não incluida',
                        'mensagem'  => $data
                    ],
                401);
            }

            return response(['success' => 'ok', 'data' => $data], 200);

        } catch (\Throwable $th) {

            return response(
                [
                    'error'     => 'Mensagem não incluida',
                    'mensagem'  => $th->getMessage(),
                    'code'      => $th->getCode()
                ],
                401);
        }
    }

    public function sendMail()
    {
        $relatorio = DB::connection('mysql_2')
        ->table('ConMeProtejaRelatorio')
        ->select('*')
        ->where('nStatus', '=', 0)
        ->first();

        if($relatorio == null){
            return response(['error' => 'Não existem relatorios para serem enviados!'], 400);
        }

        $arr = json_decode($relatorio->aJson, true);
        $doc = substr($arr["Relatorio"]["_attributes"]["cliente"], 1);
        $doc = substr($doc, 0, 2) . "." . substr($doc, 2, 3) . "." . substr($doc, 5, 3);

        $meproteja = DB::connection('mysql_2')
        ->table('ConMeProteja')
        ->select('*')
        ->where('aDocumento', 'LIKE', '%'. $doc .'%')
        ->first();

        if($meproteja == null){

            $doc = $arr["Relatorio"]["dadosRelato"]["empresaConsultada"]["CNPJ"]["_text"];
            $doc = substr($doc, 0, 3) . "." . substr($doc, 3, 3) . "." . substr($doc, 6, 3) . "-" . substr($doc, 9, 2);

            $meproteja = DB::connection('mysql_2')
            ->table('ConMeProtejaSocio')
            ->select('*')
            ->where('aDocumentoSocio', 'LIKE', '%'. $doc .'%')
            ->first();

            if($meproteja == null){
                return [];
            }
        }
        //$meproteja->aEmail;
        Mail::to($meproteja->aEmail)->send(new MailSendMeProteja(['dados_meproteja' => $meproteja, 'dados_relatorio' => $arr]));
        $ID = $relatorio->ID;
        $relatorio = ConMeProtejaRelatorio::find($ID);
        $relatorio->nStatus = 1;
        $relatorio->save();

        //return view('meproteja.relatorio', compact('meproteja', 'arr'));
        return response(['success' => 'OK', 'data' => 'Email enviado com sucesso!'], 200);
        //return view('meproteja.relatorio', compact('meproteja', 'arr'));
        //return $arr;

    }

}
