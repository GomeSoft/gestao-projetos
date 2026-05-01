<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Logout Seguro: Revoga todos os tokens do utilizador.
     */
    public function logout(Request $request)
    {
        // 1. Revogação física do token na base de dados
        $request->user()->tokens()->delete();

        // 2. Limpeza da sessão do Laravel (se aplicável)
        Auth::guard('web')->logout();

        return response()->json([
            'message' => 'Logout efetuado e tokens revogados com sucesso.'
        ]);
    }
}