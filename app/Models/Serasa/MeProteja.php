<?php
namespace App\Models\Serasa;

use App\Models\Meproteja as ModelsMeproteja;
use PhpParser\Node\Stmt\TryCatch;

class MeProteja
{

    private static $PRODUCAO = true;

    public static function isProducao()
    {
        return self::$PRODUCAO;
    }

    public static function getUrl()
    {
        if(self::$PRODUCAO) {
            return 'https://services.serasaexperian.com.br/MeAviseProxy?wsdl';
        }
        return 'https://serviceshomologa.serasaexperian.com.br/MeAviseProxy?wsdl';
    }

    public static function getAssinaturaDistribuidor()
    {
        if(self::$PRODUCAO) {
            $aLogons = [
                'logon'     => '23815018',
                'password'  => 'MUDA@123',
            ];
        }else
        {
            $aLogons = [
                'logon'     => '23815018',
                'password'  => 'MUDA@123',
            ];
        }

        return $aLogons;
    }

    public static function incluir_empresa($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        $aDados = [
            'cnpj'                  => $CNPJ,
            'planoMonitoramento'    => $dados['plano_monitoramento'],
            'modalidadeCobranca'    => $dados['modalidade_cobranca']
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['IncluirMonitorada'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'IncluirMonitorada', $aaaa, $aLogon);

        return $result;
    }

    public static function excluir_empresa($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        $aDados = [
            'cnpj'                  => $CNPJ,
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['ExcluirClienteDistribuidor'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'ExcluirClienteDistribuidor', $aaaa, $aLogon);

        return $result;
    }

    public static function consultar_empresa($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        $aDados = [
            'cnpj'                  => $CNPJ,
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['ConsultarMonitorada'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'ConsultarMonitorada', $aaaa, $aLogon);

        return $result;
    }

    public static function incluir_socio($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        if($dados['tipo_pessoa'] == 'F'){
            $TIPO = "CPF";
        }else
        if($dados['tipo_pessoa'] == 'J'){
            $TIPO = "CNPJ";
        }

        $DOC  = Serasa::getReplace($dados['documento_socio'], 9);

        $aDados = [
            'cnpjMonitorada'    => $CNPJ,
            'documentoSocio'    => [
                'tipo'    => $TIPO,
                'numero'  => $DOC
            ],
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['IncluirSocio'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'IncluirSocio', $aaaa, $aLogon);

        return $result;
    }

    public static function excluir_socio($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        if($dados['tipo_pessoa'] == 'F'){
            $TIPO = "CPF";
        }else
        if($dados['tipo_pessoa'] == 'J'){
            $TIPO = "CNPJ";
        }

        $DOC  = Serasa::getReplace($dados['documento_socio'], 9);

        $aDados = [
            'cnpjMonitorada'    => $CNPJ,
            'documentoSocio'    => [
                'tipo'    => $TIPO,
                'numero'  => $DOC
            ],
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['ExcluirSocio'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'ExcluirSocio', $aaaa, $aLogon);

        return $result;
    }

    public static function consultar_socio($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        if($dados['tipo_pessoa'] == 'F'){
            $TIPO = "CPF";
        }else
        if($dados['tipo_pessoa'] == 'J'){
            $TIPO = "CNPJ";
        }

        $DOC  = Serasa::getReplace($dados['documento_socio'], 9);

        $aDados = [
            'cnpjMonitorada'    => $CNPJ,
            'documentoSocio'    => [
                'tipo'    => $TIPO,
                'numero'  => $DOC
            ],
        ];

        $aLogon = self::getAssinaturaDistribuidor();

        $aaaa['ConsultarSocio'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'ConsultarSocio', $aaaa, $aLogon);

        return $result;
    }

    public static function incluir_dados($dados)
    {
        try {
            $model = new ModelsMeproteja();

            $model->cliente         = $dados['cliente'];
            $model->distribuidor    = $dados['cliente'];;
            $model->json            = $dados['cliente'];;
            $model->status          = 0;
            $model->data_inclusao   = date("Y-m-d H:m:s");

            if($model->save()){
                return ['success' => 'Dados salvo com sucesso!'];
            }else{
                return ['error' => 'Ocorreu algum erro ao gravar os dados!'];
            }

        } catch (\Throwable $th) {
            return [
                'error'     => 'Ocorreu algum erro ao gravar os dados!',
                'mensagem'  => $th->getMessage(),
                'code'      => $th->getCode()
            ];
        }
    }

}
