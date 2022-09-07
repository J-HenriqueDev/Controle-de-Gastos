@extends('layouts.layout')

@section('content')


@if (count($usuarios) == 0 and count($categoriaGastos) == 0)
<div class="alert alert-danger alert-dismissible" role="alert">
    É necessário que você cadastre um recebedor e uma categoria para proseeguir! Você pode cadastrar um recebedor
    <a color: red, href="{{route('usuario.index')}}">aqui</a> e uma categoria
    <a href="{{route('categoria-gastos.index')}}">aqui</a>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
    @elseif (count($usuarios) != 0 and count($categoriaGastos) == 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
        Por favor crie uma categoria para prosseguir com o registro de saida. Clique
        <a href="{{route("categoria-gastos.index")}}"">aqui</a>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>

      @elseif (count($usuarios) == 0 and count($categoriaGastos) != 0)
      <div class="alert alert-danger alert-dismissible" role="alert">
        Por favor crie uma recebedor para prosseguir com o registro de saida. Clique
        <a href="{{route('usuario.index')}}">aqui</a>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>

      @endif


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">

            <form action="{{route('relatorios.index')}}" method="GET">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="usuario_id" class="form-label">Recebedor</label>
                                <select id="usuario_id" name="usuario_id" class="form-select">
                                    <option value="" disabled selected>Escolha um recebedor...</option>
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}" {{$usuario->id == $usuario_slc ? 'selected' : ""}} id="usuario_{{$usuario->id}}">
                                        {{$usuario->nome_usuario}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="categoria_de_gastos_id" class="form-label">Categoria de Gasto</label>
                                <select id="categoria_de_gastos_id" name="categoria_de_gastos_id" class="form-select" >
                                    <option value="" disabled selected>Selecione uma Categoria</option>
                                    @foreach ($categoriaGastos as $categoria)
                                    <option value="{{$categoria->id}}"{{$categoria->id == $categoria_slc ? 'selected' : ""}} id="categoria_{{$categoria->id}}">
                                        {{$categoria->categoria_de_gastos}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm">
                            <label for="data" class="form-label">Data Inicial</label>
                            <div class="input-group input-group-merge">
                                <input type="date" class="form-control" name="data_inicio" id="data" value="{{$data_inicio}}">

                                @error('data_inicio')
                                <small class="text-danger fw-bold">{{$message}}</small>
                                @enderror
                            </div>
                            </div>
                            <div class="col-sm">
                                <label for="data" class="form-label">Data Final</label>
                                <div class="input-group input-group-merge">
                                    <input type="date" class="form-control" name="data_final" id="data" value="{{$data_final}}">

                                    @error('data_final')
                                    <small class="text-danger fw-bold">{{$message}}</small>
                                    @enderror
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="descricao" class="form-label d-block">Forma de Pagamento</label>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="forma_de_pagamento" id="dinheiro"
                                    value="1">
                                <label class="form-check-label" for="dinheiro">Dinheiro</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="forma_de_pagamento" id="credito"
                                    value="2">
                                <label class="form-check-label" for="credito">Crédito</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="forma_de_pagamento" id="debito_pix"
                                    value="3">
                                <label class="form-check-label" for="debito_pix">Débito/Pix</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('relatorios.index')}}" class="btn btn-outline-primary">Exibir Todos</a><span class="espaco"></span>
                    <button class="btn btn-md btn-primary fw-bold align-right" value="&nbsp">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-body">
            <div class="text-center">
                <a href="/exportar" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Download via Excel</a>
            </div>
        </div>
    </div>
 </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-edit m-0 me-2">Transações:</h5>
        </div>
        <div class="card-body">
            @if (count($gastos) == 0)
            <p>Nenhuma transação recente encontrada.<p>

            @else

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Recebedor</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Data</th>
                            <th>Forma de pgto</th>
                            <th>Valor</th>

                        </tr>
                    </thead>

                  @foreach ($gastos as $gasto)
                    <tbody class="table-border-bottom-0">
                      <tr>
                          <td class="text-left col-2"><strong>{{$gasto->Usuario->nome_usuario}}</strong></td>
                          <td class="col-3">
                            <small class="text-muted">{{$gasto->descricao_gasto}}</small>
                          </td>
                          <td class="col-3">
                            <span class="badge bg-secondary me-1">{{$gasto->categoria->categoria_de_gastos}}</span>
                            {{-- <dd>{{$gasto->Categoria}}</dd> --}}
                          </td>
                          <td class="col-2">
                            <span class="text-muted">{{Carbon\Carbon::parse($gasto->data_do_gasto)->format('d/m/Y')}}</span>
                          </td>
                          <td class="col-2">
                            @if($gasto->forma_de_pagamento == 1)
                              <span class="badge bg-label-primary me-1">Dinheiro</span>
                            @elseif($gasto->forma_de_pagamento == 2)
                              <span class="badge bg-label-danger me-1">Crédito</span>
                            @else
                              <span class="badge bg-label-info me-1">Débito</span>
                            @endif
                          </td>
                          <td class="align-right fw-bold">
                            <span class="text-success">R$</span>
                            <span class="mb-0">{{str_replace('.', ',', $gasto->valor_do_gasto)}}</span>
                          </td>
                        </tr>
                      </tbody>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
