<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title', config('app.name'))</title>
  
  
  <link rel="stylesheet" href="{{ asset('css/font.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('icons/css/all.min.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/logo_matgar.png') }}" type="image/x-icon" />
  @yield('style')
 
</head>
<body>
  @include('layouts.partials.header')
  
  <main>
    <style>
      .alert {
        border-radius:12px; 
        padding:10px 12px;
        position:fixed;
        top: 10px;
        right: 5px;
        width: fit-content;
        z-index: 200;
      }
.alert-success {
    color: #0f5132;
    background: #d1e7ddd4;
    border: 1px solid #badbccc7;
    padding: 15px 25px;
    border-radius: 20px;
    position: fixed;
    left: 42%;
    z-index: 9999;
    font-family: Arial, sans-serif;
    box-shadow: -3px 13px 8px rgba(0, 0, 0, 0.1);
    height: 50px;
    transform: translateY(171px);
    opacity: 1;
    animation: fadeOutAlert 2s ease-in forwards;
    animation-delay: 2s; /* WAIT 2 seconds THEN fade */
}

  @keyframes fadeOutAlert {
      from { opacity: 1; }
      to   { opacity: 0; visibility: hidden; }
  }



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
  </main>
  @include('layouts.partials.footer')
  <script src="{{ asset('js/jquery.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
</body>
</html>
