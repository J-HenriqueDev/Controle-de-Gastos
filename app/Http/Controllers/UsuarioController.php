<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;

use Carbon\Carbon;

class UsuarioController extends Controller
{
    public function Index() {
        $usuarios = Usuarios::orderBy('created_at', 'ASC')->get();
        return view('app.usuario.index', compact('usuarios'));
    }

    public function Store(Request $request) {

        $request->validate([
            'nome_usuario' => 'required' 
        ], [
            'nome_usuario.required' => 'Insira um nome para este usuário!'
        ]);

        Usuarios::insert([
            'nome_usuario' => $request->nome_usuario,
            'created_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Usuário adicionado com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    public function Destroy($usuario_id) {
        Usuarios::findOrFail($usuario_id)->delete();

        $noti = [
            'message' => 'Usuário removido com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
