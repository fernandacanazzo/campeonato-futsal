<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';

    protected $fillable = [
        'data_inicio',
        'data_termino',
        'time_id_1',
        'time_id_2',
        'placar_time_id_1',
        'placar_time_id_2',
    ]; 

    public function time(){

        return $this->belongsTo(Time::class);

    }
}
