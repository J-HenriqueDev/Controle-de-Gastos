<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme gap-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>


    <div class="navbar-nav-right d-flex align-items-center gap-3" id="navbar-collapse">

        {{-- Mostrador de saldo no topo da pagina --}}
        <div class="p-2 navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
            <a class="nav-edit" href="{{route('home')}}">SALDO ATUAL: </a>
            @if($rendaMensal >= 0)
            <a class="p-2 success"> R$ {{str_replace('.', ',', $rendaMensal)}}</a>
            @else
                <a class="p-2 texto-verm"> R$ {{str_replace('.', ',', $rendaMensal)}}</a>
            @endif
        </div>
    </div>
    <div class="flex-fill">
        <li class="d-flex ml-auto">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{asset('assets/img/avatars/5.png')}}" alt class="w-px-40 h-auto rounded-circle">
                <span class="fw-semibold ">{{$nome_user}}</span>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{route('logout')}}">
                  <i class="bx bx-power-off me-2"></i>
                  <span class="text-danger">Sair</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
      </div>

</nav>
