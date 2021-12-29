<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>@yield('title')</title>

  {{-- Style --}}
  @stack('prpend-style')
  @include('includes.style')
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
  {{-- Navbar --}}
  @include('includes.navbar')

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