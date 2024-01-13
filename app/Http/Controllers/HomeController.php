<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show(Request $request)
    {   

        $classificacao = Classificacao::with(['time'])->orderBy('classificacao.pontos', 'DESC')->get();

        if(!str_contains($request->getRequestUri(), "/api/")){

            return Inertia::render('Home',['classificacao'=>$classificacao]);

        }else{// se vier da API

            return response(array("classificacao"=>$classificacao), 200)
            ->header('Content-Type', 'application/json');

        }
    }
   
}
