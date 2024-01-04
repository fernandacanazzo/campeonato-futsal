<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    use HasFactory;

    protected $table = 'classificacao';

    protected $fillable = [
        'time_id',
        'pontos',
        'qtd_gols',
    ]; 

    public function time(){

        return $this->belongsTo(Time::class);

    }

}
