<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;
use App\Models\Gastos;
use App\Models\CategoriaGastos;

use Carbon\Carbon;

class GastosController extends Controller
{
    public function Index() {
        $gastos = Gastos::orderBy('data_do_gasto', 'DESC')->get();
        $usuarios = Usuarios::orderBy('nome_usuario', 'ASC')->get();
        $categoriaGastos = CategoriaGastos::orderBy('categoria_de_gastos', 'ASC')->get();

        return view('app.gastos.index', compact('gastos', 'usuarios', 'categoriaGastos'));
    }

    public function Store(Request $request) {
        $request->validate([
        
        ]);

        $valor = str_replace(',', '.', $request->valor_do_gasto);

        Gastos::insert([
            'usuario_id' => $request->usuario_id,
            'categoria_de_gastos_id' => $request->categoria_de_gastos_id,
            'descricao_gasto' => $request->descricao_gasto,
            'forma_de_pagamento' => $request->forma_de_pagamento,
            'valor_do_gasto' => $valor,
            'data_do_gasto' => $request->data_do_gasto,
            'dia_do_gasto' => Carbon::parse($request->data_do_gasto)->format('d'),
            'mes_do_gasto' => Carbon::parse($request->data_do_gasto)->format('m'),
            'ano_do_gasto' => Carbon::parse($request->data_do_gasto)->format('Y'),
            'created_at' => Carbon::now()
        ]); 

        $noti = [
            'message' => 'Gasto inserido com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    public function Destroy($gasto_id) {
        Gastos::findOrFail($gasto_id)->delete();

        $noti = [
            'message' => 'Gasto removido com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
