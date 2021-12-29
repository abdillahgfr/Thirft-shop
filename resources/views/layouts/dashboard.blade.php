<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>@yield('title')</title>

  @stack('prpend-style')
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link href="/style/main.css" rel="stylesheet" />
  @stack('addon-style')

  <style>
    .rate {
      float: left;
      height: 46px;
      padding: 0 10px;
    }

    .rate:not(:checked)>input {
      position: absolute;
      left: -9999px;
    }

    .rate:not(:checked)>label {
      float: right;
      width: 1em;
      overflow: hidden;
      white-space: nowrap;
      cursor: pointer;
      font-size: 30px;
      color: #ccc;
    }

    .rate:not(:checked)>label:before {
      content: '★ ';
    }

    .rate>input:checked~label {
      color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
      color: #deb217;
    }

    .rate>input:not(:checked):disabled+label:hover,
    .rate>input:not(:checked):disabled+label:hover~label,
    .rate>input:not(:checked):disabled~label:hover,
    .rate>input:not(:checked):disabled~label:hover~label,
    .rate>label:hover~input:not(:checked):disabled~label {
      color: #ccc;
      cursor: default;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
      color: #c59b08;
    }

    .rate>input:checked:disabled+label:hover,
    .rate>input:checked:disabled+label:hover~label,
    .rate>input:checked:disabled~label:hover,
    .rate>input:checked:disabled~label:hover~label,
    .rate>label:hover~input:checked:disabled~label {
      color: #ffc700;
      cursor: default;
    }

    .rate>input:disabled {
      cursor: default;
    }
  </style>

</head>

<body>
  <div class="page-dashboard">
    <div class="d-flex" id="wrapper" data-aos="fade-right">
      <!-- Sidebar -->
      <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-center">
          <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/skripsi/logo-new-1.svg" alt="Logo" class="my-4" />
          </a>
        </div>
        <div class="list-group list-group-flush">
          <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard')) ?'active' : '' }}">
            Dashboard
          </a>
          <a @if (Auth::user()->store_status == 1)
            href="{{ route ('dashboard-product') }}"
            class="list-group-item list-group-item-action {{ (request()->is('dashboard/products*')) ?'active' : '' }}"
            disabled
            >
            My Products
            @endif
          </a>
          <a href="{{ route ('dashboard-transaction') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/transactions*')) ?'active' : '' }}">
            Transactions
          </a>
          <a href="{{ route('dashboard-settings-account') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/account*')) ?'active' : '' }}">
            My Account
          </a>
          <a href="{{ route('dashboard-settings-profile') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/profile*')) ?'active' : '' }}">
            Profile Picture
          </a>
          <a href="{{ route('dashboard-settings-store') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/settings*')) ?'active' : '' }}">
            Store Settings
          </a>
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action">
            Sign Out
          </a>
        </div>
      </div>

      <!-- Page Content -->
      <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
          <div class="container-fluid">
            <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
              &laquo; Menu
            </button>
            <button class="navbar-toggler" typer="button" data-toggle="collapse" data-target="#navbarSupportedContent">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Dekstop Menu-->
              <ul class="navbar-nav d-none d-lg-flex ml-auto">
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <img src="{{ Storage::url(Auth::user()->photos) }}" alt="" class="rounded-circle mr-2 profile-picture" />
                    Hi, {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu">
                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                    <div class="dropdown-devider">
                      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                        Logout
                      </a>
                      <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none">
                        @csrf
                      </form>
                    </div>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                    @php
                    $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                    @endphp
                    @if ($carts > 0 )
                    <img src="/images/icon-cart-filled.svg" alt="" />
                    <div class="card-badge" style="background-color: #FF7878"> {{ $carts }}</div>
                    @else
                    <img src="/images/icon-cart-empty.svg" alt="" />
                    @endif
                  </a>
                </li>
              </ul>

              <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                  <a href="#" class="nav-link"> Hi, {{ Auth::user()->name }} </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link d-inline-block"> Cart </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        {{-- Content --}}
        @yield('content')

      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  @stack('prpend-script')
  <script src="/vendor/jquery/jquery.slim.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  @stack('addon-script')
</body>

</html>