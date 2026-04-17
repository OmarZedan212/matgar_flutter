<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name'))</title>
  <link rel="stylesheet" href="{{ asset('icons/css/all.min.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/logo_matgar.png') }}" type="image/x-icon" />
  {{-- Global minimal reset + bg animation; page can add more via @push('head') --}}
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family: "Segoe UI", sans-serif; }
    html, body { min-height:100%; }
    html, body { animation: gradient-rotate 10s linear infinite; }
    body { display:flex; justify-content:center; align-items:center; min-height:100vh; overflow:hidden; }
    @keyframes gradient-rotate {
      0%   { background: linear-gradient(0deg, #1c3158, #80bbd1); }
      100% { background: linear-gradient(360deg, #1c3158, #80bbd1); }
    }
  </style>

  @stack('head')
</head>
<body>
<style>
      .alert {
        border-radius:12px; 
        position:fixed;
        padding:10px 12px;
        top: 5px;
        right: 5px;
        width: fit-content;
        z-index: 200;
      }
      .alert-success { color:#0f5132; background:#d1e7dd; border:1px solid #badbcc; }
      .alert-danger  { color:#842029; background:#f8d7da; border:1px solid #f5c2c7; }
    </style>
    @if (session('status'))
      <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <ul style="padding-left:18px;">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  @yield('content')
  @stack('scripts')
</body>
</html>
