<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PefinController extends Controller
{
    public function setPefin(Request $request)
    {
        try {
            $request->validate([
                'cnpj'                  => 'required',
                'razao'                 => 'required',
                'cep'                   => 'required',
                'endereco'              => 'required',
                'numero'                => 'required',
                'complemento'           => 'required',
                'bairro'                => 'required',
                'cidade'                => 'required',
                'estado'                => 'required',
                'ddd'                   => 'required',
                'telefone'              => 'required',
                'data_vencimento'       => 'required',
                'data_final_contrato'   => 'required',
                'valor'                 => 'required',
                'numero_contrato'       => 'required',
                'codigo_natureza'       => 'required',
                //'codigo_banco'          => 'required',
                //'numero_agencia'        => 'required',
                //'numero_cheque'         => 'required',
                //'numero_conta'          => 'required',
                //'motivo'                => 'required',
            ]);



        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 400);
        }
    }
}
