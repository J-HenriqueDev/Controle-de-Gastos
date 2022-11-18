@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-edit m-0 me-2">Editando a categoria:  {{$categoriaGasto->categoria_de_gastos}}</h5>
              </div>
            <form action="{{route('categoria-gastos.update', $categoriaGasto->id)}}" method="post">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="categoria" class="form-label">Categoria de Gastos</label>
                            <input type="text" class="form-control form-control" name="categoria_de_gastos" id="categoria" value={{$categoriaGasto->categoria_de_gastos}} placeholder="Fatura" required maxlength="50">
                            @error('categoria_de_gastos')
                                <small class="text-danger fw-bold">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-md btn-primary fw-bold align-right">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
