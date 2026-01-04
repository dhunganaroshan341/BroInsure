$(document).on('click','.permission_chk',function(e){
    let module_usertype=$(this).val();
    let checked='N';
    if($(this).prop('checked')===true)
    {
        checked='Y';
    }
   
  
    setpermission(module_usertype,checked);

})
$(document).on('click','.permission_all',function(e){
    let usertype=$(this).val();
    let checked_sec = false;
    let checked='N';
    if($(this).prop('checked')===true)
    {
        checked_sec = true;
        checked='Y';
    }
    var elements = $('.permission_chk[data-usertypeIds="'+usertype+'"]').prop('checked', checked_sec);
    var moduleIdsArray = $('.permission_chk[data-usertypeIds="' + usertype + '"]').map(function() {
        return $(this).data('moduleids');
    }).get();

    let dataurl='storeAllPermission';
    let token=$("input[name='_token']").val();
    var request = ajaxRequest(dataurl,{usertype,moduleIdsArray,_token:token,checked:checked});
    request.done(function (res) {
        if(res.status===true)
        {
            showNotification(res.message,'success')
           

        }
        else
        {
            showNotification(res.message,'error')

        }
        
    });

})

function setpermission(module_usertype,checked)
{
    let dataurl='permission';
    let token=$("input[name='_token']").val();

    var request = ajaxRequest(dataurl,{module_usertype,_token:token,checked:checked});
		request.done(function (res) {
            if(res.status===true)
            {
                showNotification(res.message,'success')
               

            }
            else
            {
                showNotification(res.message,'error')

            }
			
		});
}

$(document).on('change','#parentmenu',function(e){
    e.preventDefault();
    let menuid=$(this).val();
    let dataurl='permission/getSubmenuData';
    let token=$("input[name='_token']").val();
    var request = ajaxRequest(dataurl,{menuid:menuid,_token:token},'POST');
		request.done(function (res) {
            $('.table-body').empty();
            $('.table-body').html(res.response);
			
		});
})
