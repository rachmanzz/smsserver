<div id="sidebarOfCanvas" class=" uk-width-large-1-5 uk-height-viewport uk-visible-large" style="border-right: 1px #999 solid;">
  <ul class="uk-nav uk-nav-side uk-nav-parent-icon data-uk-nav" id="sidebar" data-uk-nav request-url="{{Request::url()}}">
    <li class="uk-nav-header">Menu Utama</li>
    <li><a href="{{url('request/sms/controlserver')}}">Dashboard</a></li>
    <li class="uk-parent"><a href="#">Kontak</a>
      <ul class="uk-nav-sub">
        <li><a href="{{url('request/sms/controlserver/contact')}}">Kontak</a></li>
        <li><a href="{{url('request/sms/controlserver/category')}}">Kategori</a></li>
      </ul>
    </li>
    <li>
      <a href="{{url('request/sms/controlserver/pesan')}}">Pesan</a>
    </li>
    <li class="uk-parent"><a href="#">Reguler Expresi</a>
      <ul class="uk-nav-sub">
        <li><a href="{{url('request/sms/controlserver/expression')}}">Expresi Pesan</a></li>
        <li><a href="{{url('request/sms/controlserver/expression-database')}}">DataBase</a></li>
      </ul>
    </li>
    <li class="uk-nav-divider"></li>
    <li class="uk-nav-header">Phone Setting</li>
  </ul>
</div>
@push('script')
  <script>
    var current_url = $('#sidebar').attr('request-url');
    $('#sidebar li').find('a[href="'+current_url+'"]').parents('li').addClass('uk-active');
    if($('#sidebar li ul').find('li').hasClass('uk-active')){
      $('#sidebar li ul').find('li[class="uk-active"]').addClass('uk-open');
    }
  </script>
@endpush