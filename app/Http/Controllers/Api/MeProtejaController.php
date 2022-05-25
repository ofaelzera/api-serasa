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
            return response(['info' => 'Não existem relatorios para serem enviados!'], 400);
        }

        $arr = json_decode($relatorio->aJson, true);
        $arr = $this->TrataArr($arr);

        foreach($arr as $array){

            if(isset($array["empresa_consultada"])){
                $doc = substr($array["empresa_consultada"]["cnpj"], 0, 2) . '.' . substr($array["empresa_consultada"]["cnpj"], 2, 3) . '.' . substr($array["empresa_consultada"]["cnpj"], 5, 3);
                $meproteja = DB::connection('mysql_2')
                ->table('ConMeProteja')
                ->select('*')
                ->where('aDocumento', 'LIKE', '%'. $doc .'%')
                ->first();

                if($meproteja != null){
                    //$meproteja->aEmail
                    Mail::to($meproteja->aEmail)->send(new MailSendMeProteja(['array' => $array]));
                    $doc = null;
                    $meproteja = null;
                }
            }else
            if(isset($array["pessoa_consultada"])){
                $doc = substr($array["pessoa_consultada"]["cpf"], 0, 3) . '.' . substr($array["pessoa_consultada"]["cpf"], 3, 3) . '.' . substr($array["pessoa_consultada"]["cpf"], 6, 3);
                $meproteja = DB::connection('mysql_2')
                ->table('ConMeProtejaSocio')
                ->select('*')
                ->where('aDocumentoSocio', 'LIKE', '%'. $doc .'%')
                ->first();

                if($meproteja != null){
                    //$meproteja->aEmail;
                    Mail::to($meproteja->aEmail)->send(new MailSendMeProteja(['array' => $array]));
                    $doc = null;
                    $meproteja = null;
                }
            }

        }

        $relatorio->nStatus = 1;
        $relatorio->save();
        return response(['success' => 'OK', 'data' => 'Email enviado com sucesso!'], 200);

        /*
        $meproteja = DB::connection('mysql_2')
        ->table('ConMeProteja')
        ->select('*')
        ->where('aDocumento', 'LIKE', '%'. $doc .'%')
        ->first();
        */
        //$meproteja->aEmail;
        //Mail::to($meproteja->aEmail)->send(new MailSendMeProteja(['dados_meproteja' => $meproteja, 'dados_relatorio' => $arr]));
        //$ID = $relatorio->ID;
        //$relatorio = ConMeProtejaRelatorio::find($ID);
        //$relatorio->nStatus = 1;
        //$relatorio->save();

        //return view('meproteja.relatorio', compact('meproteja', 'arr'));
        //return response(['success' => 'OK', 'data' => 'Email enviado com sucesso!'], 200);
        //return view('meproteja.relatorio', compact('meproteja', 'arr'));
        //return $arr;
    }


    private function TrataArr($Arr)
    {
        $newArr = [];
        if(!isset($Arr["Relatorio"]["dadosRelato"][0])){
            $subs = $Arr["Relatorio"]["dadosRelato"];
            $Arr["Relatorio"]["dadosRelato"] = [];
            $Arr["Relatorio"]["dadosRelato"][0] = $subs;
        }

        if(isset($Arr["Relatorio"]["dadosRelato"][0])){

            foreach($Arr["Relatorio"]["dadosRelato"] as $key => $value){

                if(isset($value["empresaConsultada"]["CNPJ"])){
                    $newArr[$key]['empresa_consultada']['cnpj']                         = (isset($value["empresaConsultada"]["CNPJ"]["_text"]) ? $value["empresaConsultada"]["CNPJ"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['descricao_situacao_documento'] = (isset($value["empresaConsultada"]["DescricaoSituacaoDocumento"]["_text"]) ? $value["empresaConsultada"]["DescricaoSituacaoDocumento"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['situcao_documento']            = (isset($value["empresaConsultada"]["SituacaoDocumento"]["_text"]) ? $value["empresaConsultada"]["SituacaoDocumento"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['razao_social']                 = (isset($value["empresaConsultada"]["RazaoSocial"]["_text"]) ? $value["empresaConsultada"]["RazaoSocial"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['nome_fantasia']                = (isset($value["empresaConsultada"]["NomeFantasia"]["_text"]) ? $value["empresaConsultada"]["NomeFantasia"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['descricao_tipo_sociedade']     = (isset($value["empresaConsultada"]["DescricaoTipoSociedade"]["_text"]) ? $value["empresaConsultada"]["DescricaoTipoSociedade"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['antecessoras']['razao_social'] = (isset($value["empresaConsultada"]["Antecessoras"]["antecessora"]["RazaoSocialAntecessora"]["_text"]) ? $value["empresaConsultada"]["Antecessoras"]["antecessora"]["RazaoSocialAntecessora"]["_text"] : '');
                    $newArr[$key]['empresa_consultada']['antecessoras']['data_razao']   = (isset($value["empresaConsultada"]["Antecessoras"]["antecessora"]["DataRazaoSocialAntecessora"]["_text"]) ? $value["empresaConsultada"]["Antecessoras"]["antecessora"]["DataRazaoSocialAntecessora"]["_text"] : '');
                }else
                if(isset($value["pessoaConsultada"]["CPF"])){
                    $newArr[$key]['pessoa_consultada']['cpf']                           = (isset($value["pessoaConsultada"]["CPF"]["_text"]) ? $value["pessoaConsultada"]["CPF"]["_text"] : '');
                    $newArr[$key]['pessoa_consultada']['codigo_situca_documento']       = (isset($value["pessoaConsultada"]["CodigoSituacaoCadastral"]["_text"]) ? $value["pessoaConsultada"]["CodigoSituacaoCadastral"]["_text"] : '');
                    $newArr[$key]['pessoa_consultada']['descricao_situacao_documento']  = (isset($value["pessoaConsultada"]["DescricaoSituacaoCadastral"]["_text"]) ? $value["pessoaConsultada"]["DescricaoSituacaoCadastral"]["_text"] : '');
                    $newArr[$key]['pessoa_consultada']['nome']                          = (isset($value["pessoaConsultada"]["Nome"]["_text"]) ? $value["pessoaConsultada"]["Nome"]["_text"] : '');
                }

                if(isset($value["apontamentos"]["PendenciasFinanceiras"]["Mensagem"]["Mensagem"]["_text"])
                && $value["apontamentos"]["PendenciasFinanceiras"]["Mensagem"]["Mensagem"]["_text"] == "=== NADA CONSTA PARA O CNPJ CONSULTADO ==="){

                }else{

                    if(isset($value["apontamentos"]["PendenciasFinanceiras"]["Pefins"])){

                        $newArr[$key]['apontamentos']['pefins']['quantidade'] = (isset($value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Quantidade"]["_text"]) ? $value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Quantidade"]["_text"] : '');
                        if(!isset($value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Pefin"][0])){
                            $subs = $value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Pefin"];
                            $value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Pefin"] = [];
                            $value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Pefin"][0] = $subs;

                        }
                        foreach($value["apontamentos"]["PendenciasFinanceiras"]["Pefins"]["Pefin"] as $index => $pefin){
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['data_ocorrencia']     = (isset($pefin["DataOcorrencia"]["_text"])     ? $pefin["DataOcorrencia"]["_text"] : '');
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['descricao_natureza']  = (isset($pefin["DescricaoNatureza"]["_text"])  ? $pefin["DescricaoNatureza"]["_text"] : '');
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['avalista']            = (isset($pefin["Pefins"]["Pefin"][0]["Avalista"]["_text"]) ? $pefin["Avalista"]["_text"] : '');
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['valor']               = (isset($pefin["Valor"]["_text"])      ? $pefin["Valor"]["_text"] : '');
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['contrato']            = (isset($pefin["Contrato"]["_text"])   ? $pefin["Contrato"]["_text"] : '');
                            $newArr[$key]['apontamentos']['pefins']['pefin'][$index]['origem']              = (isset($pefin["Origem"]["_text"])     ? $pefin["Origem"]["_text"] : '');
                        }
                    }

                    if(isset($value["apontamentos"]["PendenciasFinanceiras"]["Refins"])){

                        $newArr[$key]['apontamentos']['refins']['quantidade'] = (isset($value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Quantidade"]["_text"]) ? $value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Quantidade"]["_text"] : '');
                        if(!isset($value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Refin"][0])){
                            $subs = $value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Refin"];
                            $value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Refin"] = [];
                            $value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Refin"][0] = $subs;
                        }
                        foreach($value["apontamentos"]["PendenciasFinanceiras"]["Refins"]["Refin"] as $index => $pefin){
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['data_ocorrencia']     = (isset($pefin["DataOcorrencia"]["_text"]) ? $pefin["DataOcorrencia"]["_text"] : '');
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['descricao_natureza']  = (isset($pefin['DescricaoNatureza']['_text']) ? $pefin["DescricaoNatureza"]["_text"] : '');
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['avalista']            = (isset($pefin['Avalista']['_text']) ? $pefin["Avalista"]["_text"] : '');
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['valor']               = (isset($pefin['Valor']['_text']) ? $pefin["Valor"]["_text"] : '');
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['contrato']            = (isset($pefin['Contrato']['_text']) ? $pefin["Contrato"]["_text"] : '');
                            $newArr[$key]['apontamentos']['refins']['refin'][$index]['origem']              = (isset($pefin['Origem']['_text']) ? $pefin["Origem"]["_text"] : '');
                        }
                    }

                }

                if(isset($value["apontamentos"]["Protestos"])){

                    $newArr[$key]['apontamentos']['protestos']['quantidade'] = (isset($value["apontamentos"]["Protestos"]["Quantidade"]["_text"]) ? $value["apontamentos"]["Protestos"]["Quantidade"]["_text"] : '');
                    if(isset($value["apontamentos"]["Protestos"]["Protesto"][0])){
                        foreach($value["apontamentos"]["Protestos"]["Protesto"] as $index => $protesto){
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['data_ocorrencia']       = (isset($protesto["DataOcorrencia"]["_text"]) ? $protesto["DataOcorrencia"]["_text"] : '');
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['tipo_moeda']            = (isset($protesto["TipoMoeda"]["_text"]) ? $protesto["TipoMoeda"]["_text"] : '');;
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['valor']                 = (isset($protesto["Valor"]["_text"]) ? $protesto["Valor"]["_text"] : '');;
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['cartorio']              = (isset($protesto["Cartorio"]["_text"]) ? $protesto["Cartorio"]["_text"] : '');;
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['cidade_ocorrencia']     = (isset($protesto["CidadeOcorrencia"]["_text"]) ? $protesto["CidadeOcorrencia"]["_text"] : '');;
                            $newArr[$key]['apontamentos']['protestos']['protesto'][$index]['uf_ocorrencia']         = (isset($protesto["UFOcorrencia"]["_text"]) ? $protesto["UFOcorrencia"]["_text"] : '');;
                        }
                    }

                }

                if(isset($value["apontamentos"]["ChequesSemFundoAchei"])){

                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['quantidade']         = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Quantidade"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Quantidade"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['data_ocorrencia']    = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["DataOcorrencia"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["DataOcorrencia"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['numero']             = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Numero"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Numero"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['alinea']             = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Alinea"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Alinea"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['moeda']              = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Moeda"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Moeda"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['valor']              = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Valor"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Valor"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['banco']              = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Banco"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Banco"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['agencia']            = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Agencia"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Agencia"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['cidade']             = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Cidade"]["_text"]) ?  $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["Cidade"]["_text"] : '');
                    $newArr[$key]['apontamentos']['ChequesSemFundoAchei']['uf']                 = (isset($value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["UFOcorrencia"]["_text"]) ? $value["apontamentos"]["ChequesSemFundoAchei"]["ChequeSemFundoAchei"]["UFOcorrencia"]["_text"] : '');

                }

                if(isset($value["apontamentos"]["ChequesExtraviadoSustadoRecheque"]["Mensagem"]["Mensagem"]["_text"])
                && $value["apontamentos"]["ChequesExtraviadoSustadoRecheque"]["Mensagem"]["Mensagem"]["_text"] == "=== NADA CONSTA PARA O CNPJ CONSULTADO ==="){

                }else{

                }

                if(isset($value["concentres"]["Concentre"]["Mensagens"]["Mensagem"]["Mensagem"]["_text"])
                && $value["concentres"]["Concentre"]["Mensagens"]["Mensagem"]["Mensagem"]["_text"] == "=== NADA CONSTA PARA O CNPJ CONSULTADO ==="){

                }else{

                    if(!isset($value["concentres"]["Concentre"][0])){
                        $subs = $value["concentres"]["Concentre"];
                        $value["concentres"]["Concentre"] = array();
                        $value["concentres"]["Concentre"][0] = $subs;
                    }
                    foreach($value["concentres"]["Concentre"] as $index => $concentre){

                        $newArr[$key]['Concentre'][$index]['quantidade']        = (isset($concentre["Quantidade"]["_text"]) ? $concentre["Quantidade"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['discriminacao']     = (isset($concentre["Discriminacao"]["_text"]) ? $concentre["Discriminacao"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['data_inicial']      = (isset($concentre["DataInicial"]["_text"]) ? $concentre["DataInicial"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['data_final']        = (isset($concentre["DataFinal"]["_text"]) ? $concentre["DataFinal"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['moeda']             = (isset($concentre["Moeda"]["_text"]) ? $concentre["Moeda"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['valor']             = (isset($concentre["Valor"]["_text"]) ? $concentre["Valor"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['origem']            = (isset($concentre["Origem"]["_text"]) ? $concentre["Origem"]["_text"] : '');
                        $newArr[$key]['Concentre'][$index]['praca']             = (isset($concentre["Praca"]["_text"]) ? $concentre["Praca"]["_text"] : '');

                    }

                }

                if(isset($value["CartasComunicados"]["CartasComunicado"])){

                    if(isset($value["CartasComunicados"]["CartasComunicado"][0])){

                        foreach($value["CartasComunicados"]["CartasComunicado"] as $index => $cartas){

                            $newArr[$key]['CartasComunicados'][$index]['tipo_inlclusao']        = (isset($cartas["TipoInclusao"]["_text"]) ? $cartas["TipoInclusao"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['documento']             = (isset($cartas["Documento"]["_text"]) ? $cartas["Documento"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['numero_comunicacao']    = (isset($cartas["NumeroComunicacao"]["_text"]) ? $cartas["NumeroComunicacao"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['tipo_ocorrencia']       = (isset($cartas["TipoOcorrencia"]["_text"]) ? $cartas["TipoOcorrencia"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['data_ocorrencia']       = (isset($cartas["DataOcorrencia"]["_text"]) ? $cartas["DataOcorrencia"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['data_envio']            = (isset($cartas["DataEnvio"]["_text"]) ? $cartas["DataEnvio"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['data_limite']           = (isset($cartas["DataLimite"]["_text"]) ? $cartas["DataLimite"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['data_baixa']            = (isset($cartas["DataBaixa"]["_text"]) ? $cartas["DataBaixa"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['status']                = (isset($cartas["Status"]["_text"]) ? $cartas["Status"]["_text"] : '');
                            $newArr[$key]['CartasComunicados'][$index]['instituicao_credora']   = (isset($cartas["InstituicaoCredora"]["_text"]) ? $cartas["InstituicaoCredora"]["_text"] : '');

                        }

                    }else{
                        $newArr[$key]['CartasComunicados'][0]['tipo_inlclusao']        = (isset($value["CartasComunicados"]["CartasComunicado"]["TipoInclusao"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["TipoInclusao"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['documento']             = (isset($value["CartasComunicados"]["CartasComunicado"]["Documento"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["Documento"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['numero_comunicacao']    = (isset($value["CartasComunicados"]["CartasComunicado"]["NumeroComunicacao"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["NumeroComunicacao"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['tipo_ocorrencia']       = (isset($value["CartasComunicados"]["CartasComunicado"]["TipoOcorrencia"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["TipoOcorrencia"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['data_ocorrencia']       = (isset($value["CartasComunicados"]["CartasComunicado"]["DataOcorrencia"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["DataOcorrencia"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['data_envio']            = (isset($value["CartasComunicados"]["CartasComunicado"]["DataEnvio"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["DataEnvio"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['data_limite']           = (isset($value["CartasComunicados"]["CartasComunicado"]["DataLimite"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["DataLimite"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['data_baixa']            = (isset($value["CartasComunicados"]["CartasComunicado"]["DataBaixa"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["DataBaixa"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['status']                = (isset($value["CartasComunicados"]["CartasComunicado"]["Status"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["Status"]["_text"] : '');
                        $newArr[$key]['CartasComunicados'][0]['instituicao_credora']   = (isset($value["CartasComunicados"]["CartasComunicado"]["InstituicaoCredora"]["_text"]) ? $value["CartasComunicados"]["CartasComunicado"]["InstituicaoCredora"]["_text"] : '');
                    }
                }

            }

        }else{

        }

        return $newArr;
    }

}
