$(document).ready(function () {
    var globalgroupName = "";
    var limitTypeArr = [];
    var limitArr = [];
    getData();
    $("#package_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        dropdownParent: $("#PackageFormModal"),
    });
});

function getData() {
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: "retail-groups",
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
            { data: "client_id" },
            { data: "name" },
            { data: "action" },
        ],
    });
}

$(document).off("click", "#addData", function () {});
$(document).on("click", "#addData", function (e) {
    e.preventDefault();
    $("#FormModal").modal("show");
    $(".modal-title").html("Add Retail Group");
    $(".form").attr("id", "dataForm");
    $("#dataForm")[0].reset();
    $(".limit_check").attr("checked", false).trigger("change");
    $("#client_id").val(null).trigger("change");
    $(".is_imitation_days_different").attr("checked", false).trigger("change");
    $("#btnSubmit").show();
    $("#btnUpdate").hide();
});

$(document).off("submit", "#dataForm", function () {});
$(document).on("submit", "#dataForm", function (e) {
    e.preventDefault();
    let dataurl = $("#dataForm").attr("action");
    let postdata = new FormData(this);

    var headingIds = []; // Array to store unique heading_id values
    // Iterate over each checked checkbox
    $("#dataForm input[type='checkbox'].sub_heading_id:checked").each(
        function () {
            var headingId = $(this).attr("data-heading_id");
            var imitationDayValue = $(this)
                .closest(".accordion-collapse")
                .find(".headingImitationDays")
                .val();
            // Check if the headingId is already in the array
            if (headingIds.indexOf(headingId) === -1) {
                let amount = $(
                    "#accordionExample" + headingId + " .headingAmount"
                ).val();
                headingIds.push(headingId); // Add the headingId to the array if it's not already there
                postdata.append("heading_id[]", headingId);
                postdata.append("amountNew[]", encodeURIComponent(amount));
                postdata.append("imitation_days[]", imitationDayValue);

                // postdata += "&amountNew[]=" + encodeURIComponent(amount);
            }
        }
    );
    if ($("#is_imitation_days_different").is(":checked")) {
        postdata.append("is_imitation_days_different", "Y");
    } else {
        postdata.append("is_imitation_days_different", "N");
    }
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#FormModal").modal("hide");
            $("#dataForm")[0].reset();
            $("#client_id").val(null).trigger("change");
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
});
$("#FormModal").on("hidden.bs.modal", function () {
    // Select all accordion buttons that are currently expanded
    var $expandedButtons = $(".accordion-button[aria-expanded='true']");

    // Trigger click event on each expanded button to collapse the accordion items
    $expandedButtons.each(function () {
        $(this).trigger("click");
    });
});

$(document).on("change", ".limit_check", function () {
    let checked = $(this);
    let currentSubHId = [];
    let appendlimittype = checked
        .closest(".accordion-collapse")
        .find(".appendAccessType");
    // let limit_sub_heading=checked.closest(".accordion-collapse").find('.appendAccessType').attr('data-pid');
    if (checked.prop("checked")) {
        checked
            .closest(".accordion-collapse")
            .find(".appendAccessType")
            .each(function () {
                currentSubHId.push($(this).attr("id"));
            });

        // console.log(limitTypeArr,'here',currentSubHId);
        appendlimittype.html(
            `
           <label for="" class="form-label">Access Type</label>
           <select class="form-select access_typeC" name="access_type[]" id="access_type">
            <option value="">Select one</option>
            <option value="fixed">Fixed</option>
            <option value="percentage">% of Total Sum</option>
            </select>

             <input type="number" class="form-control mt-2 mb-2 limit_numberC" id="limit_number" name="limit_number[]" aria-describedby="helpId"   placeholder=""
            />
            `
        );
        // console.log(typeof limitTypeArr,typeof limitTypeArr !== undefined,limitTypeArr !=null,Array.isArray(limitTypeArr));
        if (typeof limitTypeArr !== undefined && limitTypeArr != null) {
            let filteredAccessDivs = currentSubHId.filter(function (div) {
                // Extract the number from the div name
                let number = div.replace("accessDiv", "");
                // Check if the number exists as a key in the values object
                return limitTypeArr.hasOwnProperty(number);
            });
            filteredAccessDivs.forEach(function (div) {
                limitAppyS = $("#" + div);
                let subheadingid = div.replace("accessDiv", "");
                limitAppyS
                    .closest(".subLimitRow")
                    .find(".access_typeC")
                    .val(limitTypeArr[subheadingid]);
            });
        }
        if (typeof limitArr !== undefined && limitArr != null) {
            let filteredAccessDivs = currentSubHId.filter(function (div) {
                // Extract the number from the div name
                let number = div.replace("accessDiv", "");
                // Check if the number exists as a key in the values object
                return limitArr.hasOwnProperty(number);
            });
            filteredAccessDivs.forEach(function (div) {
                limitAppyS = $("#" + div);
                let subheadingidd = div.replace("accessDiv", "");
                limitAppyS
                    .closest(".subLimitRow")
                    .find(".limit_numberC")
                    .val(limitArr[subheadingidd]);
                // console.log(limitAppyS,div,limitArr[subheadingidd]);
            });
        }
    } else {
        appendlimittype.html("");
    }
});

$(document).on("change", "#access_type", function () {
    let type = $(this).val();
    console.log(type, type == "" || type == null);

    if (type == "percentage") {
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .attr("min", "0");
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .attr("max", "100");
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .attr("placeholder", "%");
    } else {
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .removeAttr("min", "0");
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .removeAttr("max", "100");
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .attr("placeholder", "Rate");
    }
    if (type == "" || type == null) {
        // console.log('yeah')
        $(this).closest(".appendAccessType").find("#limit_number").val("");
        $(this)
            .closest(".appendAccessType")
            .find("#limit_number")
            .attr("placeholder", "");
    }
});

// $(document).on('change','.sub_heading_id',function(){
//     subheadingid=$(this).attr('value');
//     let appendlimittype=checked.closest(".accordion-collapse").find('.appendAccessType');
// });

$(document).off("click", ".editData", function () {});
$(document).on("click", ".editData", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    $(".modal-title").html("Edit Group Policy");
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $("#btnSubmit").hide();
            $("#btnUpdate").show();
            $(".form").attr("id", "updatedataForm");
            $("#FormModal").modal("show");
            $("#name").val(res.response.name);
            $("#insurance_amount").val(res.response.insurance_amount);
            $("#code").val(res.response.code);
            $("#id").val(res.response.id);
            $(".form-check-input").prop("checked", false);
            if (res.response.is_amount_different === "Y") {
                $(".is_amount_different")
                    .prop("checked", true)
                    .trigger("change");
            } else {
                $(".is_amount_different").attr("checked", false);
            }
            if (res.response.is_imitation_days_different === "Y") {
                $(".is_imitation_days_different")
                    .prop("checked", true)
                    .trigger("change");
            } else {
                $(".is_imitation_days_different")
                    .attr("checked", false)
                    .trigger("change");
            }
            populate_members(res.response.client_id, res.response.policy_id);
            res.response.headings.forEach(function (valuerow) {
                var array = JSON.parse(valuerow.exclusive);
                limitTypeArr = JSON.parse(valuerow.limit_type);
                limitArr = JSON.parse(valuerow.limit);
                if (
                    typeof limitTypeArr !== "undefined" &&
                    Object.values(limitTypeArr).length > 0
                ) {
                    $("#limit_check" + valuerow.heading_id)
                        .prop("checked", true)
                        .trigger("change");
                } else {
                    $("#limit_check" + valuerow.heading_id)
                        .prop("checked", false)
                        .trigger("change");
                }
                $(
                    "#heading" + valuerow.heading_id + " .accordion-button"
                ).trigger("click");
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " .headingAmount"
                ).val(valuerow.amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " .headingImitationDays"
                ).val(valuerow.imitation_days);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_employee[" +
                        valuerow.heading_id +
                        "]']"
                ).prop("checked", valuerow.is_employee == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_spouse[" +
                        valuerow.heading_id +
                        "]']"
                ).prop("checked", valuerow.is_spouse == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_spouse_amount[]']"
                ).val(valuerow.is_spouse_amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_child[" +
                        valuerow.heading_id +
                        "]']"
                ).prop("checked", valuerow.is_child == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_child_amount[]']"
                ).val(valuerow.is_child_amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_parent[" +
                        valuerow.heading_id +
                        "]']"
                ).prop("checked", valuerow.is_parent == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='is_parent_amount[]']"
                ).val(valuerow.is_parent_amount);
                array.forEach(function (value) {
                    $("#subHeading" + value + "_" + valuerow.heading_id)
                        .prop("checked", true)
                        .trigger("change");
                });
            });
            $(".headingAmount").trigger("keyup");
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).off("submit", "#updatedataForm", function () {});
$(document).on("submit", "#updatedataForm", function (e) {
    e.preventDefault();
    let id = $("#id").val();
    let dataurl = "retail-groups/" + id;
    let postdata = $("#updatedataForm").serialize();

    var headingIds = []; // Array to store unique heading_id values

    $("#updatedataForm input[type='checkbox'].sub_heading_id:checked").each(
        function () {
            var headingId = $(this).attr("data-heading_id");
            var imitationDayValue = $(this)
                .closest(".accordion-collapse")
                .find(".headingImitationDays")
                .val();
            // Check if the headingId is already in the array
            if (headingIds.indexOf(headingId) === -1) {
                let amount = $(
                    "#accordionExample" + headingId + " .headingAmount"
                ).val();
                headingIds.push(headingId); // Add the headingId to the array if it's not already there
                postdata += "&heading_id[]=" + encodeURIComponent(headingId); // Append heading_id to serialized data
                postdata += "&amountNew[]=" + encodeURIComponent(amount); // Append heading_id to serialized data
                postdata +=
                    "&imitation_days[]=" +
                    encodeURIComponent(imitationDayValue);
            }
        }
    );

    if ($("#is_imitation_days_different").is(":checked")) {
        postdata += "&is_imitation_days_different=Y";
    } else {
        postdata += "&is_imitation_days_different=N";
    }
    var request = ajaxRequest(dataurl, postdata, "PUT");
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#FormModal").modal("hide");
            $("#updatedataForm")[0].reset();
            $("#client_id").val(null).trigger("change");
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
$(document).on("click", ".addPackage", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    // alert(id);
    $("#group_id").val(id);
    $("#package_id").val(null).trigger("change");
    $(".package-modal-title").html(
        "Assign Package To Group : " + $(this).attr("data-name")
    );
    $("#PackageFormModal").modal("show");
    $(".packageForm").attr("id", "packageForm");
    $("#packageForm")[0].reset();
    $("#PackageBtnSubmit").show();
    $("#PackageBtnUpdate").hide();
    $(".packageTable").empty();
    $("#totalAmt").html(0);
});

$(document).on("change", "#package_id", function () {
    let id = $(this).find(":selected").val();
    if (!id) return;
    let group_id = $("#group_id").val();
    $.ajax({
        url: "package-headings/" + id,
        type: "GET",
        dataType: "json",
        data: { group_id },
        success: function (res) {
            if (res.status == "success") {
                $(".packageTable").empty();
                $(".packageTable").html(res.html);
                $(".headingAmount").trigger("keyup");
            }
        },
    });
});
$(document).on("change", ".customCheckClass", function () {
    // const container = $(this).closest('.form-check');
    if ($(this).is(":checked")) {
        $(this).css("border", "1px solid green");
    } else {
        $(this).css("border", "1px solid red");
    }
});
// $(document).on('keyup', '.headingAmount', function () {
//     let totalSum = 0;
//     $('.headingAmount').each(function () {
//         totalSum += parseFloat($(this).val()) || 0;
//     });
//     $('#totalAmt').html(totalSum);
// })
$(document).off("submit", "#packageForm", function () {});
$(document).on("submit", "#packageForm", function (e) {
    e.preventDefault();
    let dataurl = $("#packageForm").attr("action");
    let postdata = new FormData(this);

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#PackageFormModal").modal("hide");
            $("#packageForm")[0].reset();
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("click", ".viewPackage", function () {
    let id = $(this).attr("data-pid");
    global_group_id = id;
    let groupName = $(this).attr("data-name");
    globalgroupName = groupName;
    let dataurl = "/admin/get-group-packages/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            populatePackageList(res.response);
            $(".package-list-modal-title").html(
                "Packages of Group : " + groupName
            );
            $("#PackageListTableModal").modal("show");
        } else {
            showNotification(res.message, "error");
        }
    });
});

function populatePackageList(list) {
    var tbody = $("#PackageListTableModal tbody");
    tbody.empty();
    if (list.length === 0) {
        var row =
            '<tr><td colspan="3" class="text-center">No Packages found</td></tr>';
        tbody.append(row);
    } else {
        list.forEach(function (package, index) {
            var sn = index + 1;
            var row =
                "<tr><td>" +
                sn +
                "</td><td>" +
                package.package_name +
                "</td><td>" +
                package.total_amount +
                "</td><td>" +
                '<a href="javascript:void(0)" class="btn btn-primary mx-1 editGroupPackageData" ' +
                'data-package_id="' +
                package.package_id +
                '" data-group_id="' +
                package.group_id +
                '">' +
                '<i class="fas fa-edit"></i></a>' +
                '<a href="javascript:void(0)" class="btn btn-danger deleteGroupPackageData" ' +
                'data-package_id="' +
                package.package_id +
                '" data-group_id="' +
                package.group_id +
                '">' +
                '<i class="fas fa-trash"></i></a>' +
                "</td>" +
                "</tr>";
            tbody.append(row);
        });
    }
}

$(document).on("click", ".editGroupPackageData", function () {
    let id = $(this).attr("data-group_id");
    let package_id = $(this).attr("data-package_id");
    // let groupName=$(this).attr('data-name')
    $("#group_id").val(id);
    $(".package-modal-title").html(
        "Edit Package Of Group : " + globalgroupName
    );
    $("#PackageFormModal").modal("show");
    $(".packageForm").attr("id", "packageForm");
    $("#packageForm")[0].reset();
    $("#PackageBtnSubmit").hide();
    $("#PackageBtnUpdate").show();
    $("#package_id").val(package_id).trigger("change");
});
$(document).on("click", ".deleteGroupPackageData", function (e) {
    e.preventDefault();
    let group_id = $(this).attr("data-group_id");
    let package_id = $(this).attr("data-package_id");
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            let currbtn = $(this);
            let dataurl = "delete-group-packages";
            var request = ajaxRequest(
                dataurl,
                { group_id, package_id },
                "delete"
            );
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
$(document).on("change", "#is_amount_different", function (e) {
    dependentedVal = $(this).is(":checked");
    if (dependentedVal) {
        // $('.differentInp').attr('required',true);
        $(".differentInpDiv").attr("hidden", false);
    } else {
        $(".differentInp").attr("required", false);
        $(".differentInpDiv").attr("hidden", true);
    }
});

function checkTotalPackageAmount() {
    let totalGroupAmount = $("#insurance_amount").val();
    let totalSum = 0;
    $(".headingAmount").each(function () {
        totalSum += parseFloat($(this).val()) || 0;
    });
    if (totalSum != totalGroupAmount) {
        // showNotification('Total Insured Amount Sould Be Equal To Heading Amount', 'error')
        $(".totalAmountErrorDIv").attr("hidden", false);
        // $('#btnSubmit').attr('disabled',true);
    } else {
        $(".totalAmountErrorDIv").attr("hidden", true);
        // $('#btnSubmit').attr('disabled',false);
    }
}
$(document).on("keyup", ".headingAmount", function () {
    checkTotalPackageAmount();
});

$(document).on("keyup", ".differentInp", function () {
    // console.log("keyup");
    let accordionId = $(this)
        .closest(".accordion-item")
        .parent(".accordion")
        .attr("data-id");
    updateTotal(accordionId);
});
$(document).on("click", ".form-check-info", function () {
    // console.log("click");
    let accordionId = $(this)
        .closest(".accordion-item")
        .parent(".accordion")
        .attr("data-id");
    updateTotal(accordionId);
});

function updateTotal(accordionId) {
    // console.log(accordionId);
    let ismore = false;
    let headingAmount =
        parseFloat(
            $("#accordionExample" + accordionId + " .headingAmount").val()
        ) || 0;
    let isDifferentCheck = $("#is_amount_different").is(":checked");
    $("#accordionExample" + accordionId + " .differentInp").each(function () {
        let $input = $(this);
        // console.log($input);
        let $checkbox = $input.closest(".col-md-2").find(".form-check-input");
        if ($checkbox.is(":checked")) {
            let val = parseFloat($input.val() || 0);
            // total +=val;
            if (isDifferentCheck && val > headingAmount) {
                ismore = true;
            }
        } else {
            $($input).attr("required", false);
        }
    });

    if (ismore) {
        showNotification(
            "Dependent 's insured amount can not be more then title's amount.",
            "error"
        );
        $("#btnSubmit").attr("disabled", true);
    } else {
        $("#btnSubmit").attr("disabled", false);
    }
}

$(document).on("change", ".view_limit_check", function () {
    let checked = $(this);
    let currentSubHId = [];
    let appendlimittype = checked
        .closest(".accordion-collapse")
        .find(".appendAccessType");
    if (checked.prop("checked")) {
        checked
            .closest(".accordion-collapse")
            .find(".appendAccessType")
            .each(function () {
                currentSubHId.push($(this).attr("id"));
            });
        appendlimittype.html(
            `
           <label for="" class="form-label">Access Type</label>
           <select class="form-select access_typeC" name="access_type[]" id="access_type" disabled>
            <option value="">Select one</option>
            <option value="fixed">Fixed</option>
            <option value="percentage">% of Total Sum</option>
            </select>

             <input type="number" class="form-control mt-2 mb-2 limit_numberC" id="limit_number" disabled name="limit_number[]" aria-describedby="helpId"   placeholder=""
            />
            `
        );
        // console.log(typeof limitTypeArr,typeof limitTypeArr !== undefined,limitTypeArr !=null,Array.isArray(limitTypeArr));
        if (typeof limitTypeArr !== undefined && limitTypeArr != null) {
            let filteredAccessDivs = currentSubHId.filter(function (div) {
                // Extract the number from the div name
                let number = div.replace("viewAccessDiv", "");
                // Check if the number exists as a key in the values object
                return limitTypeArr.hasOwnProperty(number);
            });
            filteredAccessDivs.forEach(function (div) {
                limitAppyS = $("#" + div);
                let subheadingid = div.replace("viewAccessDiv", "");
                limitAppyS
                    .closest(".subLimitRow")
                    .find(".access_typeC")
                    .val(limitTypeArr[subheadingid]);
            });
        }
        if (typeof limitArr !== undefined && limitArr != null) {
            let filteredAccessDivs = currentSubHId.filter(function (div) {
                // Extract the number from the div name
                let number = div.replace("viewAccessDiv", "");
                // Check if the number exists as a key in the values object
                return limitArr.hasOwnProperty(number);
            });
            filteredAccessDivs.forEach(function (div) {
                limitAppyS = $("#" + div);
                let subheadingidd = div.replace("viewAccessDiv", "");
                limitAppyS
                    .closest(".subLimitRow")
                    .find(".limit_numberC")
                    .val(limitArr[subheadingidd]);
                // console.log(limitAppyS,div,limitArr[subheadingidd]);
            });
        }
    } else {
        appendlimittype.html("");
    }
});
$(document).off("click", ".viewData", function () {});
$(document).on("click", ".viewData", function (e) {
    e.preventDefault();
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $("#ViewModal").modal("show");
            // $("#view_client").html(res.response.client.name);
            $("#view_name").html(res.response.name);
            $("#view_insurance_amount").html(res.response.insurance_amount);
            $("#view_code").html(res.response.code);
            $(".form-check-input").prop("checked", false);

            if (res.response.is_amount_different === "Y") {
                // $('.differentInp').attr('required',true);

                $("#view_is_amount_different").html("Yes");
                $(".viewDifferentInpDiv").attr("hidden", false);
            } else {
                $("#view_is_amount_different").html("No");
                $(".viewDifferentInpDiv").attr("hidden", true);
            }
            if (res.response.is_imitation_days_different === "Y") {
                $("#view_is_imitation_days_different").html("Yes");
                $(".differentImitationDaysDiv").removeAttr("hidden");
            } else {
                $("#view_is_imitation_days_different").html("No");
                $(".differentImitationDaysDiv").attr("hidden", true);
            }
            res.response.headings.forEach(function (valuerow) {
                var array = JSON.parse(valuerow.exclusive);
                limitTypeArr = JSON.parse(valuerow.limit_type);
                limitArr = JSON.parse(valuerow.limit);

                if (
                    typeof limitTypeArr !== "undefined" &&
                    Object.values(limitTypeArr).length > 0
                ) {
                    $("#view_limit_check" + valuerow.heading_id)
                        .prop("checked", true)
                        .trigger("change");
                } else {
                    $("#view_limit_check" + valuerow.heading_id)
                        .prop("checked", false)
                        .trigger("change");
                }
                $(
                    "#heading" + valuerow.heading_id + " .accordion-button"
                ).trigger("click");
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " .headingAmount"
                ).val(valuerow.amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " .headingImitationDays"
                ).val(valuerow.imitation_days);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_employee[]']"
                ).prop("checked", valuerow.is_employee == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_spouse[]']"
                ).prop("checked", valuerow.is_spouse == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_spouse_amount[]']"
                ).val(valuerow.is_spouse_amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_child[]']"
                ).prop("checked", valuerow.is_child == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_child_amount[]']"
                ).val(valuerow.is_child_amount);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_parent[]']"
                ).prop("checked", valuerow.is_parent == "Y" ? true : false);
                $(
                    "#accordionExample" +
                        valuerow.heading_id +
                        " input[name='view_is_parent_amount[]']"
                ).val(valuerow.is_parent_amount);
                array.forEach(function (value) {
                    $(
                        "#view_subHeading" + value + "_" + valuerow.heading_id
                    ).prop("checked", true);
                });
            });
            $(".sub_heading_id").trigger("change");
            $(".headingAmount").trigger("keyup");
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("change", "#client_id", function () {
    populate_members($("#client_id").find(":selected").val());
});
function populate_members(id, selected = null) {
    if (!id) {
        return;
    }
    let dataurl = "active-client-policies/" + id;
    var request = getRequest(dataurl);
    $('#policy_id option[value!=""]').remove();
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                $("#policy_id").append(
                    '<option value="' +
                        option.id +
                        '" data-id="' +
                        option.id +
                        '"' +
                        (isSelected ? " selected" : "") +
                        ">" +
                        option.policy_no +
                        "</option>"
                );
            });
        } else {
            showNotification(res.message, "error");
        }
    });
}
$(document).on("change", "#is_imitation_days_different", function (e) {
    is_imitation_days_differentVal = $(this).is(":checked");
    if (is_imitation_days_differentVal) {
        $(".differentImitationDaysDiv").removeAttr("hidden");
    } else {
        $(".differentImitationDaysDiv").attr("hidden", true);
    }
});
$(document).on("change", ".sub_heading_id", function (e) {
    let $subHeadingRow = $(this).closest(".sub_headingRow");
    // Check if any `.sub_heading_id` in this `.sub_headingRow` is checked
    let anyChecked = $subHeadingRow.find(".sub_heading_id:checked").length > 0;
    if (anyChecked && $("#is_imitation_days_different").is(":checked")) {
        $(this)
            .closest(".accordion-collapse")
            .find(".headingImitationDays")
            .prop("required", true);
    } else {
        $(this)
            .closest(".accordion-collapse")
            .find(".headingImitationDays")
            .prop("required", false);
    }
    let subheadingid = $(this).attr("value");
    $(this)
        .closest(".subLimitRow")
        .find(".access_typeC")
        .attr("name", `access_type[][${subheadingid}]`);
    $(this)
        .closest(".subLimitRow")
        .find(".limit_numberC")
        .attr("name", `limit_number[][${subheadingid}]`);
});
