<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down"
    >
      <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
          <img src="/images/skripsi/logo-new-1.svg" alt="Logo" />
        </a>
        <button
          class="navbar-toggler"
          typer="button"
          data-toggle="collapse"
          data-target="#navbarResponsive"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="{{ route('home') }}"  class="nav-link {{ (request()->is('home*')) ?'active' : '' }}">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories') }}" class="nav-link {{ (request()->is('categories*')) ?'active' : '' }}">Categories</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('about') }}" class="nav-link {{ (request()->is('about*')) ?'active' : '' }}">About</a>
            </li>
            @guest
              <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
            </li>
            <li class="nav-item">
              <a
                href="{{ route('login') }}"
                class="btn btn-default nav-link px-4 text-white"
                style="background-color: #F0B76E"
                >Sign In</a
              >
            </li>
            @endguest
          </ul>

          @auth
          <!--Dekstop Menu -->
            <ul class="navbar-nav d-none d-lg-flex">
              <li class="nav-item dropdown">
                <div class="dropdown">
                  <a class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    
                  href="#"
                  class="nav-link"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                >
                  <img
                    src="{{ Storage::url(Auth::user()->photos ?? '') }}"
                    alt=""
                    class="rounded-circle mr-2 profile-picture"
                  />
                  Hi, {{ Auth::user()->name }}
                </a>
                  </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                  <div class="dropdown-devider"></div>
                      <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();" 
                      class="dropdown-item">
                      Logout
                      </a>
                      <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none">
                        @csrf    
                    </form>
                </div>
              </li>
              <li class="nav-item">
                <a href="{{ route('comment') }}" class="nav-link d-inline-block mt-2">
                  @if(count($comments) > 0)
                    <img src="/images/msg1.svg" alt="" />
                    <div class="card-badge" style="background-color: #FF7878"> {{ count($comments) }}</div>
                  @else
                    <img src="/images/msg1.svg" alt="" />
                  @endif
                </a>
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
                    <img src="/images/icon-cart-filled.svg" alt="" />
                  @endif
                </a>
              </li>
            </ul>
             <ul class="navbar-nav d-block d-lg-none">
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  Hi, {{ Auth::user()->name }}
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ route('comment') }}" class="nav-link d-inline-block">
                  Comment
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                  Cart
                </a>
              </li>
            </ul>
        </div>
          @endauth
        </div>
      </div>
    </nav>