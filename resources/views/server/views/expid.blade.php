@extends('server.layout.template')
@section('content')
<div class="uk-width-large-4-5 uk-width-medium-1-1" control="webApp">
  <div class="uk-grid">
    <div class="uk-width-large-1-1 uk-width-medium-1-1">
      <br>
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">Table Ekspresi</h3>
        <table class="uk-table" id="exptable" data-url="{{url('request/resapp/expression/getid')}}">
          <thead>
            <tr>
              @foreach($header as $item)
                <th>{{$item}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
          @foreach($extract as $item)
            <tr>
              @for($x=1; $x < count($item); $x++)
                <td>{{$item[$x]}}</td>
              @endfor
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@push('styles')
<link rel="stylesheet" href="{{asset('res/css/jquery.gritter.css')}}">
<style>
  table#exptable tbody tr{
    cursor: pointer;
  }
</style>
@endpush
@push('script')
  <script src="{{asset('res/js/heavenjs-alpha.js')}}"></script>
  <script src="{{asset('res/js/jquery.gritter.min.js')}}"></script>
  <script>
    var web = new heavenJS({control:'webApp'});
    web.modules(['forEach']);
  </script>
@endpush
@stop