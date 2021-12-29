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

    {{-- Style --}}
    @stack('prpend-style')
    @include('includes.style')
    @stack('addon-style')

  </head>

  <body>
    <div class="alert alert-danger mb-n1 text-center" role="alert">
        Anda belum verifikasi email, silahkan verifikasi terlebih dahulu.
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Verifikasi Ulang</button>.
        </form>
    </div>
    <div class="container">
      <div class="row justify-content-center mt-lg-5">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
      </div>
    </div>
    {{-- Page Content --}}
    @yield('content') 

    {{-- Footer --}}
    @include('includes.footer')

    {{-- Script --}} 
    @stack('prpend-script')
    @include('includes.script')
    @stack('addon-script')   
</body>
</html> 
