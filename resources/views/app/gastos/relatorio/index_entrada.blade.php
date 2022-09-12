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

            <form action="{{route('relatorio_entrada.index')}}" method="GET">
                <div class="card-body">
                    <div class="row">

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
                                <input class="form-check-input" type="radio" name="forma_de_entrada" id="dinheiro" {{ $forma_pag == 1 ? 'checked' : '' }}
                                    value="1" {{ $forma_pag == '1' ? 'checked' : '' }}
                                <label class="form-check-label" for="dinheiro">Dinheiro</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="forma_de_entrada" id="debito_pix" {{ $forma_pag == 2 ? 'checked' : '' }}
                                    value="2" {{ $forma_pag == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="debito_pix">Transferência/Pix</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('relatorio_entrada.index')}}" class="btn btn-outline-primary">Exibir Todos</a><span class="espaco"></span>
                    <button class="btn btn-md btn-primary fw-bold align-right" value="&nbsp">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--  <div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-body">
            <div class="text-center">
                <a href="/exportar" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Download via Excel</a>
            </div>
        </div>
    </div>
 </div>
</div>  --}}
<div class="row">
    <div class="col-12 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-edit m-0 me-2">Entradas: {{ count($entradas) }}</h5>
        </div>
        <div class="card-body">

            @if (count($entradas) ==0)
            <p>Nenhuma entrada recente encontrada.<p>

            @else

            <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                      <tr>
                          <th>DESCRIÇÃO</th>
                          <th>Data</th>
                          <th>FORMA DE ENTRADA</th>
                          <th>Valor</th>
                      </tr>
                  </thead>
                    <tbody>
                        @foreach ($entradas as $entrada)
                        <tbody class="table-border-bottom-0">
                          <tr>
                            <td class="text-left col-6"><strong>{{$entrada->descricao_entrada}}</strong></td>
                            <td class="col-2">
                              <span class="text-muted">{{Carbon\Carbon::parse($entrada->data_da_entrada)->format('d/m/Y')}}</span>
                            </td>
                            <td class="col-2">
                              @if($entrada->forma_da_entrada == 1)
                                <span class="badge bg-label-primary me-1">Dinheiro</span>
                              @else
                                <span class="badge bg-label-info me-1">Transferência</span>
                              @endif
                            </td>
                            <td class="align-right fw-bold col-2">
                              <span class="text-success">R$</span>
                              <span class="mb-0">{{number_format($entrada->valor_da_entrada,2,",",".")}}</span>
                            </td>
                          </tr>
                        </tbody>
                        @endforeach
                        @endif

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
