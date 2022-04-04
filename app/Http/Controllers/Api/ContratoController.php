<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Positiva\ConContrato;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function getAllContrato()
    {
        $model  = ConContrato::all();
        $data   = [];
        $i      = 0;
        foreach($model as $mod){
            $data[$i] = [
                'id'            => $mod->ID,
                'id_cliente'    => $mod->nIdCliente,
                'razao'         => $mod->getClient->aRazao,
                'fantasia'      => $mod->getClient->aFantasia,
                'cnpj'          => $mod->getClient->aCNPJ,
            ];
            $i++;
        }
        return response(compact('data'), 200);
    }
}
