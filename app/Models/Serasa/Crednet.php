<?php

namespace App\Models\Serasa;

class Crednet
{
    private static $PRODUCAO = true;

    public static function isProducao()
    {
        return self::$PRODUCAO;
    }

    public static function getUrl()
    {
        if(self::$PRODUCAO) {
            return 'https://sitenet43.serasa.com.br/Prod/consultahttps';
        }
        return 'https://mqlinuxext.serasa.com.br/Homologa/consultahttps';
    }

    public static function getAssinaturaDistribuidor()
    {
        if(self::$PRODUCAO) {
            $aRtn = Serasa::getTextoComBrancoDireita('21742667', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@01", 8);
        }else
        {
            $aRtn = Serasa::getTextoComBrancoDireita('21742667', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@01", 8);
        }

        return $aRtn;
    }

    public static function getConsultaCredNet($aConsulta)
    {
        $aRtn = 'T999';
        return $aRtn;
    }

    private static function getStDGetProtocoloB49C($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'FILLER_0',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'B49C', ],
            [ 'campo'=>'FILLER_1',          'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' ',  ],
            [ 'campo'=>'NUMDOC',            'tipo'=>'N', 'tam'=>15,     'obrig'=>true, 'value'=>' ',  ],
            [ 'campo'=>'TIPOPESSOA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'BASECONS',          'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>'C' ],
            [ 'campo'=>'MODALIDADE',        'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'FI' ],
            [ 'campo'=>'VLRCONSUL',         'tipo'=>'X', 'tam'=>7,      'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'CENTROCUST',        'tipo'=>'X', 'tam'=>12,     'obrig'=>true,'value'=>' ' ],
            [ 'campo'=>'CODIFICADO',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],
            [ 'campo'=>'QTDREG',            'tipo'=>'N', 'tam'=>2,      'obrig'=>true, 'value'=>'99' ],
            [ 'campo'=>'CONVERSA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],
            [ 'campo'=>'FUNCAO',            'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>'INI' ],

            [ 'campo'=>'TPCONSULTA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'A' ],
            [ 'campo'=>'ATUALIZA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],
            [ 'campo'=>'IDENT_TERM',        'tipo'=>'X', 'tam'=>18,     'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'RESCLI',            'tipo'=>'X', 'tam'=>10,     'obrig'=>true, 'value'=>' ' ], ///----
            [ 'campo'=>'DELTS',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'COBRA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'PASSA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'D' ],
            [ 'campo'=>'CONS_COLLEC',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],
            [ 'campo'=>'LOCALIZADOR',          'tipo'=>'X', 'tam'=>57,     'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'DOC_CREDOR',       'tipo'=>'N', 'tam'=>15,     'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'QTDE_CHEQU',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'END_TEL',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'QTDE_CHO_1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'SCO_CHO_1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TAR_CHO_1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'NAO_COBR_BUREAU',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'AUTO_POSIT',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'BUREAU-VIA-SITE-TRANSACIONAL',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'QUER-TEL-9-DIG-X',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],

            [ 'campo'=>'CTA_CORRENT',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'DG_CTA_CORR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'AGENCIA',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ALERTA',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'LOGON',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'VIA_INTERNET',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'RESPOSTA',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'PERIODO_COMPRO',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'PERIODO_ENDERECO',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'BACKTEST',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'DT_QUALITY',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'PRDORIGEM',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TRNORIGEM',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'CONSULTANTE',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TP_OR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'CNPJ_SOFTW',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'FILLER_2',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'QTD_COMPR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'NEGATIVOS',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'CHEQUE',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'DATA_CONSUL',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'HORA_CONSUL',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TOTAL_REG',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'QTD_REG1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'COD_TAB',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ITEMTSDADOS',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TS_DADOS',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TS_SCORE1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TS_BP49',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TS_AUTOR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ITEMTS_AUTOR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ITEMTS_SCOR1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ITEMTS_BP49',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ITEMTS_DADOS2',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],

            [ 'campo'=>'FASE_0',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'FASE_1',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'DBTABELA',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'COD_AUT',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'OPERID',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'RECI_COMPR',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'RECI_PAGTO',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'FILLER_3',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'ACESS_RECHQ',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'TEM_OCOR_RECHQ',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'RESERVADO',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],


        ];
    }

    private static function getStDGetProtocoloP002($aConsulta)
    {

    }

    private static function getStDGetProtocoloN001($aConsulta)
    {

    }

    private static function getStDGetProtocoloN002($aConsulta)
    {

    }

    private static function getStDGetProtocoloN003($aConsulta)
    {

    }

}
