<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('uikit/css/uikit.min.css')}}">
  <link rel="stylesheet" href="{{asset('uikit/css/uikit.almost-flat.min.css')}}">
  <link rel="stylesheet" href="{{asset('res/css/jquery.gritter.css')}}">
</head>
<body>
<div class="uk-container uk-container-center uk-width-1-3 uk-grid-margin uk-margin-large-top" w-href="{{url('request/sms/controlserver')}}">
  <form class="uk-form" method="post" action="{{url('request/resapp/login')}}">
    <fieldset>
      <legend>Login</legend>
      <div class="uk-form-row">
        <input class="uk-width-1-1" placeholder="your email" name="email" type="text">
      </div>
      <div class="uk-form-row">
        <input class="uk-width-1-1" placeholder="your password" name="password" type="password">
      </div>
      <div class="uk-form-row">
        <input class="uk-button uk-button-primary uk-align-right uk-width-1-3" type="submit" value="Login">
      </div>
    </fieldset>
  </form>
</div>
<script src="{{asset('res/js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('uikit/js/uikit.min.js')}}"></script>
<script src="{{asset('res/js/server-res.js')}}"></script>
<script src="{{asset('res/js/jquery.gritter.min.js')}}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('form').submit(function () {
    $(this).formSubmit(function (result,status) {
      if(status=='success' && result.status=='success'){
        $.gritter.add({
          title : 'login',
          text  : 'login berhasil'
        });
        window.location =$('.uk-container[w-href]').attr('w-href');
      }
      else if(status=='success' && result.status=='failed'){
        $.gritter.add({
          title : 'login',
          text  : 'login gagal, email / password salah, atau tidak dikenali'
        });
      }
      else{
        $.gritter.add({
          title : 'login',
          text  : 'login gagal, terjadi kesalahan pada system'
        });
      }
    });
    return false;
  });
</script>
</body>
</html>