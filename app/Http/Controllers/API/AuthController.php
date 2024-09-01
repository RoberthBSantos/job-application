<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function createToken(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        logger()->error('Usuário não encontrado com o e-mail fornecido.', ['email' => $request->email]);
        return response()->json(['message' => 'Usuário não encontrado.'], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        logger()->error('Falha na autenticação: senha incorreta.', [
            'email' => $request->email,
            'password_provided' => $request->password,
            'password_stored' => $user->password,
        ]);
        return response()->json(['message' => 'As credenciais fornecidas estão incorretas.'], 401);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    logger()->info('Token gerado com sucesso.', ['user_id' => $user->id, 'token' => $token]);

    return response()->json(['token' => $token], 200);
}

}

