<?php

namespace App\Models\Serasa;

class Concentre
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
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@1212", 8);
        }else
        {
            $aRtn = Serasa::getTextoComBrancoDireita('23815018', 8);
            $aRtn .= Serasa::getTextoComBrancoDireita("GUI@0101", 8);
        }

        return $aRtn;
    }

    public static function getConsultaConcentre($aConsulta)
    {
        $aRtn  = self::getProtocoloB49C($aConsulta);

        if(count($aConsulta['P002']) > 4){

            $iFeatureTotal = count($aConsulta['P002']);
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
                $aRtn .= self::getProtocoloP002($feat);
            }

        }else{
            $aRtn .= self::getProtocoloP002($aConsulta['P002']);
        }

        $aRtn .= self::getProtocoloI001($aConsulta['I001']);
        $aRtn .= 'T999';



        $aRtn = Serasa::sendDados([
            'produto'    => 'concentre',
            'post'       => $aRtn,
        ]);

        $aRtn = self::getArrayRetorno($aRtn);

        return $aRtn;
    }

    private static function getProtocoloB49C($aArray)
    {
        $aArrayRetorno = [
            [ 'campo'=>'FILLER_1',          'tipo'=>'X', 'tam'=>4,      'obrig'=>true, 'value'=>'B49C', ],
            [ 'campo'=>'FILLER_2',          'tipo'=>'X', 'tam'=>6,      'obrig'=>true, 'value'=>' ',  ],
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
            [ 'campo'=>'FILLER_3',          'tipo'=>'X', 'tam'=>57,     'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'CONSULTANTE',       'tipo'=>'N', 'tam'=>15,     'obrig'=>true, 'value'=>' ' ],
            [ 'campo'=>'FILLER_4',          'tipo'=>'X', 'tam'=>234,    'obrig'=>true, 'value'=>' ' ],
        ];

        //PREENCHE O CPF OU CNPJ PARA CONSULTA
        $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'NUMDOC');
        $aArrayRetorno[$nIdx]['value'] = Serasa::getSoNumeroZeroEsquerda($aArray['DOCCONSULTA'], $aArrayRetorno[$nIdx]['tam']);

        //PREENCHE O TIPO DE PESSOA F - FISICA OU J - JURIDICA
        $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'TIPOPESSOA');
        $aArrayRetorno[$nIdx]['value'] = Serasa::getTextoComBrancoDireita($aArray['TIPOPESSOA'], $aArrayRetorno[$nIdx]['tam']);

        //CNPJ CONSULTANTE
        $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'CONSULTANTE');
        $aArrayRetorno[$nIdx]['value'] = Serasa::getSoNumeroZeroEsquerda($aArray['CONSULTANTE'], $aArrayRetorno[$nIdx]['tam']) ;

        return Serasa::montaRegistro($aArrayRetorno, $aMsgErro, true);

    }

    public static function getProtocoloP002($aFeatures)
    {

        $aArrayRetorno = [
            [ 'campo'=>'TIPO-REG',  'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>'P002'],
            [ 'campo'=>'COD1',      'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'CHAVE1',    'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'COD2',      'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'CHAVE2',    'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'COD3',      'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'CHAVE3',    'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'COD4',      'tipo'=>'X', 'tam'=>4,      'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'CHAVE4',    'tipo'=>'X', 'tam'=>21,     'obrig'=>false, 'value'=>' '],
            [ 'campo'=>'FILLER',    'tipo'=>'X', 'tam'=>11,     'obrig'=>false, 'value'=>' '],
        ];

        if($aFeatures != null){
            $i=1;

            foreach($aFeatures as $feature){
                if($i <= 4){
                    $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'COD'.$i);
                    $aArrayRetorno[$nIdx]['value'] = $feature;
                }else{
                    break;
                }
                $i++;
            }
        }


        return Serasa::montaRegistro($aArrayRetorno, $aMsgErro, true);

    }

    public static function getProtocoloI001($aFeatures)
    {

        $aArrayRetorno = [
            [ 'campo'=>'TIPO-REG',  'tipo'=>'X', 'tam'=>4,     'obrig'=>true, 'value'=>'I001'],
            [ 'campo'=>'SUBTIPO',   'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>'00'],
            [ 'campo'=>'FILTER_1',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'R'],        //CONCENTRE DETALHE/RESUMO (D OU R)
            [ 'campo'=>'FILTER_2',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'S'],        //CONFIRMEI
            [ 'campo'=>'FILTER_3',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //CONSULTAS À SERASA ==OK
            [ 'campo'=>'FILTER_4',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //ok RISCO DE CREDITO
            [ 'campo'=>'FILTER_5',  'tipo'=>'X', 'tam'=>4,     'obrig'=>true, 'value'=>' '],        //ok MODELO DO SCORE DESEJADO (RSCP OU CSPA) OBS. A OPÇÃO 6 DEVE ESTAR SELECIONADA
            [ 'campo'=>'FILTER_6',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //CONFIRMACAO DO TELEFONE
            [ 'campo'=>'FILTER_7',  'tipo'=>'N', 'tam'=>4,     'obrig'=>true, 'value'=>' '],        //CODIGO DDD
            [ 'campo'=>'FILTER_8',  'tipo'=>'N', 'tam'=>10,    'obrig'=>true, 'value'=>' '],        //NUMERO DO TELEFONE
            [ 'campo'=>'FILTER_9',  'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //LIMITE DE CREDITO PF(S OU N) PJ(H OU N)
            [ 'campo'=>'FILTER_10', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //LOCALIZAÇÃO (S OU N) ==OK
            [ 'campo'=>'FILTER_11', 'tipo'=>'N', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //QUANTIDADE DE ENDEREÇOS A RETORNAR
            [ 'campo'=>'FILTER_12', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //FIXO N
            [ 'campo'=>'FILTER_13', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //ALERTA DE IDENTIDADE PF ==OK
            [ 'campo'=>'FILTER_14', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //PARTICIPAÇÃO SOCIETARIA ==OK
            [ 'campo'=>'FILTER_15', 'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_16', 'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //

            [ 'campo'=>'FILTER_17', 'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_18', 'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_19', 'tipo'=>'X', 'tam'=>2,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_20', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //FATURAMENTO ESTIMADO COM POSITIVO
            [ 'campo'=>'FILTER_21', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //RENDA PRESUMIDA MODELO (CRP3)(S OU N)
            [ 'campo'=>'FILTER_22', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //SOCIOS ADMINISTRADORES (CNPJ)
            [ 'campo'=>'FILTER_23', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //PARTICIPAÇÃO EM EMPRESAS  (CNPJ)
            [ 'campo'=>'FILTER_24', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //INDICADOR DE OPERACIONALIDADE (CNPJ)
            [ 'campo'=>'FILTER_25', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>'N'],        //RM - INDICE RELACIONAMENTO MERCADO (PF E PJ)
            [ 'campo'=>'FILTER_26', 'tipo'=>'X', 'tam'=>4,     'obrig'=>true, 'value'=>' '],        //ALERTA DE IDENTIDADE (PF -> CAFZ)
            [ 'campo'=>'FILTER_27', 'tipo'=>'X', 'tam'=>5,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_28', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>' '],        //DESEJA CONSULTAR SITUACAO DO CNPJ
            [ 'campo'=>'FILTER_29', 'tipo'=>'X', 'tam'=>5,     'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_30', 'tipo'=>'X', 'tam'=>47,    'obrig'=>true, 'value'=>' '],        //
            [ 'campo'=>'FILTER_31', 'tipo'=>'X', 'tam'=>1,     'obrig'=>true, 'value'=>' '],        //

        ];

        if(isset($aFeatures['alerta_identidade'])       && $aFeatures['alerta_identidade'] == 'S'){

            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_13');
            $aArrayRetorno[$nIdx]['value'] = 'S';

        }
        if(isset($aFeatures['consultas_serasa'])        && $aFeatures['consultas_serasa'] == 'S') {

            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_3');
            $aArrayRetorno[$nIdx]['value'] = 'S';

        }
        if(isset($aFeatures['localizacao'])             && $aFeatures['localizacao'] == 'S') {

            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_10');
            $aArrayRetorno[$nIdx]['value'] = 'S';

        }
        if(isset($aFeatures['participacao_societaria']) && $aFeatures['participacao_societaria'] == 'S') {

            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_14');
            $aArrayRetorno[$nIdx]['value'] = 'S';

        }
        if(isset($aFeatures['score_serasa'])            && $aFeatures['score_serasa'] == 'S') {

            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_4');
            $aArrayRetorno[$nIdx]['value'] = 'S';
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_5');
            $aArrayRetorno[$nIdx]['value'] = 'RSCP';

        }

        //PJ
        if(isset($aFeatures['limite_credito_pj'])                   && $aFeatures['limite_credito_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_9');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['consultas_serasa_pj'])                 && $aFeatures['consultas_serasa_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_3');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['localizacao_pj'])                      && $aFeatures['localizacao_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_10');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['faturamento_estimado_positivo_pj'])    && $aFeatures['faturamento_estimado_positivo_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_20');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['socios_administradores_pj'])           && $aFeatures['socios_administradores_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_22');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['participacao_empresas_pj'])            && $aFeatures['participacao_empresas_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_23');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }
        if(isset($aFeatures['indicador_operacionalidade_pj'])       && $aFeatures['indicador_operacionalidade_pj'] == 'S') {
            $nIdx = Serasa::getIdxDadosEmParam($aArrayRetorno, 'FILTER_24');
            $aArrayRetorno[$nIdx]['value'] = 'S';
        }

        return Serasa::montaRegistro($aArrayRetorno, $aMsgErro, true /*ignora obrigatoriedade*/);

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
                $post = $aNewRtn[$chave];

                if(rtrim(ltrim($T99)) == "T999000STRING PARCIAL - HA MAIS REGISTROS A ENVIAR                                                                "){
                    $aRtn = Serasa::sendDados([
                        'produto'    => 'concentre',
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

        return self::getTrataRetornoArray($aNewRtn);

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
                && $kay != "I001"
                && $kay != "T999"
                && $kay != ""){
                $aArr = call_user_func('self::getRetorno_'.$kay, $aNewArray[$kay]);
                $aNewArray[$kay] = $aArr;
            }

        }

        return $aNewArray;

    }
}
