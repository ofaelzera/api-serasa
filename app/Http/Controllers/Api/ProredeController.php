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
            $data = Prorede::getAnalyseSales();
            return response(['success' => 'Consulta realizada com sucesso!', 'data' => $data], 200);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage(), 'code' => $th->getCode()], 400);
        }
    }

}
