/**
 * Created by rachman on 29/06/2016.
 */
var server_dataSelected=[], select_action=false,multi_serveData=false;

$('button[server-data-action]').click(function () {
    var table_id='';
    var table_server= $('table[server-data-table="'+table_id+'"]').find('tbody > tr');
    var action=$(this).attr('server-data-action');
    if($(this).is('[table-id]')){
        table_id=$(this).attr('table-id');
    }
    if(action=='#select'){
        $(this).text('Batal');
        $(this).attr('server-data-action','#deselect');
        $(this).next().attr('disabled',false);
        $(this).next().next().attr('disabled',false);
        table_server.css('cursor','pointer');
        select_action=true;

    }
    if(action=='#deselect'){
        $(this).text('Pilih');
        $(this).attr('server-data-action','#select');
        $(this).next().attr('disabled',true);
        $(this).next().next().attr('disabled',true);
        table_server.css('cursor','default');
        if(table_server.is('[server-data-selected]')){
            table_server.removeAttr('server-data-selected');
            table_server.css('background','');
        }
        select_action=false;
    }
    if(action=='#delete'){
        $('table[server-data-table="'+table_id+'"]').find('tbody > tr[server-data-selected="true"]').each(function () {
            console.log($(this).attr('data-id'));
        });
    }
});
$('table[server-data-table]').on('click','tbody > tr',function () {
    if(multi_serveData == false && select_action==true){
        if($(this).is('[server-data-selected]')){
            $(this).removeAttr('server-data-selected');
            $(this).css('background','');
        }else{
            $(this).attr('server-data-selected',true);
            $(this).css('background','#b3dced');
        }
    }
});
$.fn.formSubmit = function (callback) {
    $.ajax({
        url:$(this).attr('action'),
        type:$(this).attr('method').toUpperCase(),
        dataType :typeof $(this).attr('data-type') != 'undefined' ? $(this).attr('data-type'):'json',
        data:$(this).serializeArray(),
        success: function(result,status,xhr){
            return typeof callback != "undefined" ? callback(result,status,xhr) : '';
        },
        error: function(xhr,status,error){
            return typeof callback != "undefined" ? callback(error,status,xhr) : '';
        }
    });
    return false;
};