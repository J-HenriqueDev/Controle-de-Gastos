<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;
USE App\Models\Gastos;
use App\Models\Entradas;

use Carbon\Carbon;

class UsuarioController extends Controller
{
    public function Index() {
        $usuarios = Usuarios::orderBy('created_at', 'ASC')->get();
        // Complemento da Navbar para mostrar o valor atual
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        $gastoMes = Gastos::where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entradas::where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $rendaMensal = $entradaMes - $gastoMes;
        return view('app.usuario.index', compact('usuarios','rendaMensal'));
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
