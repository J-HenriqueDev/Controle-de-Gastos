<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoriaGastos;
use App\Models\Gastos;

use Carbon\Carbon;

class CategoriaGastosController extends Controller
{
    public function Index() {
        $categorias = CategoriaGastos::orderBy('categoria_de_gastos', 'ASC')->get();

        return view('app.categoria_gastos.index', compact('categorias'));
    }

    public function Store(Request $request) {
        $request->validate([
            'categoria_de_gastos' => 'required'
        ], [
            'categoria_de_gastos.required' => 'Insira uma categoria!'
        ]);

        CategoriaGastos::insert([
            'categoria_de_gastos' => $request->categoria_de_gastos,
            'created_at' => Carbon::now()
        ]); 

        $noti = [
            'message' => 'Categoria inserida com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    public function Destroy($categoria_id) {
        $categoria = CategoriaGastos::findOrFail($categoria_id);
        Gastos::where('categoria_de_gastos_id', $categoria_id)->delete();

        $categoria->delete();

        $noti = [
            'message' => 'Categoria removida com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
