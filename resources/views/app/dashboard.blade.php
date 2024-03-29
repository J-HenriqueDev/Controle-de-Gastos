
@extends('layouts.layout')

@section('content')

<div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-body">
            @if ($porcentagem == 100)
            <div class="alert alert-danger" role="alert">
                Alerta, <?php echo number_format((float)$porcentagem, 2, '.', '')?>% do valor inserido já foi utilizado!
              </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar bg-danger" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
            </div>

            @elseif($rendaMensal < 0)
            <div class="alert alert-danger" role="alert">
                Alerta, você utilizou R$<?php echo number_format((float)$rendaMensal, 2, '.', '')?> a mais do que foi inserido, por favor realize uma entrada de dinheiro para regularizar isso!
              </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar bg-danger" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>
            </div>

            @elseif ($porcentagem >= 100)
            <div class="alert alert-danger" role="alert">
                Alerta, você utilizou <?php echo number_format((float)$porcentagem, 2, '.', '')?>% a mais do que foi inserido!
              </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar bg-danger" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
            </div>

            @elseif ($porcentagem >= 60 )
                <div class="alert alert-danger" role="alert">
                    Alerta, <?php echo number_format((float)$porcentagem, 2, '.', '')?>% do valor inserido já foi utilizado!
                  </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
                </div>

            @elseif ($porcentagem == 0 )
            <div class="alert alert-danger" role="alert">
                Não encontramos nenhuma movimentação em nosso sistema, adicione um gasto para que esta barra se movimente :)
              </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
            </div>

            @elseif ($porcentagem >= 100)
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar bg-danger" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
            </div>

            @else
            <div class="alert alert-primary" role="alert">
                Atualmente foi gasto <?php echo number_format((float)$porcentagem, 2, '.', '') ?>% do seu dinheiro!
              </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem ?>%"><?php echo number_format((float)$porcentagem, 2, '.', '') ?>%</div>
            </div>



            @endif
        </div>
        </div>
      </div>
</div>

<!-- Cards Diário/Mensal/Anual -->
<div class="row mb-4">
  <!-- Diário -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">

          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/cc-success.png" alt="chart success" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="fw-semibold d-block mb-1">Gasto Diário</span>
        <h3 class="card-title mb-2">R$ {{number_format($gastoHoje,2,",",".")}}</h3>
      </div>
    </div>
  </div>

  <!-- Mensal -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="fw-semibold d-block mb-1">Gasto Mensal</span>
        <h3 class="card-title mb-2">R$ {{number_format($gastoMes,2,",",".")}}</h3>
      </div>
    </div>
  </div>

  <!-- Anual -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="d-block mb-1">Gasto Anual</span>
        <h3 class="card-title text-nowrap mb-2">R$ {{number_format($gastoAno,2,",",".")}}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Relatório de Gastos -->
<div class="row">
  <div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-edit m-0 me-2">Transações Recentes: </h5>
    </div>

    <div class="card-body">

    @if (count($gastos) ==0)
    <p>Nenhuma transação recente encontrada.<p><a href="/gastos">Clique aqui para adicionar!</a>
    </div>
    </div>
    </div>
    </div>
    @else

      <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Recebedor</th>
                    <th>Descrição</th>

                    <th>Data</th>
                    <th>Forma de pgto</th>
                    <th>Valor</th>

                </tr>
            </thead>

          @foreach ($gastos as $gasto)
            <tbody class="table-border-bottom-0">
              <tr>
                  <td class="text-left col-2"><strong>{{$gasto->usuario->nome_usuario}}</strong></td>
                  <td class="col-sm-4">
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
                    <span class="mb-0">{{number_format($gasto->valor_do_gasto,2,",",".")}}</span>
                  </td>
                </tr>
              </tbody>
            @endforeach

         </table>

        <div class="pagination justify-content-center">
            {!! $gastos->appends(['entradas' => $entradas->currentPage()])->links() !!}
        </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  @endif




<!-- Cards Crédito/Dinheiro/Pix -->
<div class="row mb-4">
  <!-- Dinheiro -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">

          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/cc-success.png" alt="chart success" class="rounded" />
          </div>

        </div>

        <!-- Descrição -->
        <span class="fw-semibold d-block mb-1">Gasto em Dinheiro</span>
        <h3 class="card-title mb-2">R$ {{number_format($gastoDinheiro,2,",",".")}}</h3>
      </div>
    </div>
  </div>

  <!-- Débito/Pix -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="fw-semibold d-block mb-1">Gasto no Débito/Pix</span>
        <h3 class="card-title mb-2">R$ {{number_format($gastoDebito,2,",",".")}}</h3>
      </div>
    </div>
  </div>

  <!-- Crédito -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
          </div>

        </div>

        <!-- Descrição -->
        <span class="d-block mb-1">Gasto no Crédito</span>
        <h3 class="card-title text-nowrap mb-2">R$ {{number_format($gastoCredito,2,",",".")}}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Relatório de Entradas -->
<div class="row">
  <div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-edit m-0 me-2">Entradas Recentes:</h5>
      </div>
      <div class="card-body">

            @if (count($entradas) ==0)
              <p>Nenhuma entrada recente encontrada.<p><a href="/entradas">Clique aqui para adicionar!</a>

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
                </div>
                  @endforeach
                </table>
                @endif
          
        </div>
      </div>
    </div>
    <div class="pagination justify-content-center">
        {!! $entradas->appends(['gastos' => $gastos->currentPage()])->links() !!}
    </div>
 </div>




<!-- Cards Entrada -->
<div class="row mb-4">
  <!-- Entrada -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/cc-success.png" alt="chart success" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="fw-semibold d-block mb-1">Entrada Mensal</span>
        <h3 class="card-title mb-2">R$ {{number_format($entradaMes,2,",",".")}}</h3>
      </div>
    </div>
  </div>

  <!-- Renda Mensal -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/cc-success.png" alt="chart success" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="d-block mb-1">Renda no Mês</span>
        <h3 class="card-title text-nowrap mb-2">
          @if($rendaMensal >= 0)
            <span class="text-success">R$ {{$rendaMensal}}</span>
          @else
            <span class="text-danger">R$ {{$rendaMensal}}</span>
          @endif
        </h3>
      </div>
    </div>
  </div>

  <!-- Entrada Anual -->
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        <div class="card-title d-flex align-items-start justify-content-between">
          <!-- Imagem/Icon -->
          <div class="avatar flex-shrink-0">
            <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
          </div>
        </div>

        <!-- Descrição -->
        <span class="d-block mb-1">Entrada Anual</span>
        <h3 class="card-title text-nowrap mb-2">R$ {{number_format($entradaAno,2,",",".")}}</h3>
      </div>
    </div>
  </div>
</div>

@endsection
