<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gastos;
use App\Models\Entradas;

class HomeController extends Controller
{
    public function Home() {
        $dataAtual = date('d-m-y');
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        
        // Gastos
        $gastoHoje = Gastos::where('dia_do_gasto', $dia)->sum('valor_do_gasto');
        $gastoMes = Gastos::where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $gastoAno = Gastos::where('ano_do_gasto', $ano)->sum('valor_do_gasto');

        $gastoDinheiro = Gastos::where('forma_de_pagamento', 1)->sum('valor_do_gasto');
        $gastoCredito = Gastos::where('forma_de_pagamento', 2)->sum('valor_do_gasto');
        $gastoDebito = Gastos::where('forma_de_pagamento', 3)->sum('valor_do_gasto');

        $gastos = Gastos::orderBy('data_do_gasto', 'DESC')->limit(5)->get();

        // Entradas
        $entradaMes = Entradas::where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $entradaAno = Entradas::where('ano_da_entrada', $ano)->sum('valor_da_entrada');
        $entradas = Entradas::orderBy('data_da_entrada', 'DESC')->limit(5)->get();

        // Cálculo Renda Mensal
        $rendaMensal = $entradaMes - $gastoMes;

        return view('app.home', compact(
            'gastoHoje', 'gastoMes', 'gastoAno', 
            'gastoDinheiro', 'gastoCredito', 'gastoDebito', 
            'gastos', 'entradas', 'rendaMensal',
            'entradaMes', 'entradaAno'
        ));
    }
}
