@extends('server.layout.template')
@section('content')
<div class="uk-width-medium-4-5" control="webApp">
  <div class="uk-grid">
    <div class="uk-width-medium-2-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">KATEGORI</h3>
        <div class="uk-button-group uk-align-right">
          <button server-data-action="#select" class="uk-button">Pilih</button>
          <button server-data-action="#edit" class="uk-button" disabled>Ubah</button>
          <button server-data-action="#delete" class="uk-button" disabled>Hapus</button>
        </div>
        <br>
        <h3>Terkait kontak</h3>
        <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed" server-data-table="">
          <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th class="uk-text-right">Jumlah Kontak</th>
          </tr>
          </thead>
          <tbody forEach="category.post[{{url('request/resapp/category/get')}}]">
          <tr>
            <td>([ num++ ])</td>
            <td>([name])</td>
            <td class="uk-text-right">([ contact ])</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="uk-width-medium-1-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">TAMBAH KATEGORI</h3>
        <form class="uk-form" method="post" action="{{url('request/resapp/category/insert')}}">
          <div class="uk-form-row">
            <input type="text" name="name" class="uk-width-1-1" placeholder="Nama">
          </div>
          <div class="uk-form-row">
            <input type="submit" class="uk-width-1-1 uk-button" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@push('styles')
<link rel="stylesheet" href="{{asset('res/css/jquery.gritter.css')}}">
@endpush
@push('script')
<script src="{{asset('res/js/jquery.gritter.min.js')}}"></script>
<script src="{{asset('res/js/heavenjs-alpha.js')}}"></script>
<script>
  $('form').submit(function () {
    UIkit.modal.confirm('Are you sure?',function () {
      $('form').formSubmit(function (result,status) {
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
  var web = new heavenJS({control:'webApp'});
  web.modules(['forEach']);
</script>
@endpush
@stop