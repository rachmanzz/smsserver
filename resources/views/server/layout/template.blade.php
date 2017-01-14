<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('uikit/css/uikit.min.css')}}">
  <link rel="stylesheet" href="{{asset('uikit/css/uikit.almost-flat.min.css')}}">
  @stack('styles')
</head>
<body>
<nav class="uk-navbar">
  <a href="#sidebarOfCanvas" data-uk-offcanvas="{target:'#sidebarOfCanvas'}" class="uk-navbar-toggle"></a>
  <a href="" class="uk-navbar-brand">SMS Server</a>
</nav>
<div class="uk-container uk-container-center" style="margin-top: 30px; margin-bottom: 30px">
<div class="uk-grid">
  @include('server.layout.sidebar')
  @yield('content')
</div>
</div>
<script src="{{asset('res/js/jquery-3.0.0.min.js')}}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<script src="{{asset('uikit/js/uikit.min.js')}}"></script>
<script src="{{asset('res/js/server-res.js')}}"></script>
@stack('script')
</body>
</html>