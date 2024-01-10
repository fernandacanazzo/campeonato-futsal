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
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class JogadorController extends Controller
{

    protected function getJogadores($id = ''): Collection
    {   

        if(!empty($id))
            $jogadores = Jogador::with('time')->where('id', $id)->get();
        else
            $jogadores = Jogador::with('time')->orderBy('jogadores.id', 'DESC')->get();

        return $jogadores;

    }

    public function show(): Response
    {   

        $jogadores = $this->getJogadores();

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

            $jogador = $this->getJogadores($jogador->id);

            return response(array("mensagem"=>"Jogador criado com sucesso.", "jogador"=>$jogador), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao inserir jogador no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function destroy(Request $request, string $id): IlluminateResponse
    {

        try {

            $jogador = Jogador::find($id);
            $jogador->delete();

             return response(array("mensagem"=>"Jogador excluido com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao excluir jogador no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function update(Request $request, string $id): IlluminateResponse
    {

        try {

            $request->validate([
                'nome' => 'required|string|max:255',
                'numero_camiseta' => 'required|int',
                'time_id' => 'required|int',
            ]);

            $jogador = Jogador::find($id);
            $jogador->nome = $request->nome;
            $jogador->numero_camiseta = $request->numero_camiseta;
            $jogador->time_id = $request->time_id;

            $jogador->save();

             return response(array("mensagem"=>"Jogador editado com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao editar jogador no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

}
