<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entradas;

use Carbon\Carbon;

class EntradasController extends Controller
{
    public function Index() {
        $entradas = Entradas::orderBy('data_da_entrada', 'DESC')->get();

        return view('app.entradas.index', compact('entradas'));
    }

    public function Store(Request $request) {
        $request->validate([

        ]);

        // $valor = str_replace(',', '.', $request->valor_da_entrada);

        Entradas::insert([
            'valor_da_entrada' => $request->valor_da_entrada,
            'descricao_entrada' => $request->descricao_entrada,
            'forma_de_entrada' => $request->forma_de_entrada,
            'data_da_entrada' => $request->data_da_entrada,
            'dia_da_entrada' => Carbon::parse($request->data_da_entrada)->format('d'),
            'mes_da_entrada' => Carbon::parse($request->data_da_entrada)->format('m'),
            'ano_da_entrada' => Carbon::parse($request->data_da_entrada)->format('Y'),
            'created_at' => Carbon::now()
        ]); 

        $noti = [
            'message' => 'Gasto inserido com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    public function Destroy($entrada_id){
        Entradas::findOrFail($entrada_id)->delete();

        $noti = [
            'message' => 'Entrada removida com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
