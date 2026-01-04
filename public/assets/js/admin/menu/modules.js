$(document).ready(function() {
    getData();
});


function getData()
{
    $('#datatables-reponsive').DataTable({
        processing: true,
        serverSide: true,
        ajax: "menu",
        columns: [
            { "data": "modulename" },
            { "data": "url" },
            { "data": "orderby" },
            { "data": "action" },
        ],
    });
}

$(document).off('click','#addData',function(){});
$(document).on('click','#addData',function(e){
    e.preventDefault();
    $('#formModal').modal('show');
    $('.form').attr('id','dataForm');
    $('#dataForm')[0].reset();
    $('#btnSubmit').show();
    $('#btnUpdate').hide();
})


$(document).off('submit','#dataForm',function(){});
$(document).on('submit','#dataForm',function(e){
    e.preventDefault();
    let dataurl=$('#dataForm').attr('action');
    let postdata=$('#dataForm').serialize();
    var request = ajaxRequest(dataurl,postdata);
		request.done(function (res) {
			if(res.status ===true)
            {
                showNotification(res.message,'success');
                $('#formModal').modal('hide');
                $('#dataForm')[0].reset();
                $('#datatables-reponsive').dataTable().fnClearTable();
                $('#datatables-reponsive').dataTable().fnDestroy();
                getData();

			}else
            {
                showNotification(res.message,'error')
			}
		});
})

$(document).off('click','.editData',function(){});
$(document).on('click','.editData',function(e){
    e.preventDefault();
    let id=$(this).attr('data-pid');
    let dataurl=$(this).attr('data-url');
    var request = getRequest(dataurl);
		request.done(function (res) {
            if(res.status===true)
            {
                $('#btnSubmit').hide();
                $('#btnUpdate').show();
                $('.form').attr('id','updatedataForm');
                $('#formModal').modal('show');
                $('#modulename').val(res.response.modulename);
                $('#parentmoduleid').val(res.response.parentmoduleid);
                $('#url').val(res.response.url);
                $('#icon').val(res.response.icon);
                $('#orderby').val(res.response.orderby);
                $('#modulename').val(res.response.modulename);
                $('#id').val(res.response.id);

            }
            else
            {
                showNotification(res.message,'error')

            }
			
		});
})

$(document).off('submit','#updatedataForm',function(){});
$(document).on('submit','#updatedataForm',function(e){
    e.preventDefault();
    let id=$('#id').val();
    let dataurl='menu/'+id;
    let postdata=$('#updatedataForm').serialize();
    var request = ajaxRequest(dataurl,postdata,'PUT');
		request.done(function (res) {
			if(res.status ===true)
            {
                 showNotification(res.message,'success');
                 $('#formModal').modal('hide');
                 $('#updatedataForm')[0].reset();
                 $('#datatables-reponsive').dataTable().fnClearTable();
                 $('#datatables-reponsive').dataTable().fnDestroy();
                 getData();

			}else
            {
                showNotification(res.message,'error')
			}
		});
})

$(document).off('click','.deleteData',function(){});
$(document).on('click','.deleteData',function(e){
    e.preventDefault();
    let currbtn=$(this);
    let dataurl=currbtn.attr('data-url');
    let token=$("input[name='_token']").val();
    var request = ajaxRequest(dataurl,{_token:token},'DELETE');
		request.done(function (res) {
            if(res.status===true)
            {
             //   currbtn.closest("tr").remove();
                showNotification(res.message,'success')
                $('#datatables-reponsive').dataTable().fnClearTable();
                $('#datatables-reponsive').dataTable().fnDestroy();
                getData();

            }
            else
            {
                showNotification(res.message,'error')

            }
			
		});
})
