<?php

namespace App\Http\Controllers;
use App\Models\Entrada;
use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\CategoriaGasto;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data_inicio = request('data_inicio');
        $data_final = request('data_final');
        $forma_pag = request('forma_de_pagamento');
        $categoria_slc = request('categoria_de_gastos_id');
        $usuario_slc = request('usuario_id');


        $gastos = Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto', 'DESC');
        if ($usuario_slc) {
            $gastos = Gasto::where('user_id', Auth::user()->id)->where('usuario_id', $usuario_slc);
        }
        if ($categoria_slc){
            $gastos = Gasto::where('user_id', Auth::user()->id)->where('categoria_de_gastos_id', $categoria_slc);
        }
        if ($forma_pag){
            $gastos = Gasto::where('user_id', Auth::user()->id)->where('forma_de_pagamento', $forma_pag);
        }
        if ($data_inicio and $data_final){
            $gastos = Gasto::where('user_id', Auth::user()->id)->whereBetween('data_do_gasto', array($data_inicio, $data_final));
        }
            $gastos = $gastos->get();

        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();

          // Cálculo Renda Mensal
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $rendaMensal = $entradaMes - $gastoMes;
        //

        return view('app.gastos.relatorio.index',compact('gastos','usuarios','categoriaGastos','rendaMensal','usuario_slc','categoria_slc','data_inicio','data_final'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saida(Request $request)
    {
        $gastos= Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto')->paginate(5, ['*'], 'gastos');
        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();

        // Cálculo Renda Mensal
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $rendaMensal = $entradaMes - $gastoMes;
        //
        return view('app.gastos.relatorio.index',compact('usuarios','categoriaGastos','rendaMensal','usuario_slc',));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
