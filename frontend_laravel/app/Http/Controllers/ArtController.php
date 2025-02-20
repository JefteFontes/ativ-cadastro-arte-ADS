<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ArtController extends Controller
{
    public function index(Request $request){
        $token = trim(Session::get('access_token'), '"');
        if (!$token) {
            return redirect()->back()->with('error', 'Erro de autenticação. Faça login novamente.');
        }

        $urlAll = 'https://jeftefontes.pythonanywhere.com/api/art';
        $urlMine = 'https://jeftefontes.pythonanywhere.com/api/art?my_arts=true';

        // Requisições separadas para todas as artes e as artes do usuário autenticado
        $responseAll = Http::withToken($token)->get($urlAll);
        $responseMine = Http::withToken($token)->get($urlMine);

        if (!$responseAll->successful() || !$responseMine->successful()) {
            return redirect()->back()->with('error', 'Erro ao carregar as artes.');
        }

        $arts = $responseAll->json();
        $myArts = $responseMine->json();

        return view('feed', compact('arts', 'myArts'));
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'caption' => 'required|string|max:255'
        ]);

        $token = trim(Session::get('access_token'), '"');

        $imagePath = $request->file('image')->store('arts', 'public');
        $imageFullPath = storage_path("app/public/$imagePath");

        $response = Http::withToken($token)
            ->attach('image', file_get_contents($imageFullPath), basename($imagePath))
            ->post('https://jeftefontes.pythonanywhere.com/api/art/', [
                'caption' => $request->caption
            ]);

        if ($response->successful()) {
            return redirect()->route('arts.index')->with('success', 'Arte publicada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao publicar arte.');
    }

    public function update(Request $request, $artId) {
        $token = trim(Session::get('access_token'), '"');

        $response = Http::withToken($token)
            ->put("https://jeftefontes.pythonanywhere.com/api/art/$artId/", [
                'caption' => $request->caption
            ]);

        if ($response->successful()) {
            return redirect()->route('arts.index')->with('success', 'Arte atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar arte.');
    }

    public function destroy($artId) {
        $token = trim(Session::get('access_token'), '"');

        $response = Http::withToken($token)
            ->delete("https://jeftefontes.pythonanywhere.com/api/art/$artId/");

        if ($response->successful()) {
            return redirect()->route('arts.index')->with('success', 'Arte deletada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao deletar arte.');
    }
}
