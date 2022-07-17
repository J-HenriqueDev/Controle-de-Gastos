@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">

            <form action="{{route('gastos.store')}}" method="post" data-toggle="validator">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="usuario_id" class="form-label">Recebedor</label>
                                <select id="usuario_id" name="usuario_id" class="form-select" required>
                                    {{-- <option selected>Escolha um recebedor...</option disabled> --}}
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}" id="usuario_{{$usuario->id}}">
                                        {{$usuario->nome_usuario}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3" requir>
                                <label for="categoria_de_gastos_id" class="form-label">Categoria de Gasto</label>
                                <select id="categoria_de_gastos_id" name="categoria_de_gastos_id" class="form-select" required>
                                    {{-- <option hidden>Escolha uma categoria...</option> --}}
                                    @foreach ($categoriaGastos as $categoria)
                                    <option value="{{$categoria->id}}" id="categoria_{{$categoria->id}}">
                                        {{$categoria->categoria_de_gastos}}</option>
                                    @endforeach
                                    <div class="invalid-feedback">Exemplo de feedback invalido para o select</div>
                                </div>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm">
                            {{-- <div class="container"> --}}
                            <label for="valor" class="form-label">Valor Gasto</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" min="0.01" class="form-control" name="valor_do_gasto" id="valor"
                                    placeholder="21,90" required>

                                @error('valor_do_gasto')
                                <small class="text-danger fw-bold">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm">
                            {{-- <div class="container"> --}}
                            <label for="data" class="form-label">Data do Gasto</label>
                            <div class="input-group input-group-merge">
                                <input type="date" class="form-control" name="data_do_gasto" id="data" value="<?php echo date('Y-m-d'); ?>">

                                @error('data_do_gasto')
                                <small class="text-danger fw-bold">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="descricao" class="form-label d-block">Forma de Pagamento</label>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="forma_de_pagamento" id="dinheiro"
                                    value="1" checked>
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

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="descricao" class="form-label">Descrição do Gasto</label>
                            <textarea class="form-control" name="descricao_gasto" id="descricao" rows="4"
                                placeholder="Pagamento do boleto da Faculdade" required></textarea>

                            <div class="invalid-feedback">
                                Por favor, escolha um nome de usuário.
                            </div>
                            @error('descricao_gasto')
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
        <h5 class="card-edit m-0 me-2">Gastos Recentes</h5>
      </div>
      <div class="card-body">

        <div class="table-responsive text-nowrap">
          <table class="table table-striped">

            @foreach ($gastos as $gasto)
              <tbody>
                <tr>
                  <td class="text-left col-2"><strong>{{$gasto->usuario->nome_usuario}}</strong></td>
                  <td class="col-4">
                    <small class="text-muted">{{$gasto->descricao_gasto}}</small>
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

          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
