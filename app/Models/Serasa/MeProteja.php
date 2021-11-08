<?php
namespace App\Models\Serasa;

class MeProteja
{

    private static $PRODUCAO = false;

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

}
