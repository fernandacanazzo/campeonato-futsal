<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class TimeController extends Controller
{

    protected function getTimes($id = ''): Collection
    {   

        if(!empty($id))
            $times = Time::where('id', $id)->get();
        else
            $times = Time::orderBy('id', 'DESC')->get();

        return $times;

    }

    public function show(): Response
    {   


        $times = $this->getTimes();

        return Inertia::render('Time/Index',['times'=>$times]);

    }

    public function busca(): IlluminateResponse
    {   

        $times = Time::orderBy('nome')->get();

        return response(array("times"=>$times), 200)
            ->header('Content-Type', 'text/plain');

    }

    public function store(Request $request): IlluminateResponse
    {   

        $request->validate([
            'nome' => 'required|string|max:255|unique:times,nome',
        ]);

        try {

            $time = Time::create([
                'nome' => $request->nome,
            ]);

            $time = $this->getTimes($time->id);

            return response(array("mensagem"=>"Time criado com sucesso.", "time"=>$time), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao inserir time no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function destroy(Request $request, string $id): IlluminateResponse
    {

        try {

            $time = Time::find($id);
            $time->delete();

             return response(array("mensagem"=>"Time excluido com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao excluir time no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function update(Request $request, string $id): IlluminateResponse
    {

        try {

            $request->validate([
                'nome' => 'required|string|max:255|unique:times,nome',
            ]);

            $time = Time::find($id);
            $time->nome = $request->nome;

            $time->save();

             return response(array("mensagem"=>"Time editado com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao editar time no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

}
