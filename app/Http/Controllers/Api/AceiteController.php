<?php

namespace App\Http\Controllers\Api;

use TCPDF;
use Illuminate\Http\Request;
use App\Models\AceiteEletronico;
use App\Http\Controllers\Controller;
use App\Mail\AceiteMail;
use App\Models\Positiva\ConContrato;
use App\Models\Positiva\ProdFeature;
use App\Models\Positiva\ProdProduto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AceiteController extends Controller
{
    public function index()
    {
        $cert = storage_path('POSITIVA_CONSULTAS.pfx');
        $certificado = file_get_contents($cert);

        if (openssl_pkcs12_read($certificado, $certs, '12345678')) {
            $privateKey = $certs['pkey'];
            $publicKey  = $certs['cert'];

            $content = openssl_x509_parse(openssl_x509_read($certs['cert']));

            $info = explode(':', $content['subject']['CN']);
            $company = $info[0];

            if (strlen($info[1]) == 14) {
                $type = 'CNPJ: ' . $info[1];
            } else {
                $type = 'CPF: ' . $info[1];
            }

            $info = $company . "\n" . $type . "\n" . 'Data: ' . date('d/m/Y H:i');

            // criando e configurando o PDF
            $pdf = new TCPDF('P', 'mm', 'P', true, 'UTF-8', false);

            // criando o cabeçalho do PDF com as informações do certificado
            $pdf->SetHeaderData('', 2, 'Assinado de forma digital por', $info, array(0, 0, 0), array(255, 255, 255));

            // definindo a fonte do cabeçalho do PDF
            $pdf->setHeaderFont(['helvetica', '', 9]);

            // definindo as margens do cabeçalho do PDF
            $pdf->SetMargins(15, 21, 15);
            $pdf->SetHeaderMargin(5);

            // removendo o rodapé do PDF
            $pdf->setPrintFooter(false);

            // assinando o PDF com a certificado (assinatura digital)
            $pdf->setSignature($publicKey, $privateKey, '', '', 2, '', 'A');

            // definindo a fonte e o título da página do PDF
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetTitle('Assinado de forma digital');
            $pdf->AddPage();

            // view contendo a página PDF que será imprimida
            $text = view('pdf');

            // área do certificado para clique no PDF
            $pdf->setSignatureAppearance(14.5, 3, 95, 20);

            // adicionando o conteúdo do certificado e do PDF para impressão
            $pdf->writeHTML($text, true, 0, true, 0);

            // modo de impressão
            //$pdf->Output(public_path('arquivo.pdf'), 'F'); // salva em um diretório
            $pdf->Output(public_path('arquivo.pdf'), 'D'); // baixa o pdf automaticamente
            //$pdf->Output('arquivo.pdf', 'I'); // abre no navegador

        }

        return 'ok';
    }

    public function setAceiteEletronico(Request $request)
    {
        $dados = $request->all();
        $user  = Auth::guard('api')->user();
        $string = $dados['id_contrato'] . date("YmdHis");
        $token = self::generateRandomString(20, $string);
        $senha = self::generateRandomString(4, date("YmdHis"));

        $model = new AceiteEletronico();
        $model->nome        = $dados['nome'];
        $model->email       = $dados['email'];
        $model->data_envio  = date("Y-m-d H:i:s");
        $model->data_final  = null;
        $model->contrato    = $dados['contrato'];
        $model->titulo      = $dados['titulo'];
        $model->token       = $token;
        $model->senha       = $senha;
        $model->url         = $token;
        $model->tabela_preco = $dados['tabela_preco'];
        $model->id_users    = $user->id;
        $model->id_contrato = $dados['id_contrato'];
        $model->status      = 0;

        if($model->save()){

            $dados = [
                'nome'      => $model->nome,
                'email'     => $model->email,
                'link'      => $model->url,
                'titulo'    => $model->titulo,
                'senha'     => $model->senha,
            ];

            try {
                Mail::to($dados['email'])->send(new AceiteMail($dados));
                $mail = true;
            } catch (\Exception $e) {
                $mail = false;
            }


            return response(['success' => true, 'message' => 'Aceite eletrônico cadastrado com sucesso!', 'data' => [
                'id'            => $model->id,
                'data_envio'    => $model->data_envio,
                'token'         => $model->token,
                'senha'         => $model->senha,
                'mail'          => $mail,
            ]], 200);

        }else{
            return response(['success' => false, 'message' => 'Erro ao cadastrar o aceite eletrônico!'], 400);
        }

    }

    public function getAceiteEletronico(Request $request)
    {
        $dados = $request->all();
        $model = AceiteEletronico::where('token', $dados['token'])->first();

        if($model != null){

            $data = [
                'nome'          => $model->nome,
                'cpf'           => $model->cpf,
                'email'         => $model->email,
                'telefone'      => $model->telefone,
                'ip'            => $model->ip,
                'dispositivo'   => $model->dispositivo,
                'data_envio'    => $model->data_envio,
                'data_aceite'   => $model->data_aceite,
                'data_final'    => $model->data_final,
                'hash_original' => $model->hash_original,
                'titulo'        => $model->titulo,
                'contrato'      => $model->contrato,
                'assinatura'    => $model->assinatura,
                'token'         => $model->token,
                'url'           => $model->url,
                'pdf'           => route('aceite.pdf', ['token' => $model->token]),
                'status'        => $model->status,
            ];

            return response(['success' => true, 'message' => 'Aceite eletrônico encontrado!', 'data' => $data], 200);

        }else{
            return response(['success' => false, 'message' => 'Aceite eletrônico não encontrado!'], 400);
        }
    }

    public function verificar($token)
    {
        $model = AceiteEletronico::where('token', $token)->first();

        if($model != null){
            session_start();
            if (isset($_SESSION['aceite'])) {
                $tokenss = $_SESSION['aceite']['token'];
                if($tokenss === $token){

                    if($model->status == 2){
                        return view('aceite.download', compact('token'));
                    }

                    $model->status = 1;
                    $model->save();
                    return view('aceite.view', compact('model'));
                }else{
                    unset($_SESSION['aceite']);
                    return redirect()->route('aceite.view.login', ['token' => $token]);
                }
            } else {
                return redirect()->route('aceite.view.login', ['token' => $token]);
            }
        }else{
            return redirect('https://www.positivaconsultas.com.br/');
        }
    }

    public function viewLogin($token)
    {
        return view('aceite.login', compact('token'));
    }

    public function login(Request $request)
    {
        $dados = $request->all();
        $model = AceiteEletronico::where('token', $dados['token'])->first();
        if($model->senha == $dados['senha']){
            session_start();
            $_SESSION['aceite'] = ['token' => $dados['token']];
            return redirect()->route('aceite', ['token' => $dados['token']]);
        }else{
            return redirect()->route('aceite', ['token' => $dados['token']]);
        }

    }

    public function getDownload($token){

        $file = storage_path() . "/aceite/pdf/" .$token .".pdf";

        if (file_exists($file)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=Documento.pdf');
            header('Pragma: no-cache');
            return readfile($file);
        } else {
            return "O arquivo não existe!";
        }

    }

    public function assinar(Request $request, $token)
    {
        $dados = $request->all();
        $model = AceiteEletronico::where('token', $token)->first();

        $model->cpf             = $dados['cpf'];
        $model->telefone        = $dados['telefone'];
        $model->ip              = self::get_client_ip();
        $model->dispositivo     = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $model->data_aceite     = date("Y-m-d H:i:s");
        $model->assinatura      = $dados['assinatura'];
        $model->status          = 2;

        if($model->save()){

            $img = $dados['assinatura'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = storage_path() . "/aceite/assinaturas/" .$token .".png";
            file_put_contents($file, $data);

            if($model->tabela_preco == 'S'){
                $contrato = ConContrato::where('id', $model->id_contrato)->first();
                $tabPreco = json_decode($contrato->aProdutosPrecosJson, true);

                //$ProdFeatures = ProdFeatures::find()->all();
                $ProdFeatures = ProdFeature::all();
                $aArrayFeatures = [];

                foreach ($ProdFeatures as $features){
                    $aArrayFeatures[$features->ID] = $features->aDescricao;
                }

                //$ProdProdutos = ProdProduto::find()->all();
                $ProdProdutos = ProdProduto::all();
                $aArrayProdutos = [];

                foreach ($ProdProdutos as $produto){
                    if($produto->nTipoPessoaDestin == 0){
                        $aArrayProdutos['PF'][$produto->ID] = $produto->aDescricao;
                    }else if($produto->nTipoPessoaDestin == 1) {
                        $aArrayProdutos['PJ'][$produto->ID] = $produto->aDescricao;
                    }

                }
            }

            $cert = storage_path('POSITIVA_CONSULTAS.pfx');
            $certificado = file_get_contents($cert);

            if (openssl_pkcs12_read($certificado, $certs, '12345678')) {
                $privateKey = $certs['pkey'];
                $publicKey  = $certs['cert'];

                $content = openssl_x509_parse(openssl_x509_read($certs['cert']));

                $info = explode(':', $content['subject']['CN']);
                $company = $info[0];

                if (strlen($info[1]) == 14) {
                    $type = 'CNPJ: ' . $info[1];
                } else {
                    $type = 'CPF: ' . $info[1];
                }

                $info = $company . "\n" . $type . "\n" . 'Data: ' . date('d/m/Y H:i');

                // criando e configurando o PDF
                $pdf = new TCPDF('P', 'mm', 'P', true, 'UTF-8', false);

                // criando o cabeçalho do PDF com as informações do certificado
                $pdf->SetHeaderData('', 2, 'Assinado de forma digital por', $info, array(0, 0, 0), array(255, 255, 255));

                // definindo a fonte do cabeçalho do PDF
                $pdf->setHeaderFont(['helvetica', '', 9]);

                // definindo as margens do cabeçalho do PDF
                $pdf->SetMargins(15, 21, 15);
                $pdf->SetHeaderMargin(5);

                // removendo o rodapé do PDF
                $pdf->setPrintFooter(false);

                // assinando o PDF com a certificado (assinatura digital)
                $pdf->setSignature($publicKey, $privateKey, '', '', 2, '', 'A');

                // definindo a fonte e o título da página do PDF
                $pdf->SetFont('helvetica', '', 12);
                $pdf->SetTitle('Assinado de forma digital');
                $pdf->AddPage();


                //$svgString = $dados["assinatura"];
                //$pdf->ImageSVG('@' . $svgString, $x=15, $y=30, $w='', $h='', $link='', $align='', $palign='', $border='', $fitonpage=false);
                //$params = $pdf->serializeTCPDFtagParameters(array('@' . $svgString, $x='', $y='', $w='', $h='', $link='http://www.tcpdf.org', $align='', $palign='', $border=1, $fitonpage=false));
                //$tcpdf_start1 = '<tcpdf method="ImageSVG" params="'.$params.'" />';

                // view contendo a página PDF que será imprimida
                $assinatura = '<img src="'. $file .'" border="0" height="60" width="300" align="bottom" />';
                //$assinatura = '<img src="'. asset('images/logo_04.png') .'" border="0" height="41" width="41" align="bottom" />';
                $texto_contrato = self::replaceTexto($model->contrato, $assinatura);
                //$text = view('pdf', compact('texto_contrato'));

                // área do certificado para clique no PDF
                $pdf->setSignatureAppearance(14.5, 3, 95, 20);


                // adicionando o conteúdo do certificado e do PDF para impressão
                if($model->tabela_preco == 'S'){
                    $pdf->writeHTML(view('pdf', compact('texto_contrato', 'tabPreco', 'aArrayFeatures', 'aArrayProdutos')), true, 0, true, 0);
                }else{
                    $pdf->writeHTML($texto_contrato, true, 0, true, 0);
                }

                // modo de impressão
                //$pdf->Output(public_path('arquivo.pdf'), 'F'); // salva em um diretório
                //$pdf->Output(public_path('arquivo.pdf'), 'D'); // baixa o pdf automaticamente
                //$pdf->Output('arquivo.pdf', 'I'); // abre no navegador
                $patch = storage_path('aceite/pdf/' . $token .'.pdf');
                $pdf->Output($patch, 'F');
            }

            return response(['success' => true, 'message' => 'Aceite eletrônico assinado com sucesso!', 'pdf' => ''], 200);
        }

    }

    public function teste()
    {
        $model = AceiteEletronico::where('token', '1IPt4WW12I750H38i1G20A8e2uVg502Up13')->first();
        $assinatura = '<img src="'. $model->assinatura .'" border="0" height="41" width="41" align="bottom" />';
        $texto_contrato = self::replaceTexto($model->contrato, $model->assinatura);
        $contrato = ConContrato::where('id', $model->id_contrato)->first();
        $tabPreco = json_decode($contrato->aProdutosPrecosJson, true);

        //$ProdFeatures = ProdFeatures::find()->all();
        $ProdFeatures = ProdFeature::all();
        $aArrayFeatures = [];

        foreach ($ProdFeatures as $features){
            $aArrayFeatures[$features->ID] = $features->aDescricao;
        }

        //$ProdProdutos = ProdProduto::find()->all();
        $ProdProdutos = ProdProduto::all();
        $aArrayProdutos = [];

        foreach ($ProdProdutos as $produto){
            if($produto->nTipoPessoaDestin == 0){
                $aArrayProdutos['PF'][$produto->ID] = $produto->aDescricao;
            }else if($produto->nTipoPessoaDestin == 1) {
                $aArrayProdutos['PJ'][$produto->ID] = $produto->aDescricao;
            }

        }

        return view('pdf', compact('texto_contrato', 'tabPreco', 'aArrayFeatures', 'aArrayProdutos'));
    }

    private static function replaceTexto($texto,$assinatura)
    {
        $newTexto = $texto;
        $newTexto = str_replace('[[Assinatura Positiva]]',  '<img src="'. storage_path() . "/aceite/assinaturas/positiva_consulta.png" .'" border="0" height="60" width="300" align="bottom" />',      $newTexto);
        $newTexto = str_replace('[[Assinatura Cliente]]',   $assinatura,    $newTexto);
        $newTexto = str_replace('[[Data Assinatura]]',      date("d/m/Y"),  $newTexto);
        $newTexto = str_replace('[[Dia Assinatura]]',       date("d"),      $newTexto);
        $newTexto = str_replace('[[Mes Assinatura]]',       date("m"),      $newTexto);
        $newTexto = str_replace('[[Ano Assinatura]]',       date("Y"),      $newTexto);

        return $newTexto;
    }

    private static function enviarAceiteEletronico($dados)
    {
        return '';
    }

    private static function generateRandomString($size = 7, $randomString=''){

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";

        for($i = 0; $i < $size; $i = $i+1){
           $randomString .= $chars[mt_rand(0,60)];
        }
        return str_shuffle($randomString);
    }

    private static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}
