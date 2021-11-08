<?php
namespace App\Models\Serasa;

use SoapClient;
use stdClass;
use SoapVar;
use SoapHeader;
use SimpleXMLElement;
use SoapFault;

use App\Models\Util\CordonSoapClient;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Positiva\ConEmpresa;

class Serasa
{

    public static function getLoginApiSerasa($Producao)
    {

        $client = new Client();

        if($Producao){
            $Url = 'https://api.serasaexperian.com.br/security/iam/v1/client-identities/login';
        }else{
            $Url = 'https://uat-api.serasaexperian.com.br/security/iam/v1/client-identities/login';
        }

        $res = $client->request('POST', $Url, [
            'headers' => [
                'content-type'  => 'application/json',
                'Authorization' => 'Basic MjM4MTUwMThzZDpNVURBQDEyMw==',
                'php-auth-user' => '23815018',
                'php-auth-pw'   => 'MUDA@123'
            ],
        ]);

        if($res->getStatusCode() == 201){
            //$response_data;
        }else{
            //$response_data = null;
        }
    }

    public static function sendDados($aArrayOpcoes)
    {
        $aUrl = "";
        if(isset($aArrayOpcoes['produto']) ) {
            if($aArrayOpcoes['produto'] == 'crednet') {
                $aUrl = Crednet::getUrl();
            }
            else
            if($aArrayOpcoes['produto'] == 'concentre') {
                $aUrl = Concentre::getUrl();
            }
        }
        $aPost = "";
        if(isset($aArrayOpcoes['post']) ) {
            if($aArrayOpcoes['produto'] == 'crednet') {
                $aPost = "p=" . Crednet::getAssinaturaDistribuidor() . $aArrayOpcoes['post'];
            }
            else
            if($aArrayOpcoes['produto'] == 'concentre') {
                $aPost = "p=" . Concentre::getAssinaturaDistribuidor() . $aArrayOpcoes['post'];
            }
            else {
                $aPost = "p=" . $aArrayOpcoes['post'];
            }
        }

        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();

        //curl_setopt($ch, CURLOPT_URL, 'https://mqlinuxext.serasa.com.br/Homologa/consultahttps');
        curl_setopt($ch, CURLOPT_URL, $aUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $aPost);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    public static function sendDadosSOAP($aProd ,$aFunction, $aOpcoes, $aLogon)
    {
        try{
            switch($aProd){
                case 'meproteja' :
                    $aUrl = MeProteja::getUrl();
                break;
            }

            $Soap = new SoapClient($aUrl, ['trace' => true]);
            $Soap->__setSoapHeaders(self::soapClientWSSecurityHeader($aLogon['logon'], $aLogon['password']));
            $Return = $Soap->__soapCall($aFunction, $aOpcoes);

            /*
            $Soap = new CordonSoapClient($aUrl, ['trace' => true]);
            $Soap->__setSoapHeaders(self::soapClientWSSecurityHeader($aLogon['logon'], $aLogon['password']));
            //$Return = $Soap->__getFunctions();
            $Return = $Soap->__call($aFunction, $aOpcoes);
            */

            return ['success' => true, 'data' => $Return];

        }catch(SoapFault $e){
            return ['success' => false, 'message' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }

    public static function soapClientWSSecurityHeader($user, $password)
    {
       // Creating date using yyyy-mm-ddThh:mm:ssZ format
       //$tm_created = gmdate('Y-m-d\TH:i:s\Z');
       //$tm_expires = gmdate('Y-m-d\TH:i:s\Z', gmdate('U') + 180); //only necessary if using the timestamp element

       // Generating and encoding a random number
       //$simple_nonce = mt_rand();
       //$encoded_nonce = base64_encode($simple_nonce);

       // Compiling WSS string
       //$passdigest = base64_encode(sha1($simple_nonce . $tm_created . $password, true));

       // Initializing namespaces
       $ns_wsse = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
       $ns_wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
       $password_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';
       $encoding_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary';

       // Creating WSS identification header using SimpleXML
       $root = new SimpleXMLElement('<root/>');

       $security = $root->addChild('wsse:Security', null, $ns_wsse);

       //the timestamp element is not required by all servers
       //$timestamp = $security->addChild('wsu:Timestamp', null, $ns_wsu);
       //$timestamp->addAttribute('wsu:Id', 'Timestamp-28');
       //$timestamp->addChild('wsu:Created', $tm_created, $ns_wsu);
       //$timestamp->addChild('wsu:Expires', $tm_expires, $ns_wsu);

       $usernameToken = $security->addChild('wsse:UsernameToken', null, $ns_wsse);
       $usernameToken->addChild('wsse:Username', $user, $ns_wsse);
       //$usernameToken->addChild('wsse:Password', $password, $ns_wsse)->addAttribute('Type', $password_type);
       $usernameToken->addChild('wsse:Password', $password, $ns_wsse);
       //$usernameToken->addChild('wsse:Nonce', $encoded_nonce, $ns_wsse)->addAttribute('EncodingType', $encoding_type);
       //$usernameToken->addChild('wsu:Created', $tm_created, $ns_wsu);

       // Recovering XML value from that object
       $root->registerXPathNamespace('wsse', $ns_wsse);
       $full = $root->xpath('/root/wsse:Security');
       $auth = $full[0]->asXML();

       return new SoapHeader($ns_wsse, 'Security', new SoapVar($auth, XSD_ANYXML), true);

    }


    //FUNCTIONS UTIL SERASA
    public static function montaRegistro($aArrayRetorno, &$aMsgErro=false, $fIgnoraObrigatoriedade=false)
    {
        $aRtn = "";
        $nSeq = 0;
        foreach($aArrayRetorno as $aCampo) {
            if(count($aCampo) <= 0) {
                // campo vazio, nao trata
                continue;
            }

            if(!isset($aCampo['campo']) ) {
                $aMsgErro='Seq: ' . $nSeq . ' Falta Nome do Campo [campo]';
                return false;
            }
            if(!isset($aCampo['tipo']) ) {
                $aMsgErro='Seq: ' . $nSeq . ' Falta Tipo de Campo [tipo], Campo:' . $aCampo['campo'];
                return false;
            }
            if(!isset($aCampo['tam']) ) {
                $aMsgErro='Seq: ' . $nSeq . ' Falta Tamanho do Campo [tam], Campo:' . $aCampo['campo'];
                return false;
            }
            if(!isset($aCampo['obrig']) ) {
                $aMsgErro='Seq: ' . $nSeq . ' Falta Obrigatoriedade do Campo [obrig], Campo:' . $aCampo['campo'];
                return false;
            }

            $aDado = self::getCampo($aCampo);
            if($aCampo['obrig'] == true) {
                if(($aCampo['tipo'] == 'C' ||
                    $aCampo['tipo'] == 'B' ||
                    $aCampo['tipo'] == 'X')
                && strlen(trim($aDado)) <= 0
                && $fIgnoraObrigatoriedade == false) {
                    $aMsgErro='Seq: ' . $nSeq . ' Campo Obrigatorio Vazio, Campo:' . $aCampo['campo'];
                    return false;
                }
                if($aCampo['tipo'] == 'N'
                && $aDado <= 0
                && $fIgnoraObrigatoriedade == false) {
                    $aMsgErro='Seq: ' . $nSeq . ' Campo Obrigatorio Zerado, Campo:' . $aCampo['campo'];
                    return false;
                }
            }
            $aRtn .= $aDado;
            $nSeq++;
        }
        return $aRtn;
    }

    private static function getCampo($aCampo)
    {
        $aValor = '';
        if(!isset($aCampo['tipo']) ) {
            $aCampo['tipo'] = 'C';
        }

        if(isset($aCampo['value']) ) {
            $aValor = $aCampo['value'];
        }
        else {
            //if(isset(self::data[ $aCampo['value'] ]) ) {
            //    $aValor = self::data[ $aCampo['value'] ];
            // }
            //else
            if($aCampo['tipo'] == 'N') {
                $aValor = 0;
            }
        }
        switch($aCampo['tipo']) {
            case 'C' :
            case 'X' :
                $aValor = str_pad($aValor, $aCampo['tam'], ' ', STR_PAD_RIGHT);
                //$aValor = str_pad($aValor, $aCampo['tam'], '0', STR_PAD_LEFT);
                if(strlen($aValor) > $aCampo['tam']) {
                    return substr($aValor, 0, $aCampo['tam']);
                }
                return $aValor;
            case 'B' : // NUMERICO, mas se estiver zerado, fica branco ...
                if(strlen(trim($aValor)) > 0
                && $aValor > 0) {
                    return self::getSoNumeroZeroEsquerda($aValor, $aCampo['tam']);
                }
                // deve ficar branco ...
                return str_pad('', $aCampo['tam'], ' ', STR_PAD_RIGHT);
            case 'N' :
                return self::getSoNumeroZeroEsquerda($aValor, $aCampo['tam']);
                /*
                // pegar somente numeros ... http://www.cesar.inf.br/blog/?p=191
                $aValor = preg_replace("/[^0-9]/", "", $aValor);
                $nTam = strlen($aValor);
                if($nTam > $aCampo['tam']) {
                    return substr($aValor, $nTam-$aCampo['tam'], $aCampo['tam']);
                }
                return str_pad($aValor, $aCampo['tam'], '0', STR_PAD_LEFT);
                */
        }
    }

    public static function getIdxDadosEmParam($aArrayParam, $aChave)
    {
        for($nIdx=0; $nIdx < count($aArrayParam); $nIdx++) {
            if(isset($aArrayParam[$nIdx])
            && isset($aArrayParam[$nIdx]['campo'])
            && $aArrayParam[$nIdx]['campo'] == $aChave) {
                return $nIdx;
            }
        }
        return -1;
    }

    public static function getTextoComBrancoDireita($aValor, $nTam, $fZonado=true)
    {
        $aValor = str_replace('ç', 'c', $aValor);
        $aValor = str_replace('Ç', 'C', $aValor);
        $aValor = str_replace('º', ' ', $aValor);


        if($fZonado) {
            $aValor = htmlentities($aValor, ENT_COMPAT, "UTF-8");
            $aValor = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$aValor);
            $aValor = html_entity_decode($aValor);
            $aValor = strtoupper($aValor);
        }
        $aValor = str_pad($aValor, $nTam, ' ', STR_PAD_RIGHT);
        /*
        if($fZonado) {
            $aValor = strtoupper($aValor);
            setlocale(LC_CTYPE, 'pt_BR'); // Defines para pt-br
            //$aValor = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , $aValor );
            $aValor = iconv( "UTF-8" , "ASCII//TRANSLIT" , $aValor );
            //$aValor = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $aValor );
            //$aValor = preg_replace('/[^A-Za-z0-9\-]/', '', $aValor );
        }
        */
        if(strlen($aValor) > $nTam) {
            return substr($aValor, 0, $nTam);
        }
        return $aValor;
    }

    public static function getSoNumeroZeroEsquerda($aValor, $nTam)
    {
        $aValor = str_replace('ç', 'c', $aValor);
        $aValor = str_replace('Ç', 'C', $aValor);
        $aValor = str_replace('º', ' ', $aValor);

        $aValor = preg_replace("/[^0-9]/", "", $aValor);
        $nTamAtual = strlen($aValor);
        if($nTamAtual > $nTam) {
            return substr($aValor, $nTamAtual-$nTam, $nTam);
        }
        return str_pad($aValor, $nTam, '0', STR_PAD_LEFT);
    }

    public static function getNumeroCNPJ($aValor, $nTam)
    {
        $aValor = preg_replace("/[^0-9]/", "", $aValor);
        //                                 1111
        //                       01234567890123
        // 126456789 12345678    12345678901234
        // 99.999.999/0001-99 => 99999999000199 => tam: 14
        $aValor = str_pad($aValor, 14, '0', STR_PAD_LEFT);
        if($nTam == 9) {
            // so parte interessante do cnpj
            $aValor = substr($aValor, 0, 8);
        }
        $nTamAtual = strlen($aValor);
        if($nTamAtual > $nTam) {
            return substr($aValor, $nTamAtual-$nTam, $nTam);
        }
        return str_pad($aValor, $nTam, '0', STR_PAD_LEFT);
    }

    public static function getReplace($aValor, $nTam){

        $aValor = preg_replace("/[^0-9]/", "", $aValor);
        $aValor = substr($aValor, 0, $nTam);

        return $aValor;
    }

}
