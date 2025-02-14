<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/login/', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $tokens = $response->json();
            Session::put('access_token', $tokens['access']);
            return redirect('/feed');
        } else {
            return back()->withErrors(['error' => 'Usuário ou senha invalidos.']);
        }
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/register/', [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Cadastro realizado! Faça login.');
        } else {
            return back()->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    }

    public function logout()
    {
        Session::forget('access_token');
        return redirect('/login');
    }
}
?>