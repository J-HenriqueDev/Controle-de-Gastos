@extends('layouts.layout_auth')


    <nav class="navbar navbar-example navbar-expand-lg bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="javascript:void(0)">Controle de Gastos</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-ex-3"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-ex-3">
            <div class="navbar-nav me-auto">
            <a class="nav-item nav-link active" href="javascript:void(0)">Home</a>
            <a class="nav-item nav-link" href="javascript:void(0)">Quem somos?</a>
            <a class="nav-item nav-link" href="javascript:void(0)">Contato</a>
            </div>

            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        {{-- <button type="button" class="btn btn-primary btn-lg">Botão grande</button> --}}
                        <a type="button" href="{{ url('/dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary" type="button">Registrar</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">PROJETO EM DESENVOLVIMENTO</h1>
      <p class="lead">É POSSIVEL QUE ALGUMAS FUNÇÕES ESTEJAM INDISPONIVEIS OU AUSENTES.</p>
    </div>
  </div>
