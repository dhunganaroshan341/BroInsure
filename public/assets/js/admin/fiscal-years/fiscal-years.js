
$(document).ready(function() {

    getData();
});


function getData()
{

    $('#datatables-reponsive').DataTable({
        processing: true,
        serverSide: true,
        ajax: "fiscal-years",
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: 'CSV',exportOptions : {
                    columns: [0,1]
                },
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Excel',exportOptions : {
                    columns: [0,1]
                },
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Print',exportOptions : {
                    columns: [0,1]
                },
            },

        ],

        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { "data": "name" },
            { "data": "start_date" },
            { "data": "end_date" },
            { "data": "status" },
            { "data": "isActive" },
            { "data": "action" },
        ],
    });
}

$(document).off('click','#addData',function(){});
$(document).on('click','#addData',function(e){
    e.preventDefault();
    $('#FormModal').modal('show');
    $('.modal-title').html('Add Fiscal Year');
    $('.form').attr('id','dataForm');
    $('#dataForm')[0].reset();
    $('#btnSubmit').show();
    $('#btnUpdate').hide();
})


$(document).off('submit','#dataForm',function(){});
$(document).on('submit','#dataForm',function(e){
    e.preventDefault();
    let dataurl=$('#dataForm').attr('action');
    let postdata=new FormData(this);

    var request = ajaxRequest(dataurl,postdata,'POST',true);
		request.done(function (res) {
			if(res.status ===true)
            {
                showNotification(res.message,'success');
                $('#FormModal').modal('hide');
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
    $('.modal-title').html('Edit Fiscal Year');
    let dataurl=$(this).attr('data-url');
    var request = getRequest(dataurl);
		request.done(function (res) {
            if(res.status===true)
            {
                $('#btnSubmit').hide();
                $('#btnUpdate').show();
                $('.form').attr('id','updatedataForm');
                $('#FormModal').modal('show');
                $('#name').val(res.response.name);
                $('#start_date').val(res.response.start_date);
                $('#end_date').val(res.response.end_date);
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
    let dataurl='fiscal-years/'+id;
    let postdata=$('#updatedataForm').serialize();
    var request = ajaxRequest(dataurl,postdata,'PUT');
		request.done(function (res) {
			if(res.status ===true)
            {
                 showNotification(res.message,'success');
                 $('#FormModal').modal('hide');
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
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
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
    } else {
        swal("Your Data Is Safe!");
    }
});
})

$(document).on('change','.is_active_checkbox',function(e){
    let is_checked=!$(this).prop('checked');
    let id = $(this).val()
    $(this).prop('checked', is_checked)
    swal({
        title: "Are you sure?",
        text: "If you make this active, the one currently active will be disabled",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            let currbtn = $(this);
            let dataurl = "/admin/fiscal-years/" + id + "/status";
            let token = $("input[name='_token']").val();
            var request = ajaxRequest(dataurl, { _token: token, status: is_checked ? 'N' : 'Y' }, 'PATCH');
            request.done(function (res) {
                if (res.status === true) {
                    //   currbtn.closest("tr").remove();
                    showNotification(res.message, 'success')
                    $('#datatables-reponsive').dataTable().fnClearTable();
                    $('#datatables-reponsive').dataTable().fnDestroy();
                    getData();

                }
                else {
                    showNotification(res.message, 'error')
                }

            });
        } else {
            swal("Your Data Is Safe!");
        }
    });

    // setpermission(formname,checked);

})
