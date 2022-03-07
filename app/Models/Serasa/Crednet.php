<?php

namespace App\Models\Serasa;

use App\Models\Positiva\ConContrato;
use App\Models\Crednet as CrednetModel;

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
            //return 'https://sitenet43.serasa.com.br/Prod/consultahttps';
            return 'https://sitenet43-2.serasa.com.br/Prod/consultahttps';
        }
        //return 'https://mqlinuxext.serasa.com.br/Homologa/consultahttps';
        return 'https://mqlinuxext-2.serasa.com.br/Homologa/consultahttps';
    }

    public static function getAssinaturaDistribuidor()
    {
        if(self::$PRODUCAO) {
            $aRtn = Serasa::getTextoComBrancoDireita('21742667', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@10", 8);
            $aRtn .= Serasa::getTextoComBrancoDireita('', 8);
        }else
        {
            $aRtn = Serasa::getTextoComBrancoDireita('21742667', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@10", 8);
            $aRtn .= Serasa::getTextoComBrancoDireita('', 8);
        }

        return $aRtn;
    }

    public static function getConsultaCredNet_($aConsulta)
    {
        //BLOCO N01
        $aRtn = self::getStDGetProtocoloB49C($aConsulta);
        //END BLOCO N01

        //BLOCO N02
        if(count($aConsulta['P002']) > 4){
            $iFeatureAtual = 0;
            $i=0;
            $soma_por = 4;
            $aNewFeature   = [];

            foreach($aConsulta['P002'] as $feat){

                if($iFeatureAtual < $soma_por){
                    $aNewFeature[$i][$iFeatureAtual] = $feat;
                }else{
                    $soma_por += 4;
                    $i++;
                    $aNewFeature[$i][$iFeatureAtual] = $feat;
                }
                $iFeatureAtual++;
            }

            foreach($aNewFeature as $feat){
                $aRtn .= self::getStDGetProtocoloP002($feat);
            }
        }else{
            $aRtn .= self::getStDGetProtocoloP002($aConsulta['P002']);
        }
        //END BLOCO N02

        //BLOCO N001
        $aRtn .= self::getStDGetProtocoloN001($aConsulta);
        //END BLOCO N001

        //BLOCO N003
        $aRtn .= self::getStDGetProtocoloN003($aConsulta);
        //END BLOCO N003

        $aRtn .= 'T999';

        $modelCrednet = new CrednetModel();
        $modelCrednet->id_contrato      = $aConsulta["id_contrato"];
        $modelCrednet->data_consulta    = date("Y-m-d H:i:s");
        $modelCrednet->cnpj_consulta    = $aConsulta["cnpj_consulta"];
        $modelCrednet->logon            = $aConsulta["logon"];
        $modelCrednet->tipo_pessoa      = $aConsulta["tipo_pessoa"];
        $modelCrednet->p002             = json_encode($aConsulta["P002"]);
        $modelCrednet->n003             = json_encode($aConsulta["N003"]);
        $modelCrednet->string_envio     = $aRtn;

        if($modelCrednet->save()){
            $aRtn = Serasa::sendDados([
                'produto' => 'crednet',
                'post'    => $aRtn,
            ]);

            $aRtn = self::getArrayRetorno($aRtn);
            $modelCrednet->string_retorno = $aRtn;
            $modelCrednet->save();
        }

        $aRtn = self::getTrataRetornoArray($aRtn);
        return $aRtn;

    }

    public static function getConsultaCredNet($aConsulta){

        $modelCrednet = CrednetModel::find(17);
        $aRtn = json_decode($modelCrednet->string_retorno, true);
        $aRtn = self::getTrataRetornoArray($aRtn);

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
            [ 'campo'=>'VLRCONSUL',         'tipo'=>'N', 'tam'=>7,      'obrig'=>true, 'value'=>' ' ],          //07 -
            [ 'campo'=>'CENTROCUST',        'tipo'=>'N', 'tam'=>12,     'obrig'=>true,'value'=>' ' ],           //08 -
            [ 'campo'=>'CODIFICADO',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],          //09 -
            [ 'campo'=>'QTDREG',            'tipo'=>'N', 'tam'=>2,      'obrig'=>true, 'value'=>'99' ],         //10 -
            [ 'campo'=>'CONVERSA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],          //11 -
            [ 'campo'=>'FUNCAO',            'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>'INI' ],        //12 -
            [ 'campo'=>'TPCONSULTA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'A' ],          //13 -
            [ 'campo'=>'ATUALIZA',          'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'N' ],          //14 -
            [ 'campo'=>'IDENT_TERM',        'tipo'=>'X', 'tam'=>18,     'obrig'=>true, 'value'=>' ' ],          //15 - USO DO SERASA
            [ 'campo'=>'RESCLI',            'tipo'=>'X', 'tam'=>10,     'obrig'=>true, 'value'=>' ' ],          //16 - USO DO SERASA
            [ 'campo'=>'DELTS',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //17 - USO DO SERASA
            [ 'campo'=>'COBRA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //18 - USO DO SERASA
            [ 'campo'=>'PASSA',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'D' ],          //19 -
            [ 'campo'=>'CONS_COLLEC',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //20 -
            [ 'campo'=>'LOCALIZADOR',       'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' ' ],          //21 - USO DO SERASA
            [ 'campo'=>'DOC_CREDOR',        'tipo'=>'X', 'tam'=>9,      'obrig'=>true, 'value'=>' ' ],          //22 - USO DO SERASA
            [ 'campo'=>'QTDE_CHEQU',        'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' ' ],          //23 - USO DO SERASA
            [ 'campo'=>'END_TEL',           'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],          //24 -
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
            [ 'campo'=>'ALERTA',            'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'S' ],          //35 - USO DO SERASA
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
            [ 'campo'=>'TP_OR',             'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'1' ],          //46 -
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

        //SETA O NUMERO DE DOCUMENTO A SER CONSULTADO
            $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'NUMDOC');
            $aOpcoes[$nIdx]['value'] = Serasa::getSoNumeroZeroEsquerda($aConsulta['cnpj_consulta'], $aOpcoes[$nIdx]['tam']);
        //END

        //INFORMA O TIPO DE PESSOA A SER CONSULTADA
            if($aConsulta['tipo_pessoa'] == 'F'){
                $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'TIPOPESSOA');
                $aOpcoes[$nIdx]['value'] = 'F';
            }else if($aConsulta['tipo_pessoa'] == 'J'){
                $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'TIPOPESSOA');
                $aOpcoes[$nIdx]['value'] = 'J';
            }
        //END

        //INFORMA O CNPJ DA SOFTHOUSE
            $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'CNPJ_SOFTW');
            $aOpcoes[$nIdx]['value'] = '085006435';
        //END

        //SETA O NUMERO DO LOGON
            $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'LOGON');
            $aOpcoes[$nIdx]['value'] = $aConsulta['logon'];
        //END

        //SETA O NUMERO DO CNPJ DO CONSULTANTE
            $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'CONSULTANTE');
            $CNPJ = ConContrato::find($aConsulta['id_contrato'])->getClient->aCNPJ;
            $aOpcoes[$nIdx]['value'] = Serasa::getSoNumeroZeroEsquerda($CNPJ, $aOpcoes[$nIdx]['tam']) ;
        //END

        return Serasa::montaRegistro($aOpcoes, false, true);

    }

    private static function getStDGetProtocoloP002($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TIPO_REG',      'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>'P002'],    //01 -
            [ 'campo'=>'COD1',          'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' '],       //02 -
            [ 'campo'=>'CHAVE1',        'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' '],       //03 -
            [ 'campo'=>'COD2',          'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' ' ],      //04 -
            [ 'campo'=>'CHAVE2',        'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' ' ],      //05 -
            [ 'campo'=>'COD3',          'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' ' ],      //06 -
            [ 'campo'=>'CHAVE3',        'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' ' ],      //07 -
            [ 'campo'=>'COD4',          'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' ' ],      //08 -
            [ 'campo'=>'CHAVE4',        'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' ' ],      //09 -
            [ 'campo'=>'FILLER',        'tipo'=>'X', 'tam'=>11,     'obrig'=>false, 'value'=>' ' ],      //10 -
        ];

        if($aConsulta == null){
            return '';
        }

        $i=1;

        foreach($aConsulta as $feature){
            if($i <= 4){
                if($feature == 'REHMHSPN'){
                    $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'COD'.$i);
                    $aOpcoes[$nIdx]['value'] = 'REHM';
                    $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'CHAVE'.$i);
                    $aOpcoes[$nIdx]['value'] = 'HSPN';
                }else
                if($feature == 'NRF3C66M'){
                    $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'COD'.$i);
                    $aOpcoes[$nIdx]['value'] = 'NRF3';
                    $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'CHAVE'.$i);
                    $aOpcoes[$nIdx]['value'] = 'C66M';
                }
                else
                {
                    $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'COD'.$i);
                    $aOpcoes[$nIdx]['value'] = $feature;
                }
            }else{
                break;
            }
            $i++;
        }

        return Serasa::montaRegistro($aOpcoes, false, true);

    }

    private static function getStDGetProtocoloN001($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N001'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'00'],      //02 -
            [ 'campo'=>'TP_CONS',       'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'PP'],      //03 -
            [ 'campo'=>'TRANS_CONS',    'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'X21P'],    //04 -
            [ 'campo'=>'SOL_GDE_VAR',   'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'ID_CHEQUE',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>'0'],       //06 -
            [ 'campo'=>'AGRUPA',        'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'CONS_SINT',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //08 -
            [ 'campo'=>'RESERVADO',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //09 - USO DO SERASA
            [ 'campo'=>'ANOT_RESUM',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //10 -
            [ 'campo'=>'CHAVE_CONS',    'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //11 -
            [ 'campo'=>'FANTASIA',      'tipo'=>'X', 'tam'=>12,     'obrig'=>true, 'value'=>' '],       //12 -
            [ 'campo'=>'STATUS_BCO',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //13 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>13,     'obrig'=>true, 'value'=>' '],       //14 - USO DO SERASA
            [ 'campo'=>'TRATA_TEL',     'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //15 -
            [ 'campo'=>'FILLER_1',      'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //16 - USO DO SERASA
            [ 'campo'=>'SITUACAO',      'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //17 -
            [ 'campo'=>'FILLER_2',      'tipo'=>'X', 'tam'=>62,     'obrig'=>true, 'value'=>' '],       //18 - USO DO SERASA
        ];

        return Serasa::montaRegistro($aOpcoes, false, true);
    }

    private static function getStDGetProtocoloN002_00($aConsulta)
    {
        $aOpcoes = [
            [ 'campo'=>'TPREG',         'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'N002'],    //01 -
            [ 'campo'=>'SUBTP',         'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>'00'],      //02 -
            [ 'campo'=>'BANCO',         'tipo'=>'X', 'tam'=>3,      'obrig'=>true, 'value'=>' '],       //02 -
            [ 'campo'=>'AGENCIA',       'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'CONTA_COR',     'tipo'=>'X', 'tam'=>15,     'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'CHQ_INI',       'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'DG_CHQ_INI',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'CHQ_FIM',       'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //08 -
            [ 'campo'=>'DG_CHQ_FIM',    'tipo'=>'X', 'tam'=>1,      'obrig'=>true, 'value'=>' '],       //09 -
            [ 'campo'=>'CMC7_INI',      'tipo'=>'X', 'tam'=>30,     'obrig'=>true, 'value'=>' '],       //10 -
            [ 'campo'=>'CMC7_FIM',      'tipo'=>'X', 'tam'=>30,     'obrig'=>true, 'value'=>' '],       //11 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>13,     'obrig'=>true, 'value'=>' '],       //12 - USO DO SERASA
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
            [ 'campo'=>'TELEFONE',      'tipo'=>'X', 'tam'=>8,      'obrig'=>true, 'value'=>' '],       //03 -
            [ 'campo'=>'CEP',           'tipo'=>'X', 'tam'=>9,      'obrig'=>true, 'value'=>' '],       //04 -
            [ 'campo'=>'UF',            'tipo'=>'X', 'tam'=>2,      'obrig'=>true, 'value'=>' '],       //05 -
            [ 'campo'=>'FEAT_SCOR',     'tipo'=>'X', 'tam'=>80,     'obrig'=>true, 'value'=>' '],       //07 -
            [ 'campo'=>'FILLER_0',      'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' '],       //06 - USO DO SERASA
        ];

        $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'UF');
        $aOpcoes[$nIdx]['value'] = $aConsulta["estado"];

        $rtn = '';
        foreach ($aConsulta['N003'] as $feat) {
            $rtn .= $feat;
        }

        $nIdx = Serasa::getIdxDadosEmParam($aOpcoes, 'FEAT_SCOR');
        $aOpcoes[$nIdx]['value'] = $rtn;

        return Serasa::montaRegistro($aOpcoes, false, true);
    }

    public static function getArrayRetorno($aRtn)
    {
        $aNewRtn = [];
        $index   = strlen($aRtn)-1;
        $i=0;

        for ($indexOf=0; $indexOf < $index;) {
            if($i == 0){
                $aNewRtn[$i] = substr($aRtn, 0, 400);
                $aRtn = substr($aRtn, 400);
                $i++;
                $indexOf += 400;
            }else{
                $aNewRtn[$i] = substr($aRtn, 0, 115);
                $aRtn = substr($aRtn, 115);
                $i++;
                $indexOf += 115;
            }

            if($indexOf == $index){
                $index_ = count($aNewRtn)-1;
                $T99 = $aNewRtn[$index_];
                $chave = count($aNewRtn) - 100;

                if(rtrim(ltrim($T99)) == "T999000STRING PARCIAL - HA MAIS REGISTROS A ENVIAR                                                                "){
                    $aRtn = Serasa::sendDados([
                        'produto'    => 'crednet',
                        'post'       => $aNewRtn[$chave],
                    ]);
                    $index += strlen($aRtn)-1;

                    $aNewRtn[$i] = substr($aRtn, 0, 400);
                    $aRtn = substr($aRtn, 400);
                    $i++;
                    $indexOf += 400;
                }

            }
        }

        return $aNewRtn;

    }

    public static function getTrataRetornoArray($aArray)
    {
        $aNewArray  = [];
        $aArrayKey  = [];
        $i=1;

        foreach($aArray as $Array){
            $kay = substr($Array, 0, 4);

            if(array_search($kay, $aArrayKey) > 0){
                $aNewArray[$kay][$i] = $Array;
                $i++;
            }else{
                $aNewArray[$kay][0] = $Array;
                array_push($aArrayKey, $kay);
                $i=1;
            }
        }

        foreach($aNewArray as $kay => $Array){

            if($kay != "B49C"
                && $kay != "P002"
                && $kay != "N001"
                && $kay != "N003"
                && $kay != "T999"
                && $kay != ""){
                $aArr = call_user_func('self::getRetorno_'.$kay, $aNewArray[$kay]);
                $aNewArray[$kay] = $aArr;
            }

        }

        return $aNewArray;

    }

    //TRATA RETORNO
    private static function getRetorno_B370($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 1), " ");

            if($subtipo == "0"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 1), " ");

                $aArrayRetorno[$i]['DDD']       = rtrim(substr($Arr, 6, 3), " ");
                $aArrayRetorno[$i]['FONE']      = rtrim(substr($Arr, 9, 9), " ");
                $aArrayRetorno[$i]['ENDERECO']  = rtrim(substr($Arr, 18, 70), " ");
                $aArrayRetorno[$i]['BAIRRO ']   = rtrim(substr($Arr, 88, 20), " ");
                $aArrayRetorno[$i]['CEP']       = rtrim(substr($Arr, 108, 8), " ");
            }else
            if($subtipo == "1"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 1), " ");

                $aArrayRetorno[$i]['CIDADE']    = rtrim(substr($Arr, 6, 30), " ");
                $aArrayRetorno[$i]['UF']        = rtrim(substr($Arr, 36, 2), " ");
                $aArrayRetorno[$i]['NOME']      = rtrim(substr($Arr, 38, 50), " ");
                $aArrayRetorno[$i]['DATA ']     = rtrim(substr($Arr, 88, 8), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 96, 20), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_C210($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 1), " ");

            if($subtipo == "1"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 1), " ");

                $aArrayRetorno[$i]['SEQ_END']   = rtrim(substr($Arr, 6, 2), " ");
                $aArrayRetorno[$i]['LOGRAD']    = rtrim(substr($Arr, 8, 60), " ");
                $aArrayRetorno[$i]['NUM_END']   = rtrim(substr($Arr, 68, 6), " ");
                $aArrayRetorno[$i]['COMP_END']  = rtrim(substr($Arr, 74, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 114, 2), " ");
            }else
            if($subtipo == "2"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 1), " ");

                $aArrayRetorno[$i]['SEQ_END'] = rtrim(substr($Arr, 6, 2), " ");
                $aArrayRetorno[$i]['BAIRRO']  = rtrim(substr($Arr, 8, 30), " ");
                $aArrayRetorno[$i]['FILLER']  = rtrim(substr($Arr, 38, 78), " ");
            }else
            if($subtipo == "3"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 1), " ");

                $aArrayRetorno[$i]['SEQ_END']   = rtrim(substr($Arr, 6, 2), " ");
                $aArrayRetorno[$i]['MUNICIP']   = rtrim(substr($Arr, 8, 30), " ");
                $aArrayRetorno[$i]['CEP']       = rtrim(substr($Arr, 38, 8), " ");
                $aArrayRetorno[$i]['UF']        = rtrim(substr($Arr, 46, 2), " ");
                $aArrayRetorno[$i]['DDD']       = rtrim(substr($Arr, 48, 4), " ");
                $aArrayRetorno[$i]['TELEFONE']  = rtrim(substr($Arr, 52, 9), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 61, 55), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N200($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['NOME_RAZAO']    = rtrim(substr($Arr, 7, 70), " ");
                $aArrayRetorno[$i]['DT_NASC_FUND']  = rtrim(substr($Arr, 77, 8), " ");
                $aArrayRetorno[$i]['SIT_DOCTO']     = rtrim(substr($Arr, 85, 2), " ");
                $aArrayRetorno[$i]['DT_SIT_DOCTO'] = rtrim(substr($Arr, 87, 8), " ");
                $aArrayRetorno[$i]['CCF_IND']       = rtrim(substr($Arr, 95, 1), " ");
                $aArrayRetorno[$i]['FILLER']        = rtrim(substr($Arr, 96, 20), " ");
            }else
            if($subtipo == "01"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['NOME_MAE']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N210($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['NUM_MSG']   = rtrim(substr($Arr, 7, 2), " ");
                $aArrayRetorno[$i]['TOT_MSG']   = rtrim(substr($Arr, 9, 2), " ");
                $aArrayRetorno[$i]['TIP_DOC']   = rtrim(substr($Arr, 11, 6), " ");
                $aArrayRetorno[$i]['NUM_DOC']   = rtrim(substr($Arr, 17, 20), " ");
                $aArrayRetorno[$i]['MOTIVO']    = rtrim(substr($Arr, 37, 4), " ");
                $aArrayRetorno[$i]['DTA_OCOR']  = rtrim(substr($Arr, 41, 10), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 51, 59), " ");
            }else
            if($subtipo == "01"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['DDD_1']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FONE_1'] = rtrim(substr($Arr, 47, 69), " ");
                $aArrayRetorno[$i]['DDD_2']  = rtrim(substr($Arr, 47, 69), " ");
                $aArrayRetorno[$i]['FONE_2'] = rtrim(substr($Arr, 47, 69), " ");
                $aArrayRetorno[$i]['DDD_3']  = rtrim(substr($Arr, 47, 69), " ");
                $aArrayRetorno[$i]['FONE_3'] = rtrim(substr($Arr, 47, 69), " ");
                $aArrayRetorno[$i]['FILLER'] = rtrim(substr($Arr, 47, 69), " ");
            }else
            if($subtipo == "99"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['MSG_R210']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N230($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['DT_OCOR']       = rtrim(substr($Arr, 7, 8), " ");
                $aArrayRetorno[$i]['MODALIDADE']    = rtrim(substr($Arr, 15, 30), " ");
                $aArrayRetorno[$i]['AVALISTA']      = rtrim(substr($Arr, 45, 1), " ");
                $aArrayRetorno[$i]['TP_MOEDA']      = rtrim(substr($Arr, 46, 3), " ");
                $aArrayRetorno[$i]['VALOR']         = rtrim(substr($Arr, 49, 15), " ");
                $aArrayRetorno[$i]['CONTRATO']      = rtrim(substr($Arr, 64, 16), " ");
                $aArrayRetorno[$i]['ORIGEM']        = rtrim(substr($Arr, 80, 30), " ");
                $aArrayRetorno[$i]['SG_EMBRATEL']   = rtrim(substr($Arr, 110, 4), " ");
                $aArrayRetorno[$i]['FILLER']        = rtrim(substr($Arr, 114, 2), " ");
            }else
            if($subtipo == "90"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['TOT_OCOR']          = rtrim(substr($Arr, 7, 5), " ");
                $aArrayRetorno[$i]['DT_OCOR_ANTIGA']    = rtrim(substr($Arr, 12, 6), " ");
                $aArrayRetorno[$i]['DT_OCOR_RECENTE']   = rtrim(substr($Arr, 18, 6), " ");
                $aArrayRetorno[$i]['VAL_TOTAL']         = rtrim(substr($Arr, 24, 15), " ");
                $aArrayRetorno[$i]['FILLER']            = rtrim(substr($Arr, 39, 77), " ");
            }else
            if($subtipo == "99"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['MSG_R230']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N240($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['DT_OCOR']       = rtrim(substr($Arr, 7, 8), " ");
                $aArrayRetorno[$i]['MODALIDADE']    = rtrim(substr($Arr, 15, 30), " ");
                $aArrayRetorno[$i]['AVALISTA']      = rtrim(substr($Arr, 45, 1), " ");
                $aArrayRetorno[$i]['TP_MOEDA']      = rtrim(substr($Arr, 46, 3), " ");
                $aArrayRetorno[$i]['VALOR']         = rtrim(substr($Arr, 49, 15), " ");
                $aArrayRetorno[$i]['CONTRATO']      = rtrim(substr($Arr, 64, 16), " ");
                $aArrayRetorno[$i]['ORIGEM']        = rtrim(substr($Arr, 80, 30), " ");
                $aArrayRetorno[$i]['SG_EMBRATEL']   = rtrim(substr($Arr, 110, 4), " ");
                $aArrayRetorno[$i]['FILLER']        = rtrim(substr($Arr, 114, 2), " ");
            }
            else
            if($subtipo == "01"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['SUBJUDICE']     = rtrim(substr($Arr, 7, 1), " ");
                $aArrayRetorno[$i]['MSG_SUBJ']      = rtrim(substr($Arr, 8, 76), " ");
                $aArrayRetorno[$i]['TP_ANOTACAO']   = rtrim(substr($Arr, 84, 1), " ");
                $aArrayRetorno[$i]['FILLER_0']      = rtrim(substr($Arr, 85, 10), " ");
                $aArrayRetorno[$i]['FILLER_1']      = rtrim(substr($Arr, 95, 21), " ");
            }else
            if($subtipo == "90"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['TOT_OCOR']          = rtrim(substr($Arr, 7, 5), " ");
                $aArrayRetorno[$i]['DT_OCOR_ANTIGA']    = rtrim(substr($Arr, 12, 6), " ");
                $aArrayRetorno[$i]['DT_OCOR_RECENTE']   = rtrim(substr($Arr, 18, 6), " ");
                $aArrayRetorno[$i]['VAL_TOTAL']         = rtrim(substr($Arr, 24, 15), " ");
                $aArrayRetorno[$i]['TP_ANOTACAO']       = rtrim(substr($Arr, 39, 1), " ");
                $aArrayRetorno[$i]['FILLER']            = rtrim(substr($Arr, 40, 76), " ");
            }else
            if($subtipo == "99"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['MSG_R240']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N250($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['DT_OCOR']   = rtrim(substr($Arr, 7, 8), " ");
                $aArrayRetorno[$i]['TP_MOEDA']  = rtrim(substr($Arr, 15, 3), " ");
                $aArrayRetorno[$i]['VALOR']     = rtrim(substr($Arr, 18, 15), " ");
                $aArrayRetorno[$i]['CARTORIO']  = rtrim(substr($Arr, 33, 2), " ");
                $aArrayRetorno[$i]['CIDADE']    = rtrim(substr($Arr, 35, 30), " ");
                $aArrayRetorno[$i]['UF']        = rtrim(substr($Arr, 65, 2), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 67, 49), " ");
            }
            else
            if($subtipo == "01"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['SUBJUDICE']     = rtrim(substr($Arr, 7, 1), " ");
                $aArrayRetorno[$i]['MSG_SUBJ']      = rtrim(substr($Arr, 8, 76), " ");
                $aArrayRetorno[$i]['TP_ANOTACAO']   = rtrim(substr($Arr, 84, 1), " ");
                $aArrayRetorno[$i]['FILLER_0']      = rtrim(substr($Arr, 85, 10), " ");
                $aArrayRetorno[$i]['FILLER_1']      = rtrim(substr($Arr, 95, 21), " ");
            }else
            if($subtipo == "90"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['TOT_OCOR']          = rtrim(substr($Arr, 7, 5), " ");
                $aArrayRetorno[$i]['DT_OCOR_ANTIGA']    = rtrim(substr($Arr, 12, 6), " ");
                $aArrayRetorno[$i]['DT_OCOR_RECENTE']   = rtrim(substr($Arr, 18, 6), " ");
                $aArrayRetorno[$i]['MOEDA']             = rtrim(substr($Arr, 24, 3), " ");
                $aArrayRetorno[$i]['VAL_TOTAL']         = rtrim(substr($Arr, 27, 15), " ");
                $aArrayRetorno[$i]['FILLER']            = rtrim(substr($Arr, 42, 74), " ");
            }else
            if($subtipo == "99"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['MSG_R250']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N270($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['DATA_OCOR'] = rtrim(substr($Arr, 7, 8), " ");
                $aArrayRetorno[$i]['CHEQUE']    = rtrim(substr($Arr, 15, 10), " ");
                $aArrayRetorno[$i]['ALINEA']    = rtrim(substr($Arr, 25, 5), " ");
                $aArrayRetorno[$i]['QTIDADE']   = rtrim(substr($Arr, 30, 5), " ");
                $aArrayRetorno[$i]['VALOR']     = rtrim(substr($Arr, 35, 15), " ");
                $aArrayRetorno[$i]['NU_BCO']    = rtrim(substr($Arr, 50, 3), " ");
                $aArrayRetorno[$i]['NO_BCO']    = rtrim(substr($Arr, 53, 14), " ");
                $aArrayRetorno[$i]['AGENCIA']   = rtrim(substr($Arr, 67, 4), " ");
                $aArrayRetorno[$i]['CIDADE']    = rtrim(substr($Arr, 71, 30), " ");
                $aArrayRetorno[$i]['UF']        = rtrim(substr($Arr, 101, 2), " ");
                $aArrayRetorno[$i]['FILLER_0']  = rtrim(substr($Arr, 103, 10), " ");
                $aArrayRetorno[$i]['FILLER_1']  = rtrim(substr($Arr, 113, 3), " ");
            }else
            if($subtipo == "90"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['TOT_OCOR']          = rtrim(substr($Arr, 7, 5), " ");
                $aArrayRetorno[$i]['DT_OCOR_ANTIGA']    = rtrim(substr($Arr, 12, 8), " ");
                $aArrayRetorno[$i]['DT_OCOR_RECENTE']   = rtrim(substr($Arr, 20, 8), " ");
                $aArrayRetorno[$i]['BCO']               = rtrim(substr($Arr, 28, 3), " ");
                $aArrayRetorno[$i]['AGENCIA']           = rtrim(substr($Arr, 31, 4), " ");
                $aArrayRetorno[$i]['NOME_FANTAS']       = rtrim(substr($Arr, 35, 12), " ");
                $aArrayRetorno[$i]['FILLER']            = rtrim(substr($Arr, 47, 69), " ");
            }else
            if($subtipo == "99"){
                $aArrayRetorno[$i]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno[$i]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno[$i]['MSG_R270']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno[$i]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
            }
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N440($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_01 = 0;
        $i_02 = 0;
        $i_03 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['IDT_EM_1CAV_D'] = rtrim(substr($Arr, 7, 4), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['IDT_EM_UCAV']   = rtrim(substr($Arr, 11, 4), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['ITOT_CAV15']    = rtrim(substr($Arr, 15, 3), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['ITOT_CAP30']    = rtrim(substr($Arr, 18, 2), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['ITOT_CAP60']    = rtrim(substr($Arr, 20, 2), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['ITOT_CAP90']    = rtrim(substr($Arr, 22, 2), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['ITOT_CAP']      = rtrim(substr($Arr, 24, 3), " ");
                $aArrayRetorno['consultas_de_cheques_interno'][$i_00]['FILLER_0']      = rtrim(substr($Arr, 27, 89), " ");

                $i_00 ++;
            }else
            if($subtipo == "01"){
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MDT_EM_1CAV']   = rtrim(substr($Arr, 7, 4), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MDT_EM_UCAV']   = rtrim(substr($Arr, 11, 4), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MTOT_CAV15']    = rtrim(substr($Arr, 15, 3), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MTOT_CAP30']    = rtrim(substr($Arr, 18, 2), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MTOT_CAP60']    = rtrim(substr($Arr, 20, 2), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MTOT_CAP90']    = rtrim(substr($Arr, 22, 2), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['MTOT_CAP']      = rtrim(substr($Arr, 24, 3), " ");
                $aArrayRetorno['consultas_de_cheques_mercado'][$i_01]['FILLER_0']      = rtrim(substr($Arr, 27, 89), " ");
                $i_01 ++;
            }else
            if($subtipo == "02"){
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_NOME1']  = rtrim(substr($Arr, 7, 25), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_DATA1']  = rtrim(substr($Arr, 32, 4), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_NOME2']  = rtrim(substr($Arr, 36, 25), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_DATA2']  = rtrim(substr($Arr, 61, 4), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_NOME3']  = rtrim(substr($Arr, 65, 25), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['RC_DATA3']  = rtrim(substr($Arr, 90, 4), " ");
                $aArrayRetorno['consultas_referencia_comercial'][$i_02]['FILLER']    = rtrim(substr($Arr, 94, 22), " ");

                $i_02 ++;
            }else
            if($subtipo == "03"){
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['consultas_sem_cheques'][$i_03]['QTD_CONS_15']  = rtrim(substr($Arr, 7, 3), " ");
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['QTD_CONS_30']  = rtrim(substr($Arr, 10, 3), " ");
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['QTD_CONS_60']  = rtrim(substr($Arr, 13, 3), " ");
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['QTD_CONS_90']  = rtrim(substr($Arr, 16, 3), " ");
                $aArrayRetorno['consultas_sem_cheques'][$i_03]['FILLER']       = rtrim(substr($Arr, 19, 97), " ");
                $i_03 ++;
            }
            else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG_R440']  = rtrim(substr($Arr, 7, 40), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']    = rtrim(substr($Arr, 47, 69), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N505($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_01 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['alerta_de_identidade'][$i_00]['TPREG']      = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['alerta_de_identidade'][$i_00]['SUBTP']      = rtrim(substr($Arr, 5, 2), " ");
                $aArrayRetorno['alerta_de_identidade'][$i_00]['COD SCORE']  = rtrim(substr($Arr, 7, 4), " ");
                $aArrayRetorno['alerta_de_identidade'][$i_00]['MENSAGEM']   = rtrim(substr($Arr, 11, 100), " ");
                $aArrayRetorno['alerta_de_identidade'][$i_00]['FILLER']     = rtrim(substr($Arr, 111, 5), " ");

                $i_00 ++;
            }else
            if($subtipo == "01"){
                $aArrayRetorno['complemento'][$i_01]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['complemento'][$i_01]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");
                $aArrayRetorno['complemento'][$i_01]['SEQUENCIA']   = rtrim(substr($Arr, 7, 2), " ");
                $aArrayRetorno['complemento'][$i_01]['MENSAGEM']    = rtrim(substr($Arr, 9, 100), " ");
                $aArrayRetorno['complemento'][$i_01]['FILLER']      = rtrim(substr($Arr, 109, 7), " ");

                $i_01 ++;
            }else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']       = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']       = rtrim(substr($Arr, 5, 2), " ");
                $aArrayRetorno['nada_consta'][$i_99]['COD_SCORE']   = rtrim(substr($Arr, 7, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['MENSAGEM']    = rtrim(substr($Arr, 11, 100), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']      = rtrim(substr($Arr, 111, 5), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N620($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_90 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['limite_de_credito_pj'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['limite_de_credito_pj'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['limite_de_credito_pj'][$i_00]['VLR_LIMITE'] = rtrim(substr($Arr, 7, 13), " ");
                $aArrayRetorno['limite_de_credito_pj'][$i_00]['OBSERVAÇAO'] = rtrim(substr($Arr, 20, 79), " ");
                $aArrayRetorno['limite_de_credito_pj'][$i_00]['FILLER']     = rtrim(substr($Arr, 99, 17), " ");

                $i_00 ++;
            }else
            if($subtipo == "01"){
                $aArrayRetorno['mensagem_informativa'][$i_90]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['mensagem_informativa'][$i_90]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['mensagem_informativa'][$i_90]['MSG']    = rtrim(substr($Arr, 7, 79), " ");
                $aArrayRetorno['mensagem_informativa'][$i_90]['FILLER'] = rtrim(substr($Arr, 47, 30), " ");

                $i_90 ++;
            }
            else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG']     = rtrim(substr($Arr, 7, 79), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']  = rtrim(substr($Arr, 47, 30), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N640($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_90 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['faturamento_estimado_com_positivo_pj'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['faturamento_estimado_com_positivo_pj'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['faturamento_estimado_com_positivo_pj'][$i_00]['VALOR']  = rtrim(substr($Arr, 7, 18), " ");
                $aArrayRetorno['faturamento_estimado_com_positivo_pj'][$i_00]['FILLER'] = rtrim(substr($Arr, 25, 90), " ");

                $i_00 ++;
            }else
            if($subtipo == "01"){
                $aArrayRetorno['mensagem_informativa'][$i_90]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['mensagem_informativa'][$i_90]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['mensagem_informativa'][$i_90]['MSG']    = rtrim(substr($Arr, 7, 100), " ");
                $aArrayRetorno['mensagem_informativa'][$i_90]['FILLER'] = rtrim(substr($Arr, 107, 8), " ");

                $i_90 ++;
            }
            else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG']     = rtrim(substr($Arr, 7, 80), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']  = rtrim(substr($Arr, 87, 29), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N670($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['indicador_de_operaconalidade_pj'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['indicador_de_operaconalidade_pj'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['indicador_de_operaconalidade_pj'][$i_00]['DATA']    = rtrim(substr($Arr, 7, 8), " ");
                $aArrayRetorno['indicador_de_operaconalidade_pj'][$i_00]['FILLER']  = rtrim(substr($Arr, 15, 101), " ");

                $i_00 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N700($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['socios_e_acionistas'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['socios_e_acionistas'][$i_00]['TP_PESS']     = rtrim(substr($Arr, 7, 1), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['DOC']         = rtrim(substr($Arr, 8, 14), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['NOME']        = rtrim(substr($Arr, 22, 60), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['CAPITAL']     = rtrim(substr($Arr, 82, 4), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['RESTRICAO']   = rtrim(substr($Arr, 86, 1), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['SITUAC']      = rtrim(substr($Arr, 87, 1), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['SITUAC_EMPR'] = rtrim(substr($Arr, 88, 1), " ");
                $aArrayRetorno['socios_e_acionistas'][$i_00]['FILLER']      = rtrim(substr($Arr, 89, 27), " ");

                $i_00 ++;
            }
            else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG']     = rtrim(substr($Arr, 7, 80), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']  = rtrim(substr($Arr, 87, 29), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N705($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['administradores'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['administradores'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['administradores'][$i_00]['TP_PESS']     = rtrim(substr($Arr, 7, 1), " ");
                $aArrayRetorno['administradores'][$i_00]['DOC']         = rtrim(substr($Arr, 8, 14), " ");
                $aArrayRetorno['administradores'][$i_00]['NOME']        = rtrim(substr($Arr, 22, 60), " ");
                $aArrayRetorno['administradores'][$i_00]['CARGO']       = rtrim(substr($Arr, 82, 20), " ");
                $aArrayRetorno['administradores'][$i_00]['RESTRICAO']   = rtrim(substr($Arr, 102, 1), " ");
                $aArrayRetorno['administradores'][$i_00]['SITUAC']      = rtrim(substr($Arr, 103, 1), " ");
                $aArrayRetorno['administradores'][$i_00]['FILLER']      = rtrim(substr($Arr, 104, 12), " ");

                $i_00 ++;
            }
            else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG']     = rtrim(substr($Arr, 7, 80), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']  = rtrim(substr($Arr, 87, 29), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_N710($aArr)
    {
        $aArrayRetorno = [];
        $i_00 = 0;
        $i_01 = 0;
        $i_99 = 0;

        foreach($aArr as $Arr){

            $Arr = " ".$Arr;
            $subtipo = rtrim(substr($Arr, 5, 2), " ");

            if($subtipo == "00"){
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['DOC']      = rtrim(substr($Arr, 7, 14), " ");
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['NOME']     = rtrim(substr($Arr, 21, 70), " ");
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['CIDADE']   = rtrim(substr($Arr, 91, 20), " ");
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['UF']       = rtrim(substr($Arr, 111, 2), " ");
                $aArrayRetorno['paticipacao_em_outras_empresas'][$i_00]['FILLER']   = rtrim(substr($Arr, 113, 3), " ");

                $i_00 ++;
            }
            else
            if($subtipo == "01"){
                $aArrayRetorno['complemento'][$i_01]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['complemento'][$i_01]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['complemento'][$i_01]['TP_PESS'] = rtrim(substr($Arr, 7, 1), " ");
                $aArrayRetorno['complemento'][$i_01]['DOC']     = rtrim(substr($Arr, 8, 14), " ");
                $aArrayRetorno['complemento'][$i_01]['NOME']    = rtrim(substr($Arr, 22, 70), " ");
                $aArrayRetorno['complemento'][$i_01]['VINCULO'] = rtrim(substr($Arr, 92, 1), " ");
                $aArrayRetorno['complemento'][$i_01]['PERCENT'] = rtrim(substr($Arr, 93, 4), " ");
                $aArrayRetorno['complemento'][$i_01]['DESCRI']  = rtrim(substr($Arr, 97, 12), " ");
                $aArrayRetorno['complemento'][$i_01]['FILLER']  = rtrim(substr($Arr, 109, 7), " ");
                $i_01 ++;
            }else
            if($subtipo == "99"){
                $aArrayRetorno['nada_consta'][$i_99]['TPREG']  = rtrim(substr($Arr, 1, 4), " ");
                $aArrayRetorno['nada_consta'][$i_99]['SUBTP']  = rtrim(substr($Arr, 5, 2), " ");

                $aArrayRetorno['nada_consta'][$i_99]['MSG']     = rtrim(substr($Arr, 7, 80), " ");
                $aArrayRetorno['nada_consta'][$i_99]['FILLER']  = rtrim(substr($Arr, 87, 29), " ");
                $i_99 ++;
            }
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900($aArr)
    {
        $aArrayRetorno = [];
        $i=0;

        foreach($aArr as $Arr){

            $kay =  substr($Arr, 4, 4);
            $Arr = call_user_func('self::getRetorno_F900_'.$kay, $Arr);

            $aArrayRetorno[$kay][$i] = $Arr;
            $i++;
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_PCDJ($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 4), " ");

        if($subtipo == "R287"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 4), " ");

            $aArrayRetorno['COD_FAIXA']     = rtrim(substr($Arr, 13, 3), " ");
            $aArrayRetorno['VALOR_DE']      = rtrim(substr($Arr, 16, 18), " ");
            $aArrayRetorno['VALOR_ATE']     = rtrim(substr($Arr, 34, 18), " ");
            $aArrayRetorno['PERC_A_VISTA']  = rtrim(substr($Arr, 52, 3), " ");
            $aArrayRetorno['N_PERC_PARCEL'] = rtrim(substr($Arr, 55, 3), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 58, 50), " ");
        }
        else
        if($subtipo == "R288"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 4), " ");

            $aArrayRetorno['COD_FAIXA']     = rtrim(substr($Arr, 13, 3), " ");
            $aArrayRetorno['VALOR_DE']      = rtrim(substr($Arr, 16, 18), " ");
            $aArrayRetorno['VALOR ATE']     = rtrim(substr($Arr, 34, 18), " ");
            $aArrayRetorno['PERC_PONTUAL']  = rtrim(substr($Arr, 52, 3), " ");
            $aArrayRetorno['PERC_ATRASO']   = rtrim(substr($Arr, 55, 3), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 58, 50), " ");
        }else
        if($subtipo == "R289"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 4), " ");

            $aArrayRetorno['MENSAGEM']     = rtrim(substr($Arr, 13, 100), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 114, 2), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_NRCB($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 2), " ");

        if($subtipo == "00"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['MSG']       = rtrim(substr($Arr, 11, 100), " ");
            $aArrayRetorno['COD_MSG']   = rtrim(substr($Arr, 111, 2), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 113, 3), " ");
        }
        else
        if($subtipo == "01"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['DATA_ATUALIZA'] = rtrim(substr($Arr, 11, 10), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 21, 95), " ");
        }else
        if($subtipo == "02"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['ANO_CONS']      = rtrim(substr($Arr, 11, 2), " ");
            $aArrayRetorno['MES_CONS']      = rtrim(substr($Arr, 13, 2), " ");
            $aArrayRetorno['MES_DES_COM']   = rtrim(substr($Arr, 15, 3), " ");
            $aArrayRetorno['QTD_CONS']      = rtrim(substr($Arr, 18, 3), " ");
            $aArrayRetorno['QTD_BCO_CONS']  = rtrim(substr($Arr, 21, 3), " ");
            $aArrayRetorno['IND_BCO_EMP']   = rtrim(substr($Arr, 24, 1), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 25, 91), " ");
        }else
        if($subtipo == "03"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['COD_DE_SCRICAO']    = rtrim(substr($Arr, 11, 4), " ");
            $aArrayRetorno['DESCRICAO']         = rtrim(substr($Arr, 15, 25), " ");
            $aArrayRetorno['DT_CONS']           = rtrim(substr($Arr, 40, 8), " ");
            $aArrayRetorno['QTDE_CONS']         = rtrim(substr($Arr, 48, 8), " ");
            $aArrayRetorno['TP_CONS']           = rtrim(substr($Arr, 56, 1), " ");
            $aArrayRetorno['FILLER']            = rtrim(substr($Arr, 57, 59), " ");
        }else
        if($subtipo == "04"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['CNPJ_CONS']     = rtrim(substr($Arr, 11, 8), " ");
            $aArrayRetorno['FILIAL_CONS']   = rtrim(substr($Arr, 19, 4), " ");
            $aArrayRetorno['DIG_CONS']      = rtrim(substr($Arr, 23, 2), " ");
            $aArrayRetorno['RZSC_CONS']     = rtrim(substr($Arr, 25, 70), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 95, 21), " ");
        }else
        if($subtipo == "05"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 2), " ");

            $aArrayRetorno['CD_SET_SEG']    = rtrim(substr($Arr, 11, 4), " ");
            $aArrayRetorno['DS_SET_SEG']    = rtrim(substr($Arr, 15, 25), " ");
            $aArrayRetorno['DT_CON_SEG']    = rtrim(substr($Arr, 40, 8), " ");
            $aArrayRetorno['QT_COM_SEG']    = rtrim(substr($Arr, 48, 8), " ");
            $aArrayRetorno['TP_COM_SEG']    = rtrim(substr($Arr, 56, 1), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 57, 59), " ");
        }


        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REGE($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']      = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']      = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']       = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['GASTO']         = rtrim(substr($Arr, 10, 100), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 110, 6), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_PXSI($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 100), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 110, 6), " ");
        }else
        if($subtipo == "1"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 100), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 110, 6), " ");
        }else
        if($subtipo == "2"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['SEQUENCIA']   = rtrim(substr($Arr, 10, 2), " ");
            $aArrayRetorno['MENSAGEM']    = rtrim(substr($Arr, 12, 100), " ");
            $aArrayRetorno['FILLER']      = rtrim(substr($Arr, 112, 4), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_READ($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 3), " ");

        if($subtipo == "001"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['DATA']      = rtrim(substr($Arr, 12, 8), " ");
            $aArrayRetorno['HORA']      = rtrim(substr($Arr, 20, 8), " ");
            $aArrayRetorno['PONTPAG']   = rtrim(substr($Arr, 28, 4), " ");
            $aArrayRetorno['COD-MENS']  = rtrim(substr($Arr, 32, 3), " ");
            $aArrayRetorno['MSG']       = rtrim(substr($Arr, 35, 80), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 115, 1), " ");
        }else
        if($subtipo == "002"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['COD_MENS']  = rtrim(substr($Arr, 12, 4), " ");
            $aArrayRetorno['SEQUENCIA'] = rtrim(substr($Arr, 16, 3), " ");
            $aArrayRetorno['MSG']       = rtrim(substr($Arr, 19, 70), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 89, 27), " ");
        }else
        if($subtipo == "009"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['DATA']          = rtrim(substr($Arr, 12, 8), " ");
            $aArrayRetorno['HORA']          = rtrim(substr($Arr, 20, 8), " ");
            $aArrayRetorno['MSG']           = rtrim(substr($Arr, 28, 80), " ");
            $aArrayRetorno['COD_MENS']      = rtrim(substr($Arr, 108, 3), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 111, 1), " ");
            $aArrayRetorno['VAL_FILTRO']    = rtrim(substr($Arr, 112, 4), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REH3($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 3), " ");

        if($subtipo == "001"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['DATA']      = rtrim(substr($Arr, 12, 8), " ");
            $aArrayRetorno['HORA']      = rtrim(substr($Arr, 20, 8), " ");
            $aArrayRetorno['FATOR']     = rtrim(substr($Arr, 28, 4), " ");
            $aArrayRetorno['PRINAD']    = rtrim(substr($Arr, 32, 5), " ");
            $aArrayRetorno['MSG']       = rtrim(substr($Arr, 37, 78), " ");
            $aArrayRetorno['PORTE']     = rtrim(substr($Arr, 115, 1), " ");
        }else
        if($subtipo == "009"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['DATA']      = rtrim(substr($Arr, 12, 8), " ");
            $aArrayRetorno['HORA']      = rtrim(substr($Arr, 20, 8), " ");
            $aArrayRetorno['MSG']       = rtrim(substr($Arr, 28, 88), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REIC($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 70), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 80, 36), " ");
        }else
        if($subtipo == "1"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['PONTUACAO'] = rtrim(substr($Arr, 10, 4), " ");
            $aArrayRetorno['CLASSE']    = rtrim(substr($Arr, 14, 1), " ");
            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 15, 80), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 95, 21), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REHM($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;

        $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
        $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
        $aArrayRetorno['SCORE']     = rtrim(substr($Arr, 9, 6), " ");
        $aArrayRetorno['RANGE']     = rtrim(substr($Arr, 15, 6), " ");
        $aArrayRetorno['TAXA']      = rtrim(substr($Arr, 21, 5), " ");
        $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 26, 49), " ");
        $aArrayRetorno['CODIGO_M']  = rtrim(substr($Arr, 75, 6), " ");
        $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 81, 35), " ");

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REPG($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 70), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 80, 36), " ");
        }else
        if($subtipo == "1"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['PRINAD']    = rtrim(substr($Arr, 10, 16), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 26, 90), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_RERD($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 70), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 80, 36), " ");
        }else
        if($subtipo == "1"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['PERCENT_1']     = rtrim(substr($Arr, 10, 16), " ");
            $aArrayRetorno['RENDA']         = rtrim(substr($Arr, 19, 9), " ");
            $aArrayRetorno['PERCENT_99']    = rtrim(substr($Arr, 28, 9), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 37, 79), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_RETM($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 1), " ");

        if($subtipo == "0"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 10, 70), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 80, 36), " ");
        }else
        if($subtipo == "1"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 1), " ");

            $aArrayRetorno['PRINAD']    = rtrim(substr($Arr, 10, 6), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 15, 101), " ");
        }

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_RMF9($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;

        $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
        $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
        $aArrayRetorno['FAIXA']     = rtrim(substr($Arr, 9, 2), " ");
        $aArrayRetorno['CALCULADO'] = rtrim(substr($Arr, 11, 1), " ");
        $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 12, 78), " ");
        $aArrayRetorno['SETOR']     = rtrim(substr($Arr, 90, 2), " ");
        $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 92, 24), " ");

        return $aArrayRetorno;
    }

    private static function getRetorno_F900_REDC($aArr)
    {
        $aArrayRetorno = [];
        $Arr = " ".$aArr;
        $subtipo = rtrim(substr($Arr, 9, 3), " ");

        if($subtipo == "001"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['GRAU_APV']  = rtrim(substr($Arr, 12, 2), " ");
            $aArrayRetorno['MENS_APV1'] = rtrim(substr($Arr, 14, 102), " ");
        }else
        if($subtipo == "002"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['MENS_APV1'] = rtrim(substr($Arr, 12, 48), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 60, 56), " ");
        }else
        if($subtipo == "003"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['FLAG_APV_REPR'] = rtrim(substr($Arr, 12, 1), " ");
            $aArrayRetorno['COD_APV_REPR']  = rtrim(substr($Arr, 13, 2), " ");
            $aArrayRetorno['MENS_APV_REPR'] = rtrim(substr($Arr, 15, 90), " ");
            $aArrayRetorno['QTDE']          = rtrim(substr($Arr, 105, 3), " ");
            $aArrayRetorno['FILLER']        = rtrim(substr($Arr, 108, 8), " ");
        }else
        if($subtipo == "099"){
            $aArrayRetorno['TIPO_REG']  = rtrim(substr($Arr, 1, 4), " ");
            $aArrayRetorno['COD_CONS']  = rtrim(substr($Arr, 5, 4), " ");
            $aArrayRetorno['SUB_TIP']   = rtrim(substr($Arr, 9, 3), " ");

            $aArrayRetorno['MENSAGEM']  = rtrim(substr($Arr, 12, 80), " ");
            $aArrayRetorno['FILLER']    = rtrim(substr($Arr, 92, 24), " ");
        }

        return $aArrayRetorno;
    }

}
