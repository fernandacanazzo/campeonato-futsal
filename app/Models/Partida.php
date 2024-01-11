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

    protected $casts = [
        'data_inicio' => 'datetime:d/m/Y, H:i',
        'data_termino' => 'datetime:d/m/Y, H:i',
    ];

    public $timestamps = FALSE;

    public function time1(){

        return $this->belongsTo(Time::class, 'time_id_1');

    }

    public function time2(){

        return $this->belongsTo(Time::class, 'time_id_2');

    }
}
