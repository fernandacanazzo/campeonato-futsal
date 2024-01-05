<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jogador;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
//use Illuminate\Contracts\Database\Eloquent\Builder;

class JogadorController extends Controller
{
    //
    public function show(): Response
    {   

        $jogadores = Jogador::all();

        //return Inertia::render('Account',['user'=>$user, 'account'=>$account]);
        return Inertia::render('Jogador/Index',['jogadores'=>$jogadores]);
    }

    /*public function edit($user): Response
    {   

        $user = User::find($user);
        return Inertia::render('Accounts/Edit', ['user_id' => $user->id]);

    }

    public function update(User $user, Request $request): RedirectResponse
    {   


       $validated = $request->validate([
        'title' => 'string|max:255',
        'description' => 'string',
        'url' => 'string|max:255|url',
        'image' => '',
            //'user_id' => 'int|required'
    ]);

       try {

        $path = Storage::putFile('public', $request->file('image'));
        $path = str_replace("public/", "", $path);

        $manager = new ImageManager(new Driver());
        $image = $manager->read(public_path("storage".DIRECTORY_SEPARATOR.$path))->resizeDown(300,300)->save();

        $item_image = array("image"=>$path);
        $validated = array_merge($validated, $item_image);

        $user->account()->update($validated);

        return redirect()->back()->with('success', "Conta atualizada");

    }catch (QueryException $ex){

        return redirect()->back()->with('error', $ex->getMessage());
    }

}*/
}
