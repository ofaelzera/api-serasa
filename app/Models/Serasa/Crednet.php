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
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@10", 8);
        }else
        {
            $aRtn = Serasa::getTextoComBrancoDireita('21742667', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@10", 8);
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
            [ 'campo'=>'FILLER_0',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'B49C', ],      //01 -
            [ 'campo'=>'FILLER_1',          'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' ',  ],        //02 -
            [ 'campo'=>'NUMDOC',            'tipo'=>'N', 'tam'=>15,     'obrig'=>true, 'value'=>' ',  ],        //03 - NUMERO DO CPF OU CNPJ A SER CONSULTADO
            [ 'campo'=>'TIPOPESSOA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //04 - TIPÓ DE PESSOA J OU F
            [ 'campo'=>'BASECONS',          'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>'C' ],          //05 -
            [ 'campo'=>'MODALIDADE',        'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'FI' ],         //06 -
            [ 'campo'=>'VLRCONSUL',         'tipo'=>'X', 'tam'=>7,      'obrig'=>true, 'value'=>' ' ],          //07 -
            [ 'campo'=>'CENTROCUST',        'tipo'=>'X', 'tam'=>12,     'obrig'=>true,'value'=>' ' ],           //08 -
            [ 'campo'=>'CODIFICADO',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],          //09 -
            [ 'campo'=>'QTDREG',            'tipo'=>'N', 'tam'=>2,      'obrig'=>true, 'value'=>'99' ],         //10 -
            [ 'campo'=>'CONVERSA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],          //11 -
            [ 'campo'=>'FUNCAO',            'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>'INI' ],        //12 -
            [ 'campo'=>'TPCONSULTA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'A' ],          //13 -
            [ 'campo'=>'ATUALIZA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],          //14 -
            [ 'campo'=>'IDENT_TERM',        'tipo'=>'X', 'tam'=>18,     'obrig'=>true, 'value'=>' ' ],          //15 - USO DO SERASA
            [ 'campo'=>'RESCLI',            'tipo'=>'X', 'tam'=>10,     'obrig'=>true, 'value'=>' ' ],          //16 - USO DO SERASA
            [ 'campo'=>'DELTS',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //17 - USO DO SERASA
            [ 'campo'=>'COBRA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //18 - USO DO SERASA
            [ 'campo'=>'PASSA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'D' ],          //19 -
            [ 'campo'=>'CONS_COLLEC',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],          //20 -
            [ 'campo'=>'LOCALIZADOR',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //21 - USO DO SERASA
            [ 'campo'=>'DOC_CREDOR',        'tipo'=>'N', 'tam'=>9,      'obrig'=>true, 'value'=>' ' ],          //22 - USO DO SERASA
            [ 'campo'=>'QTDE_CHEQU',        'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' ' ],          //23 - USO DO SERASA
            [ 'campo'=>'END_TEL',           'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],          //24 -
            [ 'campo'=>'QTDE_CHO_1',        'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' ' ],          //25 - USO DO SERASA
            [ 'campo'=>'SCO_CHO_1',         'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //26 - USO DO SERASA
            [ 'campo'=>'TAR_CHO_1',         'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //27 - USO DO SERASA
            [ 'campo'=>'NAO_COBR_BUREAU',   'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //28 - USO DO SERASA
            [ 'campo'=>'AUTO_POSIT',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //29 - USO DO SERASA
            [ 'campo'=>'BUREAU_V_S_TRANSL', 'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //30 - USO DO SERASA

            [ 'campo'=>'QUER_TEL_9_DIG_X',  'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //31 -
            [ 'campo'=>'CTA_CORRENT',       'tipo'=>'X', 'tam'=>10,     'obrig'=>true, 'value'=>' ' ],          //32 - USO DO SERASA
            [ 'campo'=>'DG_CTA_CORR',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //33 - USO DO SERASA
            [ 'campo'=>'AGENCIA',           'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //34 - USO DO SERASA
            [ 'campo'=>'ALERTA',            'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //35 - USO DO SERASA
            [ 'campo'=>'LOGON',             'tipo'=>'X', 'tam'=>8,      'obrig'=>true, 'value'=>' ' ],          //36 - LOGON DE ACESSO
            [ 'campo'=>'VIA_INTERNET',      'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //37 - USO DO SERASA
            [ 'campo'=>'RESPOSTA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //38 - USO DO SERASA
            [ 'campo'=>'PERIODO_COMPRO',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //39 - USO DO SERASA
            [ 'campo'=>'PERIODO_ENDERECO',  'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //40 - USO DO SERASA
            [ 'campo'=>'BACKTEST',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //41 - USO DO SERASA
            [ 'campo'=>'DT_QUALITY',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //42 -
            [ 'campo'=>'PRDORIGEM',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' ' ],          //43 -
            [ 'campo'=>'TRNORIGEM',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //44 -
            [ 'campo'=>'CONSULTANTE',       'tipo'=>'X', 'tam'=>15,     'obrig'=>true, 'value'=>' ' ],          //45 - CNPJ CONSULTANTE
            [ 'campo'=>'TP_OR',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //46 -
            [ 'campo'=>'CNPJ_SOFTW',        'tipo'=>'X', 'tam'=>9,      'obrig'=>true, 'value'=>' ' ],          //47 -
            [ 'campo'=>'FILLER_2',          'tipo'=>'X', 'tam'=>15,     'obrig'=>true, 'value'=>' ' ],          //48 -
            [ 'campo'=>'QTD_COMPR',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' ' ],          //49 -
            [ 'campo'=>'NEGATIVOS',         'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //50 -
            [ 'campo'=>'CHEQUE',            'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //51 -
            [ 'campo'=>'DATA_CONSUL',       'tipo'=>'X', 'tam'=>8,      'obrig'=>true, 'value'=>' ' ],          //52 -
            [ 'campo'=>'HORA_CONSUL',       'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' ' ],          //53 -
            [ 'campo'=>'TOTAL_REG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //54 -
            [ 'campo'=>'QTD_REG1',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //55 -
            [ 'campo'=>'COD_TAB',           'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //56 -
            [ 'campo'=>'ITEMTSDADOS',       'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //57 - USO DO SERASA
            [ 'campo'=>'TS_DADOS',          'tipo'=>'X', 'tam'=>16,     'obrig'=>true, 'value'=>' ' ],          //58 - USO DO SERASA
            [ 'campo'=>'TS_SCORE1',         'tipo'=>'X', 'tam'=>16,     'obrig'=>true, 'value'=>' ' ],          //59 - USO DO SERASA
            [ 'campo'=>'TS_BP49',           'tipo'=>'X', 'tam'=>16,     'obrig'=>true, 'value'=>' ' ],          //60 - USO DO SERASA
            [ 'campo'=>'TS_AUTOR',          'tipo'=>'X', 'tam'=>16,     'obrig'=>true, 'value'=>' ' ],          //61 - USO DO SERASA
            [ 'campo'=>'ITEMTS_AUTOR',      'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //62 - USO DO SERASA
            [ 'campo'=>'ITEMTS_SCOR1',      'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //63 - USO DO SERASA
            [ 'campo'=>'ITEMTS_BP49',       'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //64 - USO DO SERASA
            [ 'campo'=>'ITEMTS_DADOS2',     'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],          //65 - USO DO SERASA
            [ 'campo'=>'TS_DADOS2',         'tipo'=>'X', 'tam'=>16,     'obrig'=>true, 'value'=>' ' ],          //66 - USO DO SERASA
            [ 'campo'=>'FASE_0',            'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //67 - USO DO SERASA
            [ 'campo'=>'FASE_1',            'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //68 - USO DO SERASA
            [ 'campo'=>'DBTABELA',          'tipo'=>'X', 'tam'=>30,     'obrig'=>true, 'value'=>' ' ],          //69 - USO DO SERASA
            [ 'campo'=>'COD_AUT',           'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //70 - USO DO SERASA
            [ 'campo'=>'OPERID',            'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>' ' ],          //71 - USO DO SERASA

            [ 'campo'=>'RECI_COMPR',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //72 - USO DO SERASA
            [ 'campo'=>'RECI_PAGTO',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //73 - USO DO SERASA
            [ 'campo'=>'FILLER_3',          'tipo'=>'X', 'tam'=>38,     'obrig'=>true, 'value'=>' ' ],          //74 -
            [ 'campo'=>'ACESS_RECHQ',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //75 -
            [ 'campo'=>'TEM_OCOR_RECHQ',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //76 -
            [ 'campo'=>'RESERVADO',         'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //77 - USO DO SERASA


        ];
    }

    private static function getStDGetProtocoloP002($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TIPO_REG',      'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'P002'],    //01 -
            [ 'campo'=>'COD1',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //02 -
            [ 'campo'=>'CHAVE1',        'tipo'=>'N', 'tam'=>21,     'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'COD2',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],      //04 -
            [ 'campo'=>'CHAVE2',        'tipo'=>'X', 'tam'=>21,     'obrig'=>true, 'value'=>' ' ],      //05 -
            [ 'campo'=>'COD3',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],      //06 -
            [ 'campo'=>'CHAVE3',        'tipo'=>'X', 'tam'=>21,     'obrig'=>true, 'value'=>' ' ],      //07 -
            [ 'campo'=>'COD4',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' ' ],      //08 -
            [ 'campo'=>'CHAVE4',        'tipo'=>'X', 'tam'=>21,     'obrig'=>true, 'value'=>' ' ],      //09 -
            [ 'campo'=>'FILLER',        'tipo'=>'N', 'tam'=>11,     'obrig'=>true, 'value'=>' ' ],      //10 -
        ];
    }

    private static function getStDGetProtocoloN001($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N001'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'00'],      //02 -
            [ 'campo'=>'TP_CONS',       'tipo'=>'N', 'tam'=>2,      'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'TRANS_CONS',    'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'SOL_GDE_VAR',   'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'ID_CHEQUE',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //06 -
            [ 'campo'=>'AGRUPA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'CONS_SINT',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //08 -
            [ 'campo'=>'RESERVADO',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //09 - USO DO SERASA
            [ 'campo'=>'ANOT_RESUM',    'tipo'=>'N', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //10 -
            [ 'campo'=>'CHAVE_CONS',    'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //11 -
            [ 'campo'=>'FANTASIA',      'tipo'=>'X', 'tam'=>12,     'obrig'=>true, 'value'=>' '],       //12 -
            [ 'campo'=>'STATUS_BCO',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //13 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>13,     'obrig'=>true, 'value'=>' '],       //14 - USO DO SERASA
            [ 'campo'=>'TRATA_TEL',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //15 -
            [ 'campo'=>'FILLER_1',      'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //16 - USO DO SERASA
            [ 'campo'=>'SITUACAO',      'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //17 -
            [ 'campo'=>'FILLER_2',      'tipo'=>'X', 'tam'=>62,     'obrig'=>true, 'value'=>' '],       //18 - USO DO SERASA
        ];
    }

    private static function getStDGetProtocoloN002_00($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N002'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'00'],      //02 -
            [ 'campo'=>'BANCO',         'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>' '],       //02 -
            [ 'campo'=>'AGENCIA',       'tipo'=>'N', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'CONTA_COR',     'tipo'=>'X', 'tam'=>15,     'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'CHQ_INI',       'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'DG_CHQ_INI',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'CHQ_FIM',       'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //08 -
            [ 'campo'=>'DG_CHQ_FIM',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //09 -
            [ 'campo'=>'CMC7_INI',      'tipo'=>'X', 'tam'=>30,     'obrig'=>true, 'value'=>' '],       //10 -
            [ 'campo'=>'CMC7_FIM',      'tipo'=>'X', 'tam'=>30,     'obrig'=>true, 'value'=>' '],       //11 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'N', 'tam'=>13,     'obrig'=>true, 'value'=>' '],       //12 - USO DO SERASA
        ];
    }

    private static function getStDGetProtocoloN002_01($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N001'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'01'],      //02 -
            [ 'campo'=>'VALOR_CHQ',     'tipo'=>'N', 'tam'=>15,     'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'DT_VCTO_CHQ',   'tipo'=>'X', 'tam'=>8,      'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>86,     'obrig'=>true, 'value'=>' '],       //05 - USO DO SERASA
        ];
    }

    private static function getStDGetProtocoloN003($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N003'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'00'],      //02 -
            [ 'campo'=>'DDD',           'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //02 -
            [ 'campo'=>'TELEFONE',      'tipo'=>'N', 'tam'=>8,      'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'CEP',           'tipo'=>'X', 'tam'=>9,      'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'UF',            'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'FEAT_SCOR',     'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //06 - USO DO SERASA
        ];
    }

}
