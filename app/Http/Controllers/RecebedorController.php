<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recebedor;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Gasto;
use App\Models\Entrada;
use App\Models\User;


class RecebedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $nome_user = Auth::user()->name;
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');

        // Puxar o saldo do usuario no banco de dados
        $numero = User::where('id', Auth::user()->id)->value('saldo');$rendaMensal = number_format($numero,2,",",".");

        $usuarios = Recebedor::where('user_id', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        return view('app.usuario.index', compact('nome_user','usuarios','rendaMensal'));
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

        Recebedor::insert([
            'user_id' => Auth::user()->id,
            'nome_recebedor' => $request->nome_usuario,
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
        $nome_user = Auth::user()->name;
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        // Cálculo Renda Mensal
        $rendaMensal = $entradaMes - $gastoMes;
        return view('app.usuario.edit', compact('usuario','rendaMensal','nome_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recebedor $usuario)
    {
        $request->validate([
            'nome_usuario' => 'required'
        ]);

        Recebedor::findOrFail($usuario->id)->update([
            'nome_recebedor' => $request->nome_usuario,
            'updated_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Usuário atualizado com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->route('recebedor.index')->with($noti);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recebedor $usuario)
    {
        $usuario->delete();

        $noti = [
            'message' => 'Usuário removido com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
