<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\User;
use App\Models\Gasto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Index() {
        $nome_user = Auth::user()->name;
        $mes = date('m');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        $numero = User::where('id', Auth::user()->id)->value('saldo');
        $rendaMensal = number_format($numero,2,",",".");

        $entradas = Entrada::where('user_id', Auth::user()->id)->orderBy('data_da_entrada', 'DESC')->get();
        $total = $entradas->sum('valor_da_entrada');
        return view('app.entradas.index', compact('total','nome_user','entradas','rendaMensal'));
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
            'valor_da_entrada' => 'required',
            'descricao_entrada' => 'required',
            'forma_de_entrada' => 'required',
            'data_da_entrada' => 'required',
        ]);

        $valor = str_replace(',', '.', $request->valor_da_entrada);

        Entrada::insert([
            'user_id' => Auth::user()->id,
            'valor_da_entrada' => $valor,
            'descricao_entrada' => $request->descricao_entrada,
            'forma_de_entrada' => $request->forma_de_entrada,
            'data_da_entrada' => $request->data_da_entrada,
            'dia_da_entrada' => Carbon::parse($request->data_da_entrada)->format('d'),
            'mes_da_entrada' => Carbon::parse($request->data_da_entrada)->format('m'),
            'ano_da_entrada' => Carbon::parse($request->data_da_entrada)->format('Y'),
            'created_at' => Carbon::now()
        ]);
        User::where('id', Auth::user()->id)->increment('saldo',$valor);

        $noti = [
            'message' => 'Entrada inserida com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrada $entrada)
    {
        $nome_user = Auth::user()->name;
        $mes = date('m');
        $gastoMes = Gasto::where('user_id', Auth::user()->id)->where('mes_do_gasto', $mes)->sum('valor_do_gasto');
        $entradaMes = Entrada::where('user_id', Auth::user()->id)->where('mes_da_entrada', $mes)->sum('valor_da_entrada');
        // Cálculo Renda Mensal
        $numero = $entradaMes - $gastoMes;$rendaMensal = number_format($numero,2,",",".");

        return view('app.entradas.edit', compact('entrada','rendaMensal','nome_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrada $entrada)
    {
        $request->validate([
            'valor_da_entrada' => 'required',
            'descricao_entrada' => 'required',
            'forma_de_entrada' => 'required',
            'data_da_entrada' => 'required',
        ]);

        $valor = str_replace(',', '.', $request->valor_da_entrada);

        Entrada::findOrFail($entrada->id)->update([
            'valor_da_entrada' => $valor,
            'descricao_entrada' => $request->descricao_entrada,
            'forma_de_entrada' => $request->forma_de_entrada,
            'data_da_entrada' => $request->data_da_entrada,
            'updated_at' => Carbon::now()
        ]);

        $noti = [
            'message' => 'Entrada atualizado com sucesso!',
            'alert-type' => 'success'
        ];

        return redirect()->route('entradas.index')->with($noti);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrada $entrada)
    {
        $entrada->delete();

        $noti = [
            'message' => 'Entrada removida com sucesso!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($noti);
    }
}
