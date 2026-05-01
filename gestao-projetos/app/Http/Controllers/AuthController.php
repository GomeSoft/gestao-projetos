<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Logout Seguro: Revoga todos os tokens do utilizador.
     */
    // app/Http/Controllers/AuthController.php

    public function logout(Request $request)
    {
        // Revoga o token atual para que não possa ser reutilizado
        $request->user()->currentAccessToken()->delete();

        // Se quiseres invalidar TODOS os dispositivos do user:
        // $request->user()->tokens()->delete();

        return redirect('/login');
    }
}