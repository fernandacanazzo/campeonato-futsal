<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jogador;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\QueryException;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class JogadorController extends Controller
{
    //
    public function show(): Response
    {   

        $jogadores = Jogador::all();

        return Inertia::render('Jogador/Index',['jogadores'=>$jogadores]);
    }

    public function store(Request $request): IlluminateResponse
    {   

        $request->validate([
            'nome' => 'required|string|max:255',
            'numero_camiseta' => 'required|int',
            'time_id' => 'required|int',
        ]);

        try {

            $jogador = Jogador::create([
                'nome' => $request->nome,
                'numero_camiseta' => $request->numero_camiseta,
                'time_id' => $request->time_id,
            ]);

            return response(array("mensagem"=>"Jogador criado com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao inserir jogador no banco."), 500)
            ->header('Content-Type', 'text/plain');
           
        }

    }

}
