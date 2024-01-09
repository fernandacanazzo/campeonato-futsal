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
//use Illuminate\Contracts\Database\Eloquent\Builder;

class TimeController extends Controller
{

    public function show(): IlluminateResponse
    {   

        $times = Time::orderBy('nome')->get();

        return response(array("times"=>$times), 200)
            ->header('Content-Type', 'text/plain');

    }

}
