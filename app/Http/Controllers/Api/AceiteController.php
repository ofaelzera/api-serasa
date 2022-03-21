<?php

namespace App\Http\Controllers\Api;

use TCPDF;
use Illuminate\Http\Request;
use App\Models\AceiteEletronico;
use App\Http\Controllers\Controller;
use App\Mail\AceiteMail;
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

        $model = new AceiteEletronico();
        $model->nome        = $dados['nome'];
        $model->email       = $dados['email'];
        $model->data_envio  = date("Y-m-d H:i:s");
        $model->data_final  = null;
        $model->contrato    = $dados['contrato'];
        $model->titulo      = $dados['titulo'];
        $model->token       = $token;
        $model->url         = $token;
        $model->id_users    = $user->id;
        $model->id_contrato = $dados['id_contrato'];
        $model->status      = 0;

        if($model->save()){

            $dados = [
                'nome'      => $model->nome,
                'email'     => $model->email,
                'link'      => $model->url,
                'titulo'    => $model->titulo,
            ];

            //$envia = self::enviarAceiteEletronico($dados);

            return response(['success' => true, 'message' => 'Aceite eletrônico cadastrado com sucesso!', 'data' => [
                'id'            => $model->id,
                'data_envio'    => $model->data_envio,
                'token'         => $model->token,
            ]], 200);

        }else{
            return response(['success' => false, 'message' => 'Erro ao cadastrar o aceite eletrônico!'], 400);
        }

    }

    public function verificar($token)
    {
        $model = AceiteEletronico::where('token', $token)->first();
        return view('aceite.view', compact('model'));
    }

    public function assinar(Request $request, $token)
    {
        $dados = $request->all();
        $model = AceiteEletronico::where('token', $token)->first();

        $model->cpf;
        $model->telefone;
        $model->ip;
        $model->dispositivo;
        $model->data_aceite;
        $model->status;


        return response(['success' => true, 'message' => 'Aceite eletrônico assinado com sucesso!', 'pdf' => ''], 200);
    }

    public function teste()
    {
        $model = AceiteEletronico::find(5);
        $dados = [
            'nome'      => $model->nome,
            'email'     => $model->email,
            'link'      => $model->url,
            'titulo'    => $model->titulo,
        ];
        return view('aceite.mail', compact('dados'));
    }

    private static function enviarAceiteEletronico($dados)
    {
        Mail::to('aceiteeletronico@positivaconsultas.com.br')->send(new AceiteMail($dados));
    }

    private static function generateRandomString($size = 7, $randomString=''){

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";

        for($i = 0; $i < $size; $i = $i+1){
           $randomString .= $chars[mt_rand(0,60)];
        }
        return str_shuffle($randomString);
     }
}
