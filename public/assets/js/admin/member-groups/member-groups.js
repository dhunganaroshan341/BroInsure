let member = null;
var global_member_id = isNaN(
    new URLSearchParams(window.location.search).get("member_id")
)
    ? null
    : new URLSearchParams(window.location.search).get("member_id");
$(document).ready(function () {
    // $.fn.dataTable.ext.errMode = 'none';
    getData();
    $("#province_id, #province_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
        dropdownParent: $("#FormModal"),
    });
    $("#client_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
        dropdownParent: $("#FormModal"),
    });
    $("#client_id_list").select2();
    $("#group_id, #package_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
        dropdownParent: $("#FormModal"),
    });
    $("#dateofbirth_bs").nepaliDatePicker({
        container: "#FormModal",
        ndpYear: true,
        ndpMonth: true,
        ndpYearCount: 15,
        readOnlyInput: true,
        onChange: function (e) {
            $("#dateofbirth_ad").val(e.ad);
        },
    });
});

$(document).on("change", "#dateofbirth_ad", function () {
    $("#dateofbirth_bs").val(NepaliFunctions.AD2BS($(this).val()));
});

$(document).on("change", "#providence", function (e) {
    let id = $("#providence").find(":selected").data("id");
    if (id) {
        populateDistricts(id);
    }
});

$(document).on("change", "#district", function (e) {
    let id = $("#district").find(":selected").data("id");
    populateCity(id, member?.perm_city);
});

$(document).on("change", "#present_district", function (e) {
    let id = $(this).find(":selected").data("id");
    temp_populateCity(id, member?.present_city);
});

function getData() {
    if ($.fn.DataTable.isDataTable("#datatables-reponsive")) {
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive").DataTable().destroy();
    }
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        // ajax: "members",
        ajax: {
            url: "members",
            data: {
                type: "group",
                member_id: global_member_id,
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1],
                },
            },
        ],

        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "user_id" },
            {
                data: "type",
                render: function (data, type, row) {
                    return (
                        data.charAt(0).toUpperCase() +
                        data.slice(1).toLowerCase()
                    );
                },
            },
            { data: "client_id" },
            { data: "group_name" },
            { data: "amount" },
            { data: "is_active" },
            { data: "action" },
        ],
        drawCallback: function (settings) {
            if (global_member_id) {
                // Trigger click for the element with class previewData and matching data-claim_id
                $('.viewData[data-pid="' + global_member_id + '"]').trigger(
                    "click"
                );
            }
        },
    });
}
$(document).on("change", ".isactive", function () {
    let self = $(this);
    let id = self.data("pid");
    let memberStatus = self.is(":checked") ? "Y" : "N";
    let postdata = {
        member_id: id,
        is_active: memberStatus,
    };
    let dataurl = "member/change-status";
    swal({
        title: "Are you sure?",
        text:
            memberStatus === "N"
                ? "You want to make the member inactive?"
                : "You want to activate the member?",
        icon: "warning",
        cancelButtonColor: "#d33",
        buttons: {
            cancel: true,
            confirm: "Submit",
        },
    }).then((res) => {
        if (res === null) {
            self.prop("checked", !self.prop("checked"));
        } else {
            var request = ajaxRequest(dataurl, postdata, "POST");
            request
                .done(function (res) {
                    if (res.status === true) {
                        showNotification(res.message, "success");
                        $("#FormModal").modal("hide");
                        getData();
                    } else {
                        showNotification(res.message, "error");
                    }
                })
                .fail((error) => {
                    self.prop("checked", !self.prop("checked"));
                    showNotification(error.message, "error");
                });
        }
    });
});
$(document).off("click", "#addData", function () { });
$(document).on("click", "#addData", function (e) {
    e.preventDefault();
    member = null;
    clearOldRelations();

    $("#FormModal").modal("show");
    $(".modal-title").html("Add Member");
    $(".form").attr("id", "dataForm");
    $('ul[role="tablist"] li:first-child a').trigger("click");
    $('ul[role="tablist"] li').each(function (index) {
        $(this).removeClass("done");
        if (index > 0) {
            $(this).addClass("disabled").attr("aria-disabled", "true");
        }
    });
    $("#FormModal")
        .find("input:not([type='radio']), select, textarea")
        .val(null)
        .trigger("change");
    $("#dataForm")[0].reset();
    $("#documentsDiv").html(getNewDocumentRow(true));
    $("#btnSubmit").show();
    $("#btnUpdate").hide();
});

$(document).off("submit", "#dataForm", function () { });
$(document).on("submit", "#dataForm", function (e) {
    e.preventDefault();
    member ? updateMember(this) : storeMember(this);
});

function storeMember(element) {
    let dataurl = $("#dataForm").attr("action");
    let postdata = new FormData(element);
    postdata.append("member_type", "group");
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#FormModal").modal("hide");
            $("#dataForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
}

function updateMember(element) {
    let dataurl = $("#dataForm").attr("action") + "/" + member.id;
    let postdata = new FormData(element);
    postdata.append("_method", "PUT");
    postdata.append("member_type", "group");
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#FormModal").modal("hide");
            $("#dataForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
}

$(document).on("submit", "#updatedataForm", function (e) {
    e.preventDefault();
});

function populateFieldsForEdit(member) {
    // For normal text inputs
    console.log("ksjadfkjskdjksdafkjsd");
    let auto_populate_input = {
        first_name: member.user.fname,
        middle_name: member.user.mname,
        last_name: member.user.lname,
        nationality: member.nationality,
        dateofbirth_bs: member.date_of_birth_bs,
        dateofbirth_ad: member.date_of_birth_ad,
        employee_id: member.employee_id,
        branch: member.branch,
        designation: member.designation,
        perm_ward_no: member.perm_ward_no,
        perm_street: member.perm_street,
        perm_house_no: member.perm_house_no,
        present_ward_no: member.present_ward_no,
        present_street: member.present_street,
        present_house_no: member.present_house_no,
        citizenship_no: member.details?.citizenship_no,
        citizenship_district: member.details?.citizenship_district,
        citizenship_issued_date: member.details?.citizenship_issued_date,
        mail_address: member.mail_address,
        type: member.type,
        phone_number: member.phone_number,
        mobile_number: member.mobile_number,
        email: member?.user.email,
        income_source: member?.details?.income_source,
    };
    for (let [id, value] of Object.entries(auto_populate_input)) {
        console.log(id + value);
        $(`#${id}`).val(value);
    }
    $("#dateofbirth_ad").trigger("change");
    // For radio buttons
    let auto_populate_radio = {
        "personal[gender]": member.gender,
        "personal[marital_status]": member.marital_status,
        "citizenship[occupation]": member.details?.occupation,
    };
    for (let [id, value] of Object.entries(auto_populate_radio)) {
        $(`input[name='${id}']`).val([value]);
    }

    // For select inputs
    let auto_populate_select = {
        providence: member.perm_province,
        citizenship_district: member.details?.citizenship_district,
        client_id: member.client_id,
        present_province: member.present_province,
    };
    for (let [id, value] of Object.entries(auto_populate_select)) {
        $(`#${id}`).val(value).trigger("change");
    }
    populateDistricts(member.perm_province, member.perm_district);
    temp_populateDistricts(member.present_province, member.present_district);
    $("#documentsDiv").html(getNewDocumentRow());
    for (let attachment of member.attachments) {
        newRow = getNewDocumentRow(
            false,
            attachment.attachment_name,
            "/admin/" + attachment.file_name,
            attachment.id
        );
        $("#documentsDiv").prepend(newRow);
    }
    if (member.is_address_same == "Y") {
        $("#is_address_same").prop("checked", true).trigger("change");
    } else {
        $("#is_address_same").prop("checked", false).trigger("change");
    }
}

$(document).on("change", "#present_province", function (e) {
    let id = $("#present_province").find(":selected").data("id");
    temp_populateDistricts(id);
});

$(document).off("click", ".editData", function () { });
$(document).on("click", ".editData", function (e) {
    e.preventDefault();
    member = JSON.parse($(this).attr("data-member"));
    $(".modal-title").html("Edit member");
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $("#btnSubmit").hide();
            $("#btnUpdate").show();
            // $("#dataForm").attr("id", "updatedataForm");
            $("#dataForm")[0].reset();
            $('ul[role="tablist"] li:first-child a').trigger("click");
            $('ul[role="tablist"] li').each(function (index) {
                $(this).removeClass("done");
                if (index > 0) {
                    $(this).addClass("disabled").attr("aria-disabled", "true");
                }
            });
            $("#FormModal").modal("show");
            clearOldRelations();
            addOldRelations(res.response.old_relations_html);
            populateFieldsForEdit(member);
        } else {
            showNotification(res.message, "error");
        }
    });
});

function addOldRelations(html) {
    $("#dependentDiv").prepend(html);
}

function clearOldRelations() {
    $(".old_relation_container").remove();
}

$(document).off("submit", "#updatedataForm", function () { });
// $(document).on('submit','#updatedataForm',function(e){
//     e.preventDefault();
//     let id=$('#id').val();
//     let dataurl='members/'+id;
//     let postdata=$('#updatedataForm').serialize();
//     var request = ajaxRequest(dataurl,postdata,'PUT');
// 		request.done(function (res) {
// 			if(res.status ===true)
//             {
//                  showNotification(res.message,'success');
//                  $('#FormModal').modal('hide');
//                  $('#updatedataForm')[0].reset();
//                  $('#datatables-reponsive').dataTable().fnClearTable();
//                  $('#datatables-reponsive').dataTable().fnDestroy();
//                  getData();

// 			}else
//             {
//                 showNotification(res.message,'error')
// 			}
// 		});
// })

$(document).off("click", ".deleteData", function () { });
$(document).on("click", ".deleteData", function (e) {
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            let currbtn = $(this);
            let dataurl = currbtn.attr("data-url");
            let token = $("input[name='_token']").val();
            var request = ajaxRequest(dataurl, { _token: token }, "DELETE");
            request.done(function (res) {
                if (res.status === true) {
                    //   currbtn.closest("tr").remove();
                    showNotification(res.message, "success");
                    $("#datatables-reponsive").dataTable().fnClearTable();
                    $("#datatables-reponsive").dataTable().fnDestroy();
                    getData();
                } else {
                    showNotification(res.message, "error");
                }
            });
        } else {
            swal("Your Data Is Safe!");
        }
    });
});

$(document).off("change", "#is_address_same", function () { });
$(document).on("change", "#is_address_same", function (e) {
    if (!$(this).is(":checked")) {
        $(".is_address_sameDiv").prop("hidden", false);
        $(".presentRequired").prop("required", true);
    } else {
        $(".is_address_sameDiv").prop("hidden", true);
        $(".presentRequired").prop("required", false);
    }
});
$('input[name="citizenship[occupation]"]').change(function () {
    if ($(this).val() === "Other") {
        $(".otherDiv").prop("hidden", false);
    } else {
        $(".otherDiv").prop("hidden", true);
    }
});
$(document).on("click", ".addBtn", function () {
    var newRow = `<div class="newEntry row">
            <div class="col-md-2">
                <label for="input3" class="form-label">Relation <span class="text-danger">*</span> </label>
                <select name="rel_relation[]" id="rel_relation" class="form-select">
                        <option value=""  selected disabled>select relaion</option>
                        <option value="father">Father</option>
                        <option value="mother">Mother</option>
                        <option value="mother-in-law">Mother-in-law</option>
                        <option value="father-in-law">Father-in-law</option>
                        <option value="spouse">Spouse</option>
                        <option value="child1">child 1</option>
                        <option value="child2">child 2</option>
                    </select>
            </div>
            <div class="col-md-3">
                <label for="input3" class="form-label">Full Name <span class="text-danger">*</span> </label>
                <input type="text" class="form-control"  placeholder="Enter Full Name"
                    name="rel_name[]" required>
            </div>
            <div class="col-md-3">
                <label for="input3" class="form-label">Date of Birth <span class="text-danger">*</span> </label>
                <input type="date" class="form-control"  placeholder="Enter Date of Birth" name="rel_dob[]"
                required>
            </div>
            <div class="col-md-2">
                <label for="input3" class="form-label">Gender <span class="text-danger">*</span> </label>
                <select name="rel_gender[]"  class="form-select" required>
                    <option value="" disabled selected>select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-2 pt-2">
                <br>
                <button type="button" type="button" class="btn btn-sm btn-primary addBtn"><i
                        class="fa fa-plus"></i></button>
                <button type="button" type="button" class="btn btn-sm btn-danger removeBtn"><i
                        class="fa fa-minus"></i></button>
            </div>
        </div>`;
    $("#dependentDiv").append(newRow);
});
$(document).on("click", ".removeBtn", function () {
    $(this).closest(".newEntry").remove();
});
$(document).on("click", ".documentAddBtn", function () {
    newRow = getNewDocumentRow();
    $("#documentsDiv").append(newRow);
});

function getNewDocumentRow(
    is_required = false,
    attachment_name = null,
    file = null,
    id = null
) {
    console.log("heree");
    return `<div class="documentNewEntry row">
            <div class="col-md-4">
                <label for="input3" class="form-label">Document Name </label>
                ${id
            ? `<input type="hidden" name="attachment_id[]" value="${id}"/>`
            : ""
        }
                <input type="text" class="form-control" placeholder="Enter Document Name lode"
                    name="attachment_name[]" value="${attachment_name ? attachment_name : ""
        }" >
            </div>
            <div class="col-md-4">
                <label for="files" class="form-label">Document</label>
                ${file
            ? `<span><a target="blank" href="${file}">${attachment_name}</a></span>`
            : ""
        }
                <input type="file" class="form-control" placeholder="Enter Full Name"
                    name="attachments[]" ${is_required ? "required" : ""}>
            </div>
            <div class="col-md-4 pt-2">
                <br>
                <button type="button" type="button" class="btn btn-sm btn-primary documentAddBtn"><i
                        class="fa fa-plus"></i></button>
                <button type="button" type="button" class="btn btn-sm btn-danger documentRemoveBtn"><i
                        class="fa fa-minus"></i></button>
            </div>
        </div>`;
}
$(document).on("click", ".documentRemoveBtn", function () {
    $(this).closest(".documentNewEntry").remove();
});
$(document).on("change", "#client_id", function () {
    let id = $("#client_id").find(":selected").data("id");
    // console.log(member);
    if (id) {
        populateGroups(
            id,
            member ? member.current_member_policy?.group_id : ""
        );
    }
});
function populateGroups(id, selected = null) {
    $('#group_id option[value!=""]').remove();
    let dataurl = "/admin/get-client-groups/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                //
                $("#group_id").append(
                    '<option value="' +
                    option.id +
                    '" data-id="' +
                    option.id +
                    '"' +
                    (isSelected ? " selected" : "") +
                    ">" +
                    option.name +
                    "</option>"
                );
            });
            $("#group_id").trigger("change");
        } else {
            showNotification(res.message, "error");
        }
    });
}
// $(document).on("change", "#group_id", function () {
//     let id = $("#group_id").find(":selected").data("id");
//     if (id) {
//         populatePackages(id, member ? member.group_package[0]?.package_id : "");
//     }
// });
// function populatePackages(id, selected = null) {
//     $('#package_id option[value!=""]').remove();
//     let dataurl = "/admin/get-package-groupwise/" + id;
//     var request = getRequest(dataurl);
//     request.done(function (res) {
//         if (res.status === true) {
//             $.each(res.response, function (index, option) {
//                 var isSelected =
//                     selected !== null &&
//                     option.id.toString() === selected.toString();
//                 //
//                 $("#package_id").append(
//                     '<option value="' +
//                     option.id +
//                     '" data-id="' +
//                     option.id +
//                     '"' +
//                     (isSelected ? " selected" : "") +
//                     ">" +
//                     option.name +
//                     "</option>"
//                 );
//             });
//         } else {
//             showNotification(res.message, "error");
//         }
//     });
// }
$(document).off("submit", "#importForm", function () { });
$(document).on("submit", "#importForm", function (e) {
    e.preventDefault();
    let dataurl = $("#importForm").attr("action");
    let postdata = new FormData(this);

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            // console.log(res.status);
            showNotification(res.message, "success");
            $("#importForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).on("click", ".viewData", function (e) {
    e.preventDefault();
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    request.done(function (response) {
        if (response.status === true) {
            console.log(response.response.personal);
            $("#viewModal").modal("show");
            $("#view_first_name").html(response.response.personal.first_name);
            $("#view_middle_name").html(
                response.response.personal.middle_name ?? null
            );
            $("#view_last_name").html(response.response.personal.last_name);
            $("#view_nationality").html(response.response.personal.nationality);
            $("#view_dateofbirth_bs").html(
                response.response.personal.dateofbirth_bs
            );
            $("#view_dateofbirth_ad").html(
                response.response.personal.dateofbirth_ad
            );
            $("#view_employee_id").html(response.response.personal.employee_id);
            $("#view_branch").html(response.response.personal.branch ?? "");
            $("#view_designation").html(
                response.response.personal.designation ?? ""
            );
            $("#view_perm_ward_no").html(
                response.response.personal.perm_ward_no ?? ""
            );
            $("#view_perm_street").html(
                response.response.personal.perm_street ?? ""
            );
            $("#view_perm_house_no").html(
                response.response.personal.perm_house_no ?? ""
            );
            $("#view_present_ward_no").html(
                response.response.personal.present_ward_no ?? ""
            );
            $("#view_present_street").html(
                response.response.personal.present_street ?? ""
            );
            $("#view_present_house_no").html(
                response.response.personal.present_house_no ?? ""
            );
            $("#view_citizenship_no").html(
                response.response.personal.citizenship_no
            );
            $("#view_citizenship_district").html(
                response.response.personal.citizenship_district
            );
            $("#view_citizenship_issued_date").html(
                response.response.personal.citizenship_issued_date
            );
            $("#view_mail_address").html(
                response.response.personal.mail_address
            );
            $("#view_type").html(response.response.personal.type);
            $("#view_gender").html(response.response.personal.gender);
            $("#view_married_status").html(
                response.response.personal.marital_status
            );
            $("#view_phone_number").html(
                response.response.personal.phone_number ?? ""
            );
            $("#view_mobile_number").html(
                response.response.personal.mobile_number
            );
            $("#view_email").html(response.response.personal.email);
            $("#view_income_source").html(
                response.response.personal.income_source ?? ""
            );

            //dependents
            $("#viewdependentDiv").empty();
            $.each(response.response.relatives, function (index, dependent) {
                $("#viewdependentDiv").append(
                    '<div class="row"><div class="col-md-3">' +
                    '<label for="span3" class="form-label">Relation : <span  >' +
                    capitalizeFirstLetter(dependent.rel_relation) +
                    "</span></label></div>" +
                    '<div class="col-md-3">' +
                    '<label for="span3" class="form-label">Name : <span  >' +
                    capitalizeFirstLetter(dependent.rel_name) +
                    "</span></label></div>" +
                    '<div class="col-md-3">' +
                    '<label for="span3" class="form-label">Fender : <span  >' +
                    capitalizeFirstLetter(dependent.rel_gender) +
                    "</span></label></div>" +
                    '<div class="col-md-3">' +
                    '<label for="span3" class="form-label">D.O.B : <span  >' +
                    dependent.rel_dob +
                    "</span></label></div></div>"
                );
            });
            //attachments
            $("#viewAttachmentDiv").empty();
            $.each(response.response.attachments, function (index, attch) {
                $("#viewAttachmentDiv").append(
                    '<div class="row"><div class="col-md-4">' +
                    '<label for="span3" class="form-label">File Name : <span  >' +
                    attch.attachment_name +
                    "</span></label></div>" +
                    '<div class="col-md-6">' +
                    '<a href="' +
                    attch.file_name +
                    '"target="_blank"><label for="span3" class="form-label">File : <img  src="' +
                    attch.file_name +
                    '"height="80"></img></label></a></div>'
                );
            });
            $("#view_client_id").html(response.response.policy.client);
            $("#view_group_id").html(response.response.policy.group);
            $("#view_type").html(
                capitalizeFirstLetter(response.response.policy.type)
            );
        } else {
            showNotification(res.message, "error");
        }
    });
});
function capitalizeFirstLetter(string) {
    return string.replace(/\b\w/g, function (char) {
        return char.toUpperCase();
    });
}
$("#viewModal").on("hidden.bs.modal", function () {
    if (global_member_id) {
        global_member_id = null;
        getData();
    }
});
