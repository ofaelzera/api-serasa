<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serasa\Gerencie;
use Illuminate\Http\Request;

class GerencieController extends Controller
{
    public function index()
    {
        $teste = Gerencie::connect();
    }
}
