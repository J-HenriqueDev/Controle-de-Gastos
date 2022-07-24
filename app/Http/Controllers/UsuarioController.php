<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Gasto;
use App\Models\Entrada;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        // Cálculo Renda Mensal
        $rendaMensal = $entradaMes - $gastoMes;

        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        return view('app.usuario.index', compact('usuarios','rendaMensal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome_usuario' => 'required'
        ], [
            'nome_usuario.required' => 'Insira um nome para este usuário!'
        ]);

        Usuario::insert([
            'user_id' => Auth::user()->id,
            'nome_usuario' => $request->nome_usuario,
            'created_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Usuário adicionado com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)

    {
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        // Cálculo Renda Mensal
        $rendaMensal = $entradaMes - $gastoMes;
        return view('app.usuario.edit', compact('usuario','rendaMensal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nome_usuario' => 'required'
        ]);

        Usuario::findOrFail($usuario->id)->update([
            'nome_usuario' => $request->nome_usuario,
            'updated_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Usuário atualizado com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->route('usuario.index')->with($noti);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        $noti = [
            'message' => 'Usuário removido com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
