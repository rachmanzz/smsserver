@extends('server.layout.template')
@section('content')
<div class="uk-width-large-4-5 uk-width-medium-1-1" control="webApp">
  <div class="uk-grid">
    <div class="uk-width-large-2-3 uk-width-medium-2-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">KONTAK</h3>
        <button server-data-action="#delete" class="uk-button uk-align-right">Segarkan</button>
        <div class="uk-button-group uk-align-right">
          <button server-data-action="#select" class="uk-button">Pilih</button>
          <button server-data-action="#edit" class="uk-button" disabled>Ubah</button>
          <button server-data-action="#delete" class="uk-button" disabled>Hapus</button>
        </div>
        <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed" server-data-table="">
          <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>No Hp</th>
            <th>Total Pesan</th>
          </tr>
          </thead>
          <tbody forEach="contact.post[{{url('request/resapp/contact/get')}}]">
          <tr data-id="([ id ])">
            <td>([ num++ ])</td>
            <td>([ name ])</td>
            <td>([ phone ])</td>
            <td></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="uk-width-large-1-3 uk-width-medium-1-3">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">TAMBAH KONTAK</h3>
        <form class="uk-form" method="post" action="{{url('request/resapp/contact/insert')}}">
          <div class="uk-form-row">
            <input type="text" name="name" class="uk-width-1-1" placeholder="Nama">
          </div>
          <div class="uk-form-row">
            <input type="text" name="phone" class="uk-width-1-1" placeholder="No. HP">
          </div>
          <div class="uk-form-row">
            <select name="category" class="uk-width-1-1">
              <option value="0"></option>
              @foreach($category as $item)
                <option value="{{$item->category_id}}">{{$item->name}}</option>
              @endforeach
            </select>
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