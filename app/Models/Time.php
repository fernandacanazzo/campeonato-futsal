<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Time extends Model
{
    use HasFactory;

    protected $table = 'times';

    protected $fillable = [
        'nome'
    ]; 

    public function jogadores(): HasMany
    {
        return $this->hasMany(Jogador::class);
    }

    public function partidas(): HasMany
    {
        return $this->hasMany(Partida::class);
    }

    public function classificacoes(): HasOne
    {
        return $this->hasOne(Classificacao::class);
    }
    
}
