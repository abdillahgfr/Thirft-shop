<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prpend-style')
    @include('includes.style')
    @stack('addon-style')

  </head>

  <body>
    @include('includes.navbar-verify')

    <div class="page-dashboard">
      <div class="d-flex" id="wrapper" data-aos="fade-right">
        
        <!-- Page Content -->
      </div>
    </div>
    {{-- Footer --}}
    @include('includes.footer')

    <!-- Script -->
    @stack('prpend-script')
    @include('includes.script')
    @stack('addon-script') 
  </body>
</html>
