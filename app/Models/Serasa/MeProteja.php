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

    public static function incluir_empresa($dados)
    {
        $CNPJ = Serasa::getReplace($dados['cnpj'], 8);

        $aDados = [
            'cnpj'                  => $CNPJ,
            'planoMonitoramento'    => $dados['plano_monitoramento'],
            'modalidadeCobranca'    => $dados['modalidade_cobranca']
        ];

        $aLogon = [
            'logon'     => '23815018',
            'password'  => 'MUDA@123',
        ];

        $aaaa['IncluirMonitorada'] = $aDados;
        $result = Serasa::sendDadosSOAP('meproteja', 'IncluirMonitorada', $aaaa, $aLogon);

        return $result;
    }
}
