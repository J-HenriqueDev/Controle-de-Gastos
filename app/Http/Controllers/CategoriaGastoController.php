<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoriaGasto;
use App\Models\Gastos;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Gasto;
use App\Models\Entrada;
use App\Models\User;


class CategoriaGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Index() {
        $nome_user = Auth::user()->name;
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');

        // Puxar o saldo do usuario no banco de dados
        $numero = User::where('id', Auth::user()->id)->value('saldo');$rendaMensal = number_format($numero,2,",",".");

        $categorias = CategoriaGasto::where('user_id', Auth::user()->id)->orderBy('categoria_de_gastos', 'ASC')->get();

        return view('app.gastos.categoria_gasto.index', compact('categorias','rendaMensal','nome_user'));
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
            'categoria_de_gastos' => 'required'
        ], [
            'categoria_de_gastos.required' => 'Insira uma categoria!'
        ]);

        CategoriaGasto::insert([
            'user_id' => Auth::user()->id,
            'categoria_de_gastos' => $request->categoria_de_gastos,
            'created_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Categoria inserida com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoriaGasto  $categoriaGasto
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriaGasto $categoriaGasto)
    {
        $nome_user = Auth::user()->name;
        $dia = date('d'); $mes = date('m'); $ano = date('Y');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        // Cálculo Renda Mensal
        $rendaMensal = $entradaMes - $gastoMes;
        return view('app.gastos.categoria_gasto.edit', compact('categoriaGasto','rendaMensal','nome_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\CategoriaGasto  $categoriaGasto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriaGasto $categoriaGasto)
    {
        $request->validate([
            'categoria_de_gastos' => 'required'
        ]);

        CategoriaGasto::findOrFail($categoriaGasto->id)->update([
            'categoria_de_gastos' => $request->categoria_de_gastos,
            'updated_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Categoria de Gasto atualizada com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->route('categoria-gastos.index')->with($noti);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoriaGasto  $categoriaGasto
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriaGasto $categoriaGasto)
    {
        $categoriaGasto->delete();

        $noti = [
            'message' => 'Categoria de Gasto removida com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
