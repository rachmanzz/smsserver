@extends('server.layout.template')
@section('content')
<div class="uk-width-large-4-5 uk-width-medium-1-1" control="webApp">
  <div class="uk-grid">
    <div class="uk-width-large-1-1 uk-width-medium-1-1">
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">Reguler Ekspresi</h3>
        <form class="uk-form" id="expForm" method="post" action="{{url('request/resapp/expression/insert')}}">
          <div class="uk-form-row">
            <input class="uk-width-1-1" name="expname" placeholder="nama expresi">
          </div>
          <div class="uk-form-row">
            <textarea name="values" class="uk-width-1-1" rows="5" placeholder="buat expresi sms anda disini"></textarea>
             **variable = <code>@{{variable}}</code>
          </div>
        </form>
        <div class="uk-width-1-1">
          <button class="uk-button uk-align-right" onclick="expressionsubmit()">Simpan</button>
        </div>
      </div>
    </div>
    <div class="uk-width-large-1-1 uk-width-medium-1-1">
      <br>
      <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <h3 class="uk-panel-title">Table Ekspresi</h3>
        <table class="uk-table" id="exptable" data-url="{{url('request/resapp/expression/getid')}}">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Paramenter</th>
              <th>Expresi</th>
            </tr>
          </thead>
          <tbody forEach="expression.post[{{url('request/resapp/expression/get')}}]">
            <tr data-id="([id])">
              <td>([num++])</td>
              <td>([expname])</td>
              <td>([expname])</td>
              <td>([values])</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div id="expencode" class="uk-modal">
  <div class="uk-modal-dialog">
    <div class="uk-modal-header">execute expression</div>
    <form class="uk-form uk-form-horizontal" id="formEncode" method="post" action="{{url('request/resapp/expression/execute')}}">
      <input type="hidden" name="id" id="expID">
      <div id="explist">
        <div class="uk-form-row">
          <label class="uk-form-label"></label>
          <div class="uk-form-controls">
            <select class="uk-width-2-4" name="expression[]">
              <option value="a-z">a-z</option>
              <option value="a-Z">a-Z</option>
              <option value="a-Z:Space">a-Z (space)</option>
              <option value="0-9">0-9</option>
              <option value="0-9a-Z">0-9 | a-Z </option>
              <option value="0-9a-Z:Space">0-9 | a-Z (space)</option>
            </select>
            <input class="uk-width-1-4" name="lenght[]" placeholder="lenght">
          </div>
        </div>
      </div>
    </form>
    <div class="uk-modal-footer">
      <button class="uk-button uk-button-primary" onclick="executeExp()">Exekusi Perintah</button>
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
    var expressionsubmit = function () {
      $('form#expForm').submit();
    };
    $('form#expForm').submit(function () {
      $('form#expForm').formSubmit(function (result,status) {
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
      return false;
    });
    var web = new heavenJS({control:'webApp'});
    web.modules(['forEach']);
    var modal = UIkit.modal("#expencode");
    $('body table#exptable tbody').on('click','tr',function () {
      var expID = $(this).attr('data-id');
      var formEncode=$('#formEncode');
      formEncode.find('#expID').val(expID);
      var formHtml = formEncode.find('#explist').html();
      formEncode.find('#explist').html('');
      $.ajax({
        url:$(this).parents('table').attr('data-url'),
        type:'POST',
        dataType :'json',
        data:{id:$(this).attr('data-id')},
        success: function(result,status,xhr){
          var expression =result.values.match(/\{\{([0-9a-zA-Z\\s]+)\}\}/gi);
          $.each(expression,function (i,val) {
            formEncode.find('#explist').append(formHtml);
            formEncode.find('#explist').find('.uk-form-label:last').text(val.match(/\{\{([0-9a-zA-Z\\s]+)\}\}/)[1]);
          });
          modal.show();
        },
        error: function(xhr,status,error){

        }
      });
    });
    var executeExp = function () {
      $('#formEncode').submit();
    };
    $('#formEncode').submit(function () {
      $('#formEncode').formSubmit(function (result,status) {
        modal.hide();
      });
      return false;
    });
  </script>
@endpush
@stop