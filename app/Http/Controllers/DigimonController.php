<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DigimonController extends Controller
{
    public function index(Request $request)
    {
        $page = 0;
        if(isset($request->page)){
            $page = $request->page - 1;
        };

        $url = 'https://digi-api.com/api/v1/digimon?pageSize=18&page='.$page;       
        $api = Http::get($url)->json();

        return Inertia::render('digimon', [
            'digimon' => $api
        ]);
    }
}
