<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down">
    
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
              <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories') }}" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('about') }}" class="nav-link">About</a>
            </li>
          </ul>

          <!-- Dekstop Menu-->
            <ul class="navbar-nav d-none d-lg-flex">
              <li class="nav-item dropdown">
                <a
                  href="#"
                  class="nav-link"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                >
                  <img
                    src="{{ Storage::url(Auth::user()->photos) }}"
                    alt=""
                    class="rounded-circle profile-picture"
                  />
                  Hi, {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu">
                  <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                  <div class="dropdown-devider"></div>
                  <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
              </li>
              <li>
                <li class="nav-item">
                  <a href="#" class="nav-link d-inline-block mt-2">
                    <img src="/images/icon-cart-empty.svg" alt="" />
                  </a>
                </li>
              </li>
            </ul>

            <ul class="navbar-nav d-block d-lg-none">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  Hi, {{ Auth::user()->name }}
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                  Cart
                </a>
              </li>
            </ul>
        </div>
      </div>
    </nav>