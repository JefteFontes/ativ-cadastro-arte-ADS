<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ArtController extends Controller
{
    public function index() {
        $token = trim(Session::get('access_token'), '"');
        if (!$token) {
            return redirect()->back()->with('error', 'Erro de autenticação. Faça login novamente.');
        }

        $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/art/');
        $arts = $response->json();

        return view('feed', compact('arts'));
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'caption' => 'required|string|max:255'
        ]);

        // Salva a imagem no armazenamento local
        $imagePath = $request->file('image')->store('arts', 'public');
        $imageFullPath = storage_path("app/public/$imagePath"); // Caminho absoluto para a imagem

        // Envia a arte para a API do Django
        $token = trim(Session::get('access_token'), '"');

        $response = Http::withToken($token)
            ->attach('image', file_get_contents($imageFullPath), basename($imagePath)) // fopen em vez de file_get_contents
            ->post('http://127.0.0.1:8000/api/art/', [
                'caption' => $request->caption
            ]);

        if ($response->successful()) {
            return redirect()->route('arts.index')->with('success', 'Arte publicada com sucesso!');
        }
        
        // Exibe erro em JSON para depuração
        return response()->json([
            'error' => 'Erro ao publicar arte.',
            'message' => $response->body()
        ], $response->status());
    }
}
