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
                                <label for="usuario_id" class="form-label">Usuário</label>
                                <select id="usuario_id" name="usuario_id" class="form-select">
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
                                <input type="number" step="0.01" name="quantity" min="0.01" class="form-control" name="valor_do_gasto" id="valor"
                                {{-- <input type="number" class="form-control" name="valor_do_gasto" id="valor" --}}
                                    placeholder="21,90">

                                @error('valor_do_gasto')
                                <small class="text-danger fw-bold">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm">
                            {{-- <div class="container"> --}}
                            <label for="data" class="form-label">Data do Gasto</label>
                            <div class="input-group input-group-merge">
                                <input type="date" class="form-control" name="data_do_gasto" id="data">

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
                                placeholder="Pagamento do boleto da Faculdade"></textarea>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table responsive-table">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gastos as $gasto)
                        <tr>
                            <td>{{$gasto->usuario->nome_usuario}}</td>
                            <td>{{$gasto->descricao_gasto}}</td>
                            <td>R$ {{str_replace('.', ',', $gasto->valor_do_gasto)}}</td>
                            <td>{{Carbon\Carbon::parse($gasto->data_do_gasto)->format('d/m/Y')}}</td>
                            <td>
                                <a class="text-danger" href="{{route('gastos.destroy', $gasto->id)}}">Excluir</a>
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
