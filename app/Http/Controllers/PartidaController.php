<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Http\Controllers\ClassificacaoController;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class PartidaController extends Controller
{

    protected function getPartidas($id = ''): Collection
    {   

        if(!empty($id))
            $partidas = Partida::with(['time1','time2'])->where('id', $id)->get();
        else
            $partidas = Partida::with(['time1','time2'])->orderBy('partidas.id', 'DESC')->get();

        return $partidas;

    }

    public function show(): Response
    {   

        $partidas = $this->getPartidas();

        return Inertia::render('Partida/Index',['partidas'=>$partidas]);
    }

    public function store(Request $request): IlluminateResponse
    {   

        $request->validate([
            'data_inicio' => 'required|date',
            'data_termino' => 'required|date',
            'time_id_1' => 'required|int',
            'time_id_2' => 'required|int',
            'placar_time_id_1' => 'required|int',
            'placar_time_id_2' => 'required|int',
        ]);

        $data_inicio = explode("T", $request->data_inicio);
        $data_inicio = $data_inicio[0] . " " . substr($data_inicio[1], 0, 8);

        $data_termino = explode("T", $request->data_termino);
        $data_termino = $data_termino[0] . " " . substr($data_termino[1], 0, 8);

        try {

            $partida = Partida::create([
                'data_inicio' => $data_inicio,
                'data_termino' => $data_termino,
                'time_id_1' => $request->time_id_1,
                'time_id_2' => $request->time_id_2,
                'placar_time_id_1' => $request->placar_time_id_1,
                'placar_time_id_2' => $request->placar_time_id_2,
            ]);

            $partida = $this->getPartidas($partida->id);

            ClassificacaoController::calculaClassificacao($request->time_id_1, $request->time_id_2, $request->placar_time_id_1, $request->placar_time_id_2);

            return response(array("mensagem"=>"Partida criada com sucesso.", "partida"=>$partida), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao excluir partida no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function destroy(Request $request, string $id): IlluminateResponse
    {

        try {

            $partida = Partida::find($id);

            $time_id_1 = $partida->time_id_1;
            $time_id_2 = $partida->time_id_2;
            $placar_time_id_1 = $partida->placar_time_id_1;
            $placar_time_id_2 = $partida->placar_time_id_2;        

            $partida->delete();

            ClassificacaoController::calculaClassificacao($time_id_1, $time_id_2, $placar_time_id_1, $placar_time_id_2, 'deletar');

            return response(array("mensagem"=>"Partida excluida com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao excluir partida no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

    public function update(Request $request, string $id): IlluminateResponse
    {

        try {

            $request->validate([
                'data_inicio' => 'required|date',
                'data_termino' => 'required|date',
                'time_id_1' => 'required|int',
                'time_id_2' => 'required|int',
                'placar_time_id_1' => 'required|int',
                'placar_time_id_2' => 'required|int',
            ]);

            $data_inicio = explode("T", $request->data_inicio);
            $data_inicio = $data_inicio[0] . " " . substr($data_inicio[1], 0, 8);

            $data_termino = explode("T", $request->data_termino);
            $data_termino = $data_termino[0] . " " . substr($data_termino[1], 0, 8);

            $partida = Partida::find($id);

            //guarda os valores antigos para calculo da classificação
            $time_id_1 = $partida->time_id_1;
            $time_id_2 = $partida->time_id_2;
            $placar_time_id_1 = $partida->placar_time_id_1;
            $placar_time_id_2 = $partida->placar_time_id_2;

            $partida->data_inicio = $data_inicio;
            $partida->data_termino = $data_termino;
            $partida->time_id_1 = $request->time_id_1;
            $partida->time_id_2 = $request->time_id_2;
            $partida->placar_time_id_1 = $request->placar_time_id_1;
            $partida->placar_time_id_2 = $request->placar_time_id_2;

            $partida->save();

            //subtrai os valores antigos da classificacao
            ClassificacaoController::calculaClassificacao($time_id_1, $time_id_2, $placar_time_id_1, $placar_time_id_2, 'deletar');

            ClassificacaoController::calculaClassificacao($request->time_id_1, $request->time_id_2, $request->placar_time_id_1, $request->placar_time_id_2);

            return response(array("mensagem"=>"Partida editada com sucesso."), 200)
            ->header('Content-Type', 'text/plain');

        }catch (QueryException $ex){

            return response(array("mensagem"=>"Erro ao editar partida no banco."), 500)
            ->header('Content-Type', 'text/plain');

        }

    }

}
