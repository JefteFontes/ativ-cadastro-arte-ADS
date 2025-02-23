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
        $response = Http::post('https://jeftefontes.pythonanywhere.com/api/login/', [
            'username' => $request->email,
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
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://jeftefontes.pythonanywhere.com/api/register/', [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($response->successful()) {
            return redirect('/')->with('success', 'Cadastro realizado! Faça login.');
        } else {
            return back()->withErrors(['error' => 'Erro ao registrar usuário.']);
        }
    }

    public function logout()
    {
        Session::forget('access_token');
        return redirect('/');
    }
}
?>