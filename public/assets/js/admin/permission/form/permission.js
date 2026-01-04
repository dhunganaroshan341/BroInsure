$(document).on('change','#formmenu',function(e){
    e.preventDefault();
    let usergroupid=$(this).val();
    let dataurl='getUsergroupWiseFormMenuData';
    let token=$("input[name='_token']").val();
    var request = ajaxRequest(dataurl,{usergroupid:usergroupid,_token:token},'POST');
		request.done(function (res) {
            $('.table-body').empty();
            $('.table-body').html(res.response);

		});
})

$(document).on('click','.permission_chk',function(e){
      let formname=$(this).val();
      let checked='N';
      if($(this).prop('checked')===true)
      {
          checked='Y';
      }

      setpermission(formname,checked);

  })

  $(document).on('click','.create_all,.edit_all,.update_all,.delete_all',function(e){
    let usertype=$(this).val();
    let checked_sec = false;
    let checked='N';
    if($(this).prop('checked')===true)
    {
        checked_sec = true;
        checked='Y';
    }
    var elements = $('.'+usertype).prop('checked', checked_sec);
    let dataurl='/admin/storeAllSetformpermission';
      let token=$("input[name='_token']").val();
      let usergroup=$('#formmenu').val();
    var formname = $('.'+usertype).map(function() {
        return $(this).val();
    }).get();
      var request = ajaxRequest(dataurl,{formname,usergroup,_token:token,checked:checked});
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
    return
    // var moduleIdsArray = $('.permission_chk[data-usertypeIds="' + usertype + '"]').map(function() {
    //     return $(this).data('moduleids');
    // }).get();

    // let dataurl='storeAllPermission';
    // let token=$("input[name='_token']").val();
    // var request = ajaxRequest(dataurl,{usertype,moduleIdsArray,_token:token,checked:checked});
    // request.done(function (res) {
    //     if(res.status===true)
    //     {
    //         showNotification(res.message,'success')


    //     }
    //     else
    //     {
    //         showNotification(res.message,'error')

    //     }

    // });

})


  function setpermission(formname,checked)
  {
      let dataurl='setformpermission';
      let token=$("input[name='_token']").val();
      let usergroup=$('#formmenu').val();

      var request = ajaxRequest(dataurl,{formname,usergroup,_token:token,checked:checked});
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
