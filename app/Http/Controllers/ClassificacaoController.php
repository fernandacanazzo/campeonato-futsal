<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classificacao;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class ClassificacaoController extends Controller
{

    public function getClassificacao(): Collection
    {   

        $classificacao = Classificacao::with(['time'])->orderBy('classificacao.pontos', 'DESC')->get();

        return $classificacao;

    }

    public static function calculaClassificacao($time_id_1, $time_id_2, $placar_time_id_1, $placar_time_id_2, $acao = ''){           
        
        if($acao != 'deletar'){

            Classificacao::updateOrCreate(
                ['time_id' => $time_id_1]
            )->increment('qtd_gols',$placar_time_id_1);

            Classificacao::updateOrCreate(
                ['time_id' => $time_id_2]
            )->increment('qtd_gols',$placar_time_id_2);

            //atualiza pontos
            if($placar_time_id_1 > $placar_time_id_2){

                Classificacao::where('time_id',$time_id_1)->increment('pontos',3);

            }elseif($placar_time_id_1 < $placar_time_id_2){

                Classificacao::where('time_id',$time_id_2)->increment('pontos',3);

            }else{//empate

                Classificacao::where('time_id',$time_id_1)->increment('pontos',1);
                Classificacao::where('time_id',$time_id_2)->increment('pontos',1);

            }

        }else{

            Classificacao::updateOrCreate(
                ['time_id' => $time_id_1]
            )->decrement('qtd_gols',$placar_time_id_1);

            Classificacao::updateOrCreate(
                ['time_id' => $time_id_2]
            )->decrement('qtd_gols',$placar_time_id_2);

            //atualiza pontos
            if($placar_time_id_1 > $placar_time_id_2){

                Classificacao::where('time_id',$time_id_1)->decrement('pontos',3);

            }elseif($placar_time_id_1 < $placar_time_id_2){

                Classificacao::where('time_id',$time_id_2)->decrement('pontos',3);

            }else{//empate

                Classificacao::where('time_id',$time_id_1)->decrement('pontos',1);
                Classificacao::where('time_id',$time_id_2)->decrement('pontos',1);

            }

        }

    }
   
}
