<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    use HasFactory;

    protected $table = 'jogadores';

    protected $fillable = [
        'nome',
        'numero_camiseta',
        'time_id',
    ]; 

    public function time(){

        return $this->belongsTo(Time::class);

    }

}
