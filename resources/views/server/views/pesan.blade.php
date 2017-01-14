@extends('server.layout.template')
@section('content')
<div class="uk-width-large-4-5 uk-width-medium-1-1" control="webApp">
  <div class="uk-grid">
    <div class="uk-width-large-2-3 uk-width-medium-2-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">PESAN MASUK</h3>
        <div class="uk-button-group uk-align-left">
          <button  class="uk-button" data-uk-modal="{target:'#kpesan'}">Pesan</button>
          <button  class="uk-button" data-uk-modal="{target:'#kpesanmasal'}">Pesan Masal</button>
        </div>
        <div class="uk-button-group uk-align-right">
          <button server-data-action="#select" class="uk-button">Pilih</button>
          <button server-data-action="#edit" class="uk-button" disabled>Ubah</button>
          <button server-data-action="#delete" class="uk-button" disabled>Hapus</button>
        </div>
        <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed" server-data-table="">
          <tbody forEach="category.post[{{url('request/resapp/messages/get')}}]" sync-timing="2000">
          <tr>
            <td>
              <h4>([ sender ])</h4>
              <p>([ text ])</p>
            </td>
            <td class="uk-text-bottom uk-text-right"><h6>([date])</h6><h6>([time])</h6></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="uk-width-large-1-3 uk-width-medium-1-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">TETAPKAN NO. UTAMA</h3>
        <form class="uk-form">
          <div class="uk-form-row">
            <select class="uk-width-1-1" name="selectphone">
              <option>AUTO</option>
              <option>PHONE ID</option>
            </select>
          </div>
          <div class="uk-form-row">
            <input type="submit" class="uk-width-1-1 uk-button" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="kpesan" class="uk-modal">
    <div class="uk-modal-dialog">
      <a class="uk-modal-close uk-close"></a>
      <form method="post" class="uk-form" action="{{url('request/resapp/messages/send')}}">
        <div class="uk-form-row">
            <input type="text" id="kontak" class="uk-width-1-1 autocomplete-suggestion" name="kontak" placeholder="kontak" data-url="{{url('request/resapp/messages/getcontact')}}">
        </div>
        <div class="uk-form-row">
          <textarea class="uk-width-1-1" rows="4" placeholder="pesan" name="text"></textarea>
        </div>
        <div class="uk-form-row">
          <input type="submit" class="uk-width-1-4 uk-button uk-button-primary uk-align-right">
        </div>
      </form>
    </div>
  </div>
  <div id="kpesanmasal" class="uk-modal">
    <div class="uk-modal-dialog">
      <a class="uk-modal-close uk-close"></a>
      <form class="uk-form">
        <div class="uk-form-row">
          <input class="uk-width-1-1" placeholder="kategori">
        </div>
        <div class="uk-form-row">
          <textarea class="uk-width-1-1" rows="4" placeholder="pesan"></textarea>
        </div>
        <div class="uk-form-row">
          <input type="submit" class="uk-width-1-4 uk-button uk-button-primary uk-align-right">
        </div>
      </form>
    </div>
  </div>
</div>
@push('styles')
<link rel="stylesheet" href="{{asset('res/css/jquery.gritter.css')}}">
<style>
  .autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
  .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
  .autocomplete-no-suggestion { padding: 2px 5px;}
  .autocomplete-selected { background: #F0F0F0; }
  .autocomplete-suggestions strong { font-weight: bold; color: #000; }
  .autocomplete-group { padding: 2px 5px; }
  .autocomplete-group strong { font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }
</style>
@endpush
@push('script')
<script src="{{asset('res/js/jquery.gritter.min.js')}}"></script>
<script src="{{asset('res/js/heavenjs-alpha.js')}}"></script>
<script src="{{asset('res/js/jquery.autocomplete.min.js')}}"></script>
<script>
  var web = new heavenJS({control:'webApp'});
  web.modules(['forEach']);
  $('#kontak').autocomplete({
    serviceUrl: $('#kontak').attr('data-url'),
    type : 'POST'
  });
  $('#kpesan form').submit(function () {
    UIkit.modal.confirm('Are you sure?',function () {
      $('#kpesan form').formSubmit(function (result,status) {
        if(status == 'success' && result.status == 'success'){
          $.gritter.add({
            title : 'form submit',
            text : 'data telah disimpan'
          });
        }
        else if(status == 'success' && result.status=='error'){
          $.each(result.error,function (i,result) {
            $.each(result,function (i,result) {
              $.gritter.add({
                title : 'form submit',
                text : result
              });
            });
          });
        }
      });
    },{labels:{
      Ok  : 'Simpan', Cancel : 'Batal'
    }});
    return false;
  });
</script>
@endpush
@stop