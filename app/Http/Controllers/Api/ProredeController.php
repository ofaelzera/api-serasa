<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serasa\Prorede;
use Illuminate\Http\Request;

class ProredeController extends Controller
{

    public function AnalyseSales(Request $request)
    {
        try {

            $request->validate([
                'cnpjIndireto'  => 'required',
            ]);

            $data = Prorede::getAnalyseSales($request->all());
            return response(['success' => 'Consulta realizada com sucesso!', 'data' => $data], 200);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage(), 'code' => $th->getCode()], 400);
        }
    }

    public function PartnersOrders(Request $request)
    {
        try {

        $request->validate([
            'n_conttrato'   => 'required',
        ]);

        dd($request->all());

        $data =  Prorede::getPartnersOrders($request->all());

        if(isset($data['error'])){
            return response(['error' => 'Erro ao realizar o processo!', 'data' => $data], 200);
        }

        return response(['success' => 'Consulta realizada com sucesso!', 'data' => $data], 200);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage(), 'code' => $th->getCode()], 400);
        }
    }

}
