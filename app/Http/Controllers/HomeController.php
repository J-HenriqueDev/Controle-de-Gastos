<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gasto;
use App\Models\User;
use App\Models\Entrada;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function Home() {

        $nome_user = Auth::user()->name;

        $dataAtual = date('d-m-y');
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');

        // Gastos
        $gastoHoje = Gasto::where('user_id', Auth::user()->id)->where('dia_do_gasto', $dia)->sum('valor_do_gasto');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $gastoAno = Gasto::where('user_id', Auth::user()->id)->where('ano_do_gasto', $ano)->sum('valor_do_gasto');

        $gastoDinheiro = Gasto::where('user_id', Auth::user()->id)->where('forma_de_pagamento', 1)->sum('valor_do_gasto');
        $gastoCredito = Gasto::where('user_id', Auth::user()->id)->where('forma_de_pagamento', 2)->sum('valor_do_gasto');
        $gastoDebito = Gasto::where('user_id', Auth::user()->id)->where('forma_de_pagamento', 3)->sum('valor_do_gasto');

        // $gastos = Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto', 'DESC')->limit(5)->get();
        $gastos= Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto','DESC')->paginate(5, ['*'], 'gastos');

        // Entradas
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $entradaAno = Entrada::where('user_id', Auth::user()->id)->where('ano_da_entrada', $ano)->sum('valor_da_entrada');
        $entradas = Entrada::where('user_id', Auth::user()->id)->orderBy('data_da_entrada','DESC')->paginate(5, ['*'], 'entradas');

        // Puxar o saldo do usuario no banco de dados
        $numero = User::where('id', Auth::user()->id)->value('saldo');$rendaMensal = number_format($numero,2,",",".");

        if ($gastoMes and $entradaMes != 0)
            $porcentagem = ($gastoMes / $entradaMes) * 100;
        else
            $porcentagem = 0;


;
        return view('app.dashboard', compact(
            'gastoHoje', 'gastoMes', 'gastoAno',
            'gastoDinheiro', 'gastoCredito', 'gastoDebito',
            'gastos', 'entradas', 'rendaMensal',
            'entradaMes', 'entradaAno','porcentagem','nome_user'
        ));
    }
}
