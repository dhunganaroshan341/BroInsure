$(document).on('change', '#providence', function (e){
    let id = $('#providence').find(':selected').data('id');
    populateDistricts(id)
});

function populateDistricts(id,selected=null, shouldTriggerChange = true){
    if (!id) {
        $('#district').html('<option value="" selected>select district</option>');
        return
    }
    let dataurl="/admin/get-districts/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        $('#district').html('<option value="" selected>select district</option>');
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                var isSelected = selected !== null && option.id.toString() === selected.toString();
                // $('#district').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
                $('#district').append('<option value="' + option.id + '" data-id="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
            });
            shouldTriggerChange ? $('#district').trigger('change') : null
        }
        else {
            showNotification(res.message, 'error')
        }

    });
}
$(document).on('change', '#district', function (e){
    let id = $('#district').find(':selected').data('id');
    populateCity(id)
});
function populateCity(id,selected=null){
    if (!id) {
        $('#city').html('<option value="" selected>select city</option>');
        return
    }
    let dataurl="/admin/get-cities/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        $('#city').html('<option value="" selected>select city</option>');
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                // $('#district').append('<option value="' + option.id + '">' + option.name + '</option>');
                var isSelected = selected !== null && option.id.toString() === selected.toString();
                $('#city').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
            });

        }
        else {
            showNotification(res.message, 'error')
        }

    });
}
$(document).on('change', '#present_province', function (e){
    let id = $('#present_province').find(':selected').data('id');
    if(id){
        temp_populateDistricts(id)
    }
});
function temp_populateDistricts(id,selected=null){
    if (!id) {
        $('#present_district').html('<option value="" selected>select district</option>');
        return
    }
    let dataurl="/admin/get-districts/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        $('#present_district').html('<option value="" selected>select district</option>');
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                var isSelected = selected !== null && option.id.toString() === selected.toString();
                // $('#district').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
                $('#present_district').append('<option value="' + option.id + '" data-id="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
            });
            $('#present_district').trigger('change')

        }
        else {
            $('#present_district').html('<option value="" selected>select district</option>');
            showNotification(res.message, 'error')
        }

    });
}
$(document).on('change', '#present_district', function (e){
    let id = $('#present_district').find(':selected').data('id');
    if(id){
        temp_populateCity(id)
    }
});
function temp_populateCity(id,selected=null){
    if (!id) {
        $('#present_city').html('<option value="" selected>select city</option>');
        return
    }
    let dataurl="/admin/get-cities/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        $('#present_city').html('<option value="" selected>select city</option>');
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                // $('#district').append('<option value="' + option.id + '">' + option.name + '</option>');
                var isSelected = selected !== null && option.id.toString() === selected.toString();
                $('#present_city').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
            });

        }
        else {
            showNotification(res.message, 'error')
        }

    });
}
