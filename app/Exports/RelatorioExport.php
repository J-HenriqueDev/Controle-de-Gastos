<?php

namespace App\Exports;

use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class RelatorioExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Gasto::where('user_id', Auth::user()->id)->orderBy('data_do_gasto', 'DESC')->get();
        return DB::table('gastos')
                    ->select(DB::raw(''));
    }
}
