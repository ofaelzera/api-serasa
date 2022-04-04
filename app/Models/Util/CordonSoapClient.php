<?php
namespace App\Models\Util;

use Exception;
use SoapClient;

class CordonSoapClient extends SoapClient {
    function __construct($wsdl, $options) {
        parent::__construct($wsdl, $options);
    }

    function __doRequest($request, $location, $action, $version, $one_way = 0) {
        throw new Exception($request);
    }

    function __call($function_name, $arguments)
    {
        try {
            parent::__soapCall($function_name, $arguments);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
