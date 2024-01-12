<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{

    public function show(): Response
    {   

        $classificacao = Classificacao::with(['time'])->orderBy('classificacao.pontos', 'DESC')->get();

        return Inertia::render('Home',['classificacao'=>$classificacao]);
    }
   
}
