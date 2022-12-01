<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGasto;
use App\Models\Entrada;
use App\Models\Gasto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Relatorio_entradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $nome_user = Auth::user()->name;

        $hoje = Date('Y-m-d');
        $data_inicio = request('data_inicio');
        $data_final = request('data_final');
        $forma_pag = request('forma_de_entrada');



        $gastos= Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto')->paginate(5, ['*'], 'gastos');
        $usuarios = Usuario::where('user_id', Auth::user()->id)->orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();
        $entradas = Entrada::where('user_id', Auth::user()->id)->orderBy('data_da_entrada', 'DESC');

        if ($forma_pag){
            $entradas = Entrada::where('user_id', Auth::user()->id)->where('forma_de_entrada', $forma_pag);
        } if ($data_final == NULL and $data_inicio){
            $gastos = Gasto::where('user_id', Auth::user()->id)->whereBetween('data_do_gasto', array($data_inicio, $hoje));
        } if ($data_inicio and $data_final) {
            $entradas = Entrada::where('user_id', Auth::user()->id)->whereBetween('data_da_entrada', array($data_inicio, $data_final));
        }

        $entradas = $entradas->get();
        $total = $entradas->sum('valor_da_entrada');

        // Cálculo Renda Mensal
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $numero = $entradaMes - $gastoMes;$rendaMensal = number_format($numero,2,",",".");
        //

        return view('app.gastos.relatorio.index_entrada',compact('total','forma_pag','nome_user','forma_pag','data_inicio','data_final','gastos','categoriaGastos','rendaMensal','entradas','dia','usuarios'));

    }
}
