<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthApiController extends Controller
{

    public function login(LoginRequest $request)
    {
    if (!Auth::attempt($request->only('email', 'password'))) {
    return response()->json([
    'message' => 'Credenciais invalidas'
               ], 401);
           }

    $user = User::where('email', $request['email'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
               'access_token' => $token,
               'token_type' => 'Bearer',
    ]);
    }

}