@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">

            <form action="{{route('categoria-gastos.store')}}" method="post">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="categoria" class="form-label">Categoria de Gastos</label>
                            <input type="text" class="form-control form-control" name="categoria_de_gastos" id="categoria" placeholder="Fatura" required maxlength="50" autofocus>
                            <small>* São permitidos apenas 50 caractéres.</small>
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
    <div class="col-12 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-edit m-0 me-2">Categorias existentes:</h5>
        </div>
        <div class="card-body">

            @if (count($categorias) ==0)
            <p>Nenhuma categoria registrada.<p>

            @else

          <div class="table-responsive text-nowrap">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Categoria de Gasto</th>
                            <th>Data de Criação</th>
                            <th class="col-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->categoria_de_gastos}}</td>
                                <td>{{Carbon\Carbon::parse($categoria->created_at)->format('d/m/Y')}}</td>
                                <td class="d-flex justify-content-between text-center">
                                    <a type="button" href="{{route('categoria-gastos.edit', $categoria->id)}}">
                                        <i class="bx bx-edit text-success fs-3"></i>
                                    </a>

                                    <form id="removeForm_{{$categoria->id}}" action="{{route('categoria-gastos.destroy', $categoria->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a type="button" onclick="getElementById('removeForm_{{$categoria->id}}').submit()">
                                            <i class="bx bx-block text-danger fs-3"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
