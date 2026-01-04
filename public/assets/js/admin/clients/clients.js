$(document).ready(function () {
    var globalClientName = "";
    getData();
});

function getData() {
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: "clients",
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
            { data: "name" },
            { data: "code" },
            { data: "mobile" },
            { data: "land_line" },
            { data: "email" },
            { data: "province_id" },
            { data: "address" },
            { data: "status" },
            { data: "action" },
        ],
    });
}

$(document).off("click", "#addData", function () {});
$(document).on("click", "#addData", function (e) {
    e.preventDefault();
    $("#FormModal").modal("show");
    $(".modal-title").html("Add Client");
    $(".form").attr("id", "dataForm");
    $("#dataForm")[0].reset();
    $("#btnSubmit").show();
    $("#btnUpdate").hide();
    $(".imgCl").attr("hidden", true);
});

$(document).off("submit", "#dataForm", function () {});
$(document).on("submit", "#dataForm", function (e) {
    e.preventDefault();
    let dataurl = $("#dataForm").attr("action");
    let postdata = new FormData(this);

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
});

$(document).off("click", ".editData", function () {});
$(document).on("click", ".editData", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    $(".modal-title").html("Edit Client");
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    $(".imgCl").attr("hidden", false);
    request.done(function (res) {
        if (res.status === true) {
            $("#btnSubmit").hide();
            $("#btnUpdate").show();
            $(".form").attr("id", "updatedataForm");
            $("#FormModal").modal("show");
            $("#id").val(res.response.id);
            $("#name").val(res.response.name);
            $("#code").val(res.response.code);
            $("#mobile").val(res.response.mobile);
            $("#land_line").val(res.response.land_line);
            $("#providence").val(res.response.province_id);
            $("#address").val(res.response.address);
            $("#email").val(res.response.email);
            $("#contact_person").val(res.response.contact_person);
            $("#contact_person_contact").val(
                res.response.contact_person_contact
            );
            if (res.response.province_id) {
                populateDistricts(
                    res.response.province_id,
                    res.response.district_id,
                    false
                );
            }
            if (res.response.district_id) {
                populateCity(res.response.district_id, res.response.city_id);
            }
            $("#city").val(res.response.city_id).change();
            let filedArr = ["pan", "registration", "tax_clearence"];
            filedArr.forEach((element) => {
                console.log(res.response[element]);
                if (res.response[element]) {
                    var extension = res.response[element].substr(
                        res.response[element].lastIndexOf(".") + 1
                    );
                    if (extension === "pdf") {
                        $("." + element + "A").attr(
                            "href",
                            res.response[element]
                        );
                        $("." + element + "Img").attr(
                            "src",
                            res.response[element]
                        );
                        $("." + element + "A").text(
                            `${element.replace("_", " ")} PDF`
                        );
                    } else {
                        $("." + element + "A").attr(
                            "href",
                            res.response[element]
                        );
                        $("." + element + "Img").attr(
                            "src",
                            res.response[element]
                        );
                    }
                }
            });
            // $('.${element}A').attr('href',res.response.pan);
            // $('.registrationA').attr('href',res.response.registration);
            // $('.tax_clearenceA').attr('href',res.response.tax_clearence);
            // $('.panImg').attr('src',res.response.pan);
            // $('.registrationImg').attr('src',res.response.registration);
            // $('.tax_clearenceImg').attr('src',res.response.tax_clearence);
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).off("submit", "#updatedataForm", function () {});
$(document).on("submit", "#updatedataForm", function (e) {
    e.preventDefault();
    let id = $("#id").val();
    let dataurl = "clients/" + id;
    let postdata = $("#updatedataForm").serialize();
    var request = ajaxRequest(dataurl, postdata, "PUT");
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#FormModal").modal("hide");
            $("#updatedataForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).off("click", ".deleteData", function () {});
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
$(document).on("click", ".addPolicy", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    // alert(id);
    $("#client_id").val(id);
    $(".policy-modal-title").html(
        "Add New Policy To client : " + $(this).attr("data-name")
    );
    $("#PolicyFormModal").modal("show");
    $(".policyForm").attr("id", "policyForm");
    $("#policyForm")[0].reset();
    // $('#policyForm')[0].reset();
    $(".ri100").val(0).trigger("keyup");
    $("#excess_type").prop("checked", true).trigger("change");
    $("#PolicyBtnSubmit").show();
    $("#PolicyBtnUpdate").hide();
    $(".policyTable").empty();
    $("#totalAmt").html(0);
});
$(document).off("submit", "#policyForm", function () {});
$(document).on("submit", "#policyForm", function (e) {
    e.preventDefault();
    let dataurl = $("#policyForm").attr("action");
    let postdata = new FormData(this);

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#PolicyFormModal").modal("hide");
            $("#policyForm")[0].reset();
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("click", ".viewPolicy", function () {
    let id = $(this).attr("data-pid");
    global_group_id = id;
    let groupName = $(this).attr("data-name");
    globalClientName = groupName;
    let dataurl = "get-client-policies/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $(".policy-list-modal-title").html(
                "Policies of Client : " + groupName
            );
            $("#PolicyListTableModal").modal("show");
            populatePolicyList(res.response);
        } else {
            showNotification(res.message, "error");
        }
    });
});

function populatePolicyList(list) {
    var tbody = $("#PolicyListTableModal tbody");
    tbody.empty();
    if (list.length === 0) {
        var row =
            '<tr><td colspan="7" class="text-center">No Policys found</td></tr>';
        tbody.append(row);
    } else {
        list.forEach(function (policy, index) {
            var sn = index + 1;
            var row =
                "<tr><td>" +
                sn +
                "</td><td>" +
                policy.policy_no +
                "</td><td>" +
                policy.actual_issue_date +
                "</td><td>" +
                policy.issue_date +
                "</td><td>" +
                policy.valid_date +
                "</td><td>" +
                policy.imitation_days +
                "</td><td>" +
                policy.member_no +
                "</td><td>" +
                '<a href="javascript:void(0)" class="btn btn-primary  editPolicyData" ' +
                'data-policy_id="' +
                policy.id +
                '">' +
                '<i class="fas fa-edit"></i></a>' +
                '<a href="javascript:void(0)" class="btn btn-danger deletePoicyData mx-1" ' +
                'data-policy_id="' +
                policy.id +
                '">' +
                '<i class="fas fa-trash"></i></a>' +
                '<a href="javascript:void(0)" class="btn btn-success renewPolicy" ' +
                'data-policy_id="' +
                policy.id +
                '"  data-bs-toggle="tooltip" data-bs-placement="top" title="Renew Policy" data-policy_no="' +
                policy.policy_no +
                '">' +
                '<i class="fas fa-sync"></i></a>' +
                "</td>" +
                "</tr>";
            tbody.append(row);
        });
    }
}

$(document).on("click", ".editPolicyData", function () {
    let policy_id = $(this).attr("data-policy_id");
    $("#policy_id").val(policy_id);

    let dataurl = "client-policies/" + policy_id + "/edit";
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $(".policy-modal-title").html(
                "Edit policy Of Client : " + globalClientName
            );
            $(".policyForm").attr("id", "policyFormUpdate");
            $("#policyFormUpdate")[0].reset();
            $("#PolicyBtnSubmit").hide();
            $("#PolicyBtnUpdate").show();
            $("#PolicyFormModal").modal("show");
            $("#client_id").val(res.response.client_id);
            $("#imitation_days").val(res.response.imitation_days);
            $("#actual_issue_date").val(res.response.actual_issue_date);
            $("#issue_date").val(res.response.issue_date);
            $("#member_no").val(res.response.member_no);
            $("#policy_no").val(res.response.policy_no);
            $("#insured_amount").val(res.response.insured_amount);
            $("#premium_amount").val(res.response.premium_amount);
            $("#valid_date").val(res.response.valid_date);
            $("#nepal_ri").val(res.response.nepal_ri ?? 0);
            $("#himalayan_ri").val(res.response.himalayan_ri ?? 0);
            $("#retention").val(res.response.retention ?? 0);
            $("#quota").val(res.response.quota ?? 0);
            $("#surplus_i").val(res.response.surplus_i ?? 0);
            $("#surplus_ii").val(res.response.surplus_ii ?? 0);
            $("#auto_fac").val(res.response.auto_fac ?? 0);
            $("#facultative").val(res.response.facultative ?? 0);
            $("#co_insurance").val(res.response.co_insurance ?? 0);
            $("#xol_i").val(res.response.xol_i ?? 0);
            $("#xol_ii").val(res.response.xol_ii ?? 0);
            $("#xol_iii").val(res.response.xol_iii ?? 0);
            $("#xol_iiii").val(res.response.xol_iiii ?? 0);
            $("#pool")
                .val(res.response.pool ?? 0)
                .trigger("keyup");
            if (res.response.excess) {
                let excessData = JSON.parse(res.response.excess);
                console.log(excessData.excess_type, excessData.excess_value);
                $("#excess_type")
                    .prop(
                        "checked",
                        excessData.excess_type == "percentage" ? true : false
                    )
                    .trigger("change");
                $("#excess_value").val(excessData.excess_value);
            } else {
                $("#excess_type").prop("checked", true).trigger("change");
            }
            // if (res.response.excess_type==='Y') {

            // } else {
            //     $(".excess_type").attr('checked',false).trigger("change");

            // }
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).off("submit", "#policyFormUpdate", function () {});
$(document).on("submit", "#policyFormUpdate", function (e) {
    e.preventDefault();
    let policy_id = $("#policy_id").val();
    let client_id = $("#client_id").val();
    let dataurl = "client-policies/" + policy_id;
    let postdata = $("#policyFormUpdate").serialize();
    var request = ajaxRequest(dataurl, postdata, "PUT");
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#PolicyFormModal").modal("hide");
            $("#PolicyListTableModal").modal("hide");
            // $(`a[data-id="${id}"]`).trigger('click');
            $('a.viewPolicy[data-pid="' + client_id + '"]').trigger("click");
            $("#policyFormUpdate")[0].reset();
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).on("click", ".deletePoicyData", function (e) {
    e.preventDefault();
    let policy_id = $(this).attr("data-policy_id");
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            let currbtn = $(this);
            let dataurl = "client-policies/" + policy_id;
            var request = ajaxRequest(dataurl, {}, "delete");
            request.done(function (res) {
                if (res.status === true) {
                    showNotification(res.message, "success");
                    currbtn.closest("tr").remove();
                } else {
                    showNotification(res.message, "error");
                }
            });
        } else {
            swal("Your Data Is Safe!");
        }
    });
});
// $(document).on('keyup','.ri100',function(){
//     calculateRiTotal();
// });
// function calculateRiTotal() {
//     let total=0;
//     $('.ri100').each(function(){
//         total +=parseFloat($(this).val()||0);
//     });
//     if (total !=100) {
//         $('#PolicyBtnSubmit').prop('disabled',true);
//         $('#PolicyBtnUpdate').prop('disabled',true);
//         $('#riErr').prop('hidden',false);
//     }else{
//         $('#PolicyBtnSubmit').prop('disabled',false);
//         $('#PolicyBtnUpdate').prop('disabled',false);
//         $('#riErr').prop('hidden',true);
//     }
// }
$(document).on("change", "#excess_type", function () {
    excessType = $(this).is(":checked");
    if (excessType) {
        $("#excess_value").attr("min", "0");
        $("#excess_value").attr("max", "99");
    } else {
        $("#excess_value").attr("min", "0");
        $("#excess_value").removeAttr("max", "99");
    }
});
$(document).on("click", ".renewPolicy", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-policy_id");
    let policy_no = $(this).attr("data-policy_no");
    $("#renew_policy_id").val(id);
    $(".renew_policy-modal-title").html("Renew Policy : " + policy_no);
    $("#RenewPolicyFormModal").modal("show");
    // $('.renewPolicyForm').attr('id', 'renewPolicyForm');
    $("#renewPolicyForm")[0].reset();
    // $('#policyForm')[0].reset();
    // $('.ri100').val(0).trigger('keyup');
    // $("#excess_type").prop('checked', true).trigger("change");
    // $('#PolicyBtnSubmit').show();
    // $('#PolicyBtnUpdate').hide();
    // $('.policyTable').empty();
    // $('#totalAmt').html(0);
});
$(document).off("submit", "#renewPolicyForm", function () {});
$(document).on("submit", "#renewPolicyForm", function (e) {
    e.preventDefault();
    let dataurl = $("#renewPolicyForm").attr("action");
    let postdata = new FormData(this);

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#RenewPolicyFormModal").modal("hide");
            $("#renewPolicyForm")[0].reset();
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).on("change", "#issue_date,#valid_date_type", function () {
    let type = $("#valid_date_type").find(":selected").val();
    let issueDate = $("#issue_date").val();
    let date = new Date(issueDate);
    let newDate = null;
    if (type == "month") {
        date.setMonth(date.getMonth() + 6);

        // Subtract 1 day
        date.setDate(date.getDate() - 1);

        // Format the new date in "YYYY-MM-DD" format
        newDate = date.toISOString().slice(0, 10);
    } else {
        let years = parseInt(type);
        // Add the equivalent number of days (years * 365)
        let days = years * 365 - 1;
        // Add the days to the date
        date.setDate(date.getDate() + days);
        // date.setMonth(date.getDate() - 1);
        newDate = date.toISOString().split("T")[0];
    }
    $("#validDate").html(newDate);
    $("#valid_date").val(newDate);
});
$(document).on("change", ".isactive", function () {
    let self = $(this);
    let id = self.data("pid");
    let clientStatus = self.is(":checked") ? "Y" : "N";
    let postdata = {
        client_id: id,
        status: clientStatus,
    };
    let dataurl = "client/change-status";
    swal({
        title: "Are you sure?",
        text:
            clientStatus === "N"
                ? "You want to make the client inactive?"
                : "You want to activate the client?",
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
