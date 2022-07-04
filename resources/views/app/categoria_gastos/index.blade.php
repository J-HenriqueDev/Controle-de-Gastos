@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            
            <form action="{{route('categoria.gastos.store')}}" method="post">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="categoria" class="form-label">Categoria de Gastos</label>
                            <input type="text" class="form-control form-control" name="categoria_de_gastos" id="categoria" placeholder="Fatura">
                            @error('categoria_de_gastos')
                                <small class="text-danger fw-bold">{{$message}}</small>   
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-md btn-primary fw-bold align-right">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table responsive-table">
                    <thead>
                        <tr>
                            <th>Nome Usuário</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->categoria_de_gastos}}</td>
                                <td>{{Carbon\Carbon::parse($categoria->created_at)->format('d/m/Y')}}</td>
                                <td>
                                    <a class="text-danger" href="{{route('categoria.gastos.destroy', $categoria->id)}}">Excluir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection