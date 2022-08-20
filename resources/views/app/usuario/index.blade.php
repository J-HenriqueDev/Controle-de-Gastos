@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">

            <form action="{{route('usuario.store')}}" method="post">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="novo_usuario" class="form-label">Nome do Recebedor</label>
                            <input type="text" class="form-control form-control" name="nome_usuario" id="novo_usuario" placeholder="Fábio Menandro" autofocus required>
                            @error('nome_usuario')
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
    <div class="col-12 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-edit m-0 me-2">Recebedores existentes:</h5>
        </div>
        <div class="card-body">

          <div class="table-responsive text-nowrap">
            <table class="table">
                        <thead>
                        <tr>
                            <th>Recebedor</th>
                            <th>Data de Criação</th>
                            <th class="col-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->nome_usuario}}</td>
                                <td>{{Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y')}}</td>
                                <td class="d-flex justify-content-between text-center">
                                    <a type="button" href="{{route('usuario.edit', $usuario->id)}}">
                                        <i class="bx bx-edit text-success fs-3"></i>
                                    </a>

                                    <form id="removeForm_{{$usuario->id}}" action="{{route('usuario.destroy', $usuario->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a type="button" onclick="getElementById('removeForm_{{$usuario->id}}').submit()">
                                            <i class="bx bx-block text-danger fs-3"></i>
                                        </a>
                                    </form>
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
