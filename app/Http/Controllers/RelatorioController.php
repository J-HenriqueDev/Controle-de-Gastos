<?php

namespace App\Http\Controllers;

use App\Exports\RelatorioExport;
use App\Models\Entrada;
use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\CategoriaGasto;
use Maatwebsite\Excel\Facades\Excel;


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
        $hoje = Date('Y-m-d');
        $Year = Date('');
        $data_final = request('data_final');
        $forma_pag = request('forma_de_pagamento');
        $categoria_slc = request('categoria_de_gastos_id');
        $usuario_slc = request('usuario_id');


        $gastos = Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto', 'DESC');

        if ($usuario_slc) {
            $gastos = Gasto::where('user_id', Auth::user()->id)->where('usuario_id', $usuario_slc);
        }
        elseif ($usuario_slc and $categoria_slc)  {
            $gastos = Gasto::where('user_id', Auth::user()->id)
            ->where('usuario_id', $usuario_slc)
            ->where('categoria_de_gastos_id', $categoria_slc);
        }

        // if ($categoria_slc){
        //     $gastos = Gasto::where('user_id', Auth::user()->id)->where('categoria_de_gastos_id', $categoria_slc);
        // }
        if ($forma_pag){
            $gastos = Gasto::where('user_id', Auth::user()->id)->where('forma_de_pagamento', $forma_pag);
        }
        if ($data_inicio and $data_final){
            $gastos = Gasto::where('user_id', Auth::user()->id)->whereBetween('data_do_gasto', array($data_inicio, $data_final));
        }

        // if ($data_final == NULL and $data_inicio){
        //     $gastos = Gasto::where('user_id', Auth::user()->id)->whereBetween('data_do_gasto', array($data_inicio, $hoje));
        // }
        // if ($data_inicio == NULL and $data_final){
        //     $gastos = Gasto::where('user_id', Auth::user()->id)->whereBetween('data_do_gasto', array($data_inicio, $hoje));
        // }
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
    public function export()
    {
        $gastos= Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto')->paginate(5, ['*'], 'gastos');
        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();

        // Cálculo Renda Mensal
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $rendaMensal = $entradaMes - $gastoMes;

        $data_atual = date('d_m_Y');

       return Excel::download(new RelatorioExport($gastos), 'Relatorio_'.$data_atual.'.xlsx');
        // return view('app.gastos.relatorio.index',compact('usuarios','categoriaGastos','rendaMensal','usuario_slc',));
        //
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function relatorioentrada(Request $request)
    {
        $gastos= Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto')->paginate(5, ['*'], 'gastos');
        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();
        $entradas = Entrada::where('user_id', Auth::user()->id)->orderBy('data_da_entrada');

        // Cálculo Renda Mensal
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $rendaMensal = $entradaMes - $gastoMes;
        //

        return view('app.gastos.relatorio.index_entrada',compact('gastos','categoriaGastos','rendaMensal','entradas','dia','usuarios'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
