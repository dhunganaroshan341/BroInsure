var serialNumber = 1;
let member_id = null;
let claim_id = null;
// let lot_id = null;
let relative_id = null;
let should_show_submit_claim = true;
// Get the current date
var currentDate = new Date();
// Get the date a week before
var weekBeforeDate = new Date();
weekBeforeDate.setDate(currentDate.getDate() - 7);
// Format the dates as YYYY-MM-DD
function formatDate(date) {
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var year = date.getFullYear();
    return year + "-" + month + "-" + day;
}
var global_from_date = $("#from_date").val();
var global_to_date = $("#to_date").val();
var formattedCurrentDate = formatDate(currentDate);
var formattedWeekBeforeDate = formatDate(weekBeforeDate);
$(document).ready(function () {
    // Set the values of the input fields
    $("#from_date").val(formattedWeekBeforeDate);
    $("#to_date").val(formattedCurrentDate);
    $("#fiscal_year_id, #group_id,#heading_id,#status").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
    // openScreeningModal(null);
    getData();
});
// $("#filterData").on(
//     "change",
//     'input:not(#global_search[type="text"]), select',
//     function () {
//         getData();
//     }
// );
// $("#filterData").on("keyup", 'input[type="text"]', function () {
//     getData();
// });
function getData() {
    if ($.fn.DataTable.isDataTable("#datatables-reponsive")) {
        $("#mainTableForm tfoot").addClass("d-none");
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive").DataTable().destroy();
    }
    global_from_date = $("#from_date").val();
    global_to_date = $("#to_date").val();
    $("#datatables-reponsive").DataTable({
        // fixedColumns: {
        //     leftColumns: 1,
        //     rightColumns: 1
        // },
        // scrollCollapse: true,
        // scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "claimscreening",
            type: "GET",
            data: {
                fiscal_year_id: $("#fiscal_year_id").val(),
                from_date: $("#from_date").val(),
                to_date: $("#to_date").val(),
                status: $("#status").val(),
                client_id: $("#client_id").val(),
                group_id: $("#group_id").val(),
                heading_id: $("#heading_id").val(),
                // lot_id: $("#lot_id").val(),
                global_search: $("#global_search").val(),
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1, 2],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1, 2],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1, 2],
                },
            },
        ],

        columns: [
            // {
            //     data: null,
            //     render: function (data, type, row, meta) {
            //         var pageIndex = meta.settings._iDisplayStart;
            //         var index = pageIndex + meta.row + 1;
            //         if (row.register_no === null) {
            //             return (
            //                 '<input type="checkbox" name="insurance_claim_id[]" class="claim-checkbox insurance_claim_id" value="' +
            //                 row.id +
            //                 '"> ' +
            //                 index
            //             );
            //         } else {
            //             return index;
            //         }
            //     },
            //     orderable: false,
            //     searchable: false,
            //     width: "10%",
            // },
            {
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.submission_count > 1) {
                        return (
                            data +
                            ' <small title="No of Submission">(' +
                            row.submission_count +
                            ")</small>"
                        );
                    }
                    return data; // No need to append anything if submission_count <= 1
                },
            },

            // { data: "lot_no" },
            { data: "member_id" },
            { data: "member_name" },
            { data: "dependent_name" },
            { data: "relation" },
            { data: "dob" },
            { data: "claim_title" },
            { data: "claim_date" },
            { data: "client_name" },
            { data: "group" },
            { data: "file_no" },
            // { data: "branch" },
            // { data: "designation" },
            { data: "id" },
            { data: "clinical_facility_name" },
            { data: "bill_amount" },
            { data: "submitted_by" },
            // { data: "diagnosis_treatment" },
            { data: "action" },
        ],
    });
}
$(document).on("click", "#resetData", function () {
    // Reset input fields, textareas, selects, and checkboxes
    $("#filterData")
        .find('input[type="text"], input[type="date"], textarea')
        .val("");
    // Reset input fields, textareas, and selects
    $("#from_date").val(formattedWeekBeforeDate);
    $("#to_date").val(formattedCurrentDate);
    // Reset checkboxes
    $("#filterData").find('input[type="checkbox"]').prop("checked", false);
    // Trigger change event for select elements
    $("#filterData").find("select").val("").trigger("change");
});
$(document).on("click", "#cancelBtn", function () {
    $("#scrutinyModal").modal("hide");
});

$(document).on("click", "#mainTableForm #registerBtn", function (e) {
    e.preventDefault();
    let checkedCount = $(
        'input[type="checkbox"].insurance_claim_id:checked'
    ).length;
    if (checkedCount <= 0) {
        showNotification(
            "Please select the items that you want to register.",
            "error"
        );
        return;
    }
    $("#registerBtn").prop("disabled", true);
    let dataurl = $("#mainTableForm").attr("action");
    // Create a FormData object to store data
    let postdata = new FormData();
    // Iterate over each checkbox that is checked
    $("#mainTableForm")
        .find('input[type="checkbox"][name="insurance_claim_id[]"]:checked')
        .each(function () {
            // Append all other input elements' name and value to FormData
            postdata.append($(this).attr("name"), $(this).val());
        });

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        $("#registerBtn").prop("disabled", false);
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#mainTableForm")
                .find(
                    'input[type="checkbox"][name="insurance_claim_id[]"]:checked'
                )
                .each(function () {
                    $(this).closest("tr").remove();
                });
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        $("#registerBtn").prop("disabled", false);
    });
});

$("#mainTableForm").on(
    "change",
    'input[type="checkbox"][name="insurance_claim_id[]"]',
    function () {
        // Count checked checkboxes
        var checkedCount = $(
            '#mainTableForm input[type="checkbox"][name="insurance_claim_id[]"]:checked'
        ).length;
        if (checkedCount > 0) {
            $("#mainTableForm tfoot").removeClass("d-none");
        } else {
            $("#mainTableForm tfoot").addClass("d-none");
        }
    }
);

$(document).off("click", ".previewData", function () {});
$(document).on("click", ".previewData", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    let relative_id = $(this).attr("data-relative_id");
    let claim_id = $(this).attr("data-claim_id");
    let dataurl = $(this).attr("data-url");
    postdata = {
        fiscal_year_id: $("#fiscal_year_id").val(),
        // from_date: $("#from_date").val(),
        // to_date: $("#to_date").val(),
        status: $("#status").val(),
        // client_id: $("#client_id").val(),
        // group_id: $("#group_id").val(),
        // heading_id: $("#heading_id").val(),
        // lot_id: $("#lot_id").val(),
        global_search: $("#global_search").val(),
        member_id: id,
        type: "screening",
        claim_ids: claim_id,
        // relative_id: relative_id ? relative_id : "",
    };
    var request = ajaxRequest(
        "claimscreening/claims-member",
        postdata,
        "GET",
        false
    );
    request.done(function (res) {
        if (res.status === true) {
            // showNotification(res.message, "success");
            $("#viewEditModal").replaceWith(res.html);
            $("#viewEditModal").modal("show");
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).on("change", "#client_id", function () {
    let client_id = $("#client_id").find(":selected").val();
    populateGroup(client_id);
});

function populateGroup(id, selected = null) {
    $('#group_id option[value!=""]').remove();
    let dataurl = "get-client-groups/" + id;
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                // $('#district').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
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
        } else {
            showNotification(res.message, "error");
        }
    });
}
// $(document).on(
//     "change",
//     "#group_id,#fiscal_year_id,#heading_id,#status,#from_date,#to_date",
//     function () {
//         let group_id = $("#group_id").find(":selected").val();
//         if (group_id) {
//             var selectedValue = $("#lot_id").val();
//             if (!selectedValue) {
//                 selectedValue = null;
//             }
//             populateLot(group_id, selectedValue);
//         }
//     }
// );

// function populateLot(id, selected = null) {
//     $('#lot_id option[value!=""]').remove();
//     // let fiscal_id=  id;
//     let group_id = id;
//     let from_date = $("#from_date").val();
//     let to_date = $("#to_date").val();
//     let client_id = $("#client_id").find(":selected").val();
//     let heading_id = $("#heading_id").find(":selected").val();
//     let type = "registered";
//     $("#lot_id").html("");
//     $("#lot_id").append('<option value="" selected="">Select Lot </option>');
//     $.ajax({
//         url: "get-group-lots", // Replace with your API endpoint
//         type: "GET",
//         data: { client_id, group_id, from_date, to_date, heading_id, type },
//         success: function (res) {
//             if (res.status === true) {
//                 $.each(res.response, function (index, option) {
//                     var isSelected =
//                         selected !== null &&
//                         option.id.toString() === selected.toString();
//                     // $('#district').append('<option value="' + option.id + '"' + (isSelected ? ' selected' : '') + '>' + option.name + '</option>');
//                     $("#lot_id").append(
//                         '<option value="' +
//                             option.id +
//                             '" data-id="' +
//                             option.id +
//                             '"' +
//                             (isSelected ? " selected" : "") +
//                             ">" +
//                             option.id +
//                             "</option>"
//                     );
//                 });
//             }
//         },
//         error: function (res) {
//             showNotification(res.message, "error");
//         },
//     });
// }

$(document).on("click", "#searchData", function (e) {
    e.preventDefault();
    let client_id = $("#client_id").find(":selected").val();
    let group_id = $("#group_id").find(":selected").val();
    // let lot_id = $("#lot_id").find(":selected").val();
    // if (!client_id || !group_id ) {
    //     if (!client_id) {
    //         showNotification("Select Client First.", "error");
    //     } else if (!group_id) {
    //         showNotification("Select Group First.", "error");
    //     }
    //     // else if (!lot_id) {
    //     //     showNotification("Select Lot First.", "error");
    //     // }
    //     else {
    //         showNotification("something went wrong.", "error");
    //     }
    // } else {
    getData();
    // }
});
$(document).on("click", ".scrutinyBtn", function () {
    // member_id = $(this).data("pid")
    // relative_id = $(this).data("relative_id")
    // lot_id = $(this).data("pid")
    openScreeningModal(this);
    $('.sticky-sidebar').attr('hidden',false);
});
$('#scrutinyModal').on('hidden.bs.modal', function () {
    $('.sticky-sidebar').attr('hidden',true);
  })
function openScreeningModal(element) {
    member_id = $(element).attr("data-pid");
    claim_id = $(element).attr("data-claim_id");
    // member_id = 1;
    relative_id = $(element).attr("data-relative_id");
    // relative_id = null;
    // lot_id = $("#lot_id").find(":selected").val();
    // lot_id = 1;
    should_show_submit_claim = true;
    let from_date = $("#from_date").val();
    let to_date = $("#to_date").val();
    $.ajax({
        url: "get-member-claims",
        type: "get",
        data: {
            member_id,
            claim_id,
            relative_id: relative_id ? relative_id : "",
            // lot_id,
            from_date,
            to_date,
            type: "screening",
        },
        success: function (res) {
            if (res.status === true) {
                $(".toBeAdeedDynamically").empty();
                $(".toBeAdeedDynamically").html(res.response.html);
                $("#scrutinyModal").modal("show");
            }
        },
        error: function (res) {
            showNotification(res.message, "error");
        },
    });
}
$(document).on(
    "keyup",
    "#scrutiny_bill_amount, #scrutiny_approved_amount",
    function (e) {
        let bill_amount = $("#scrutiny_bill_amount").val();
        let approved_amount = $("#scrutiny_approved_amount").val();
        let deduction_amount = bill_amount - approved_amount;
        if (deduction_amount < 0) {
            $(".addBtnOfCal").attr("disabled", true);
            $("#scrutiny_deduction").val(0).trigger("change");
            $("#misMatchSpan").prop("hidden", false);
        } else {
            $(".addBtnOfCal").attr("disabled", false);
            $("#scrutiny_deduction").val(deduction_amount).trigger("change");
            $("#misMatchSpan").prop("hidden", true);
        }
    }
);
$(document).on(
    "change",
    "#scrutiny_deduction, #scrutiny_edit_deduction",
    function (e) {
        let deduction_amount = $(this).val();
        let id = $(this).attr("id");
        if (id == "scrutiny_deduction") {
            $("#scrutiny_remarks").css("border-color", "");
            if (deduction_amount == 0) {
                $("#scrutiny_remarks")
                    .closest(".form-group")
                    .find("label span")
                    .text("");
                $("#scrutiny_remarks").prop("required", false);
                if ($("#scrutiny_remarks").attr("data-required")) {
                    $("#scrutiny_remarks").attr("data-required", false);
                }
            } else {
                $("#scrutiny_remarks")
                    .closest(".form-group")
                    .find("label span")
                    .text("*");
                $("#scrutiny_remarks").prop("required", true);
                if ($("#scrutiny_remarks").attr("data-required")) {
                    $("#scrutiny_remarks").attr("data-required", true);
                }
            }
        } else if (id == "scrutiny_edit_deduction") {
            $("#scrutiny_edit_remarks").css("border-color", "");
            if (deduction_amount == 0) {
                $("#scrutiny_edit_remarks")
                    .closest(".form-group")
                    .find("label span")
                    .text("");
                $("#scrutiny_edit_remarks").prop("required", false);
                if ($("#scrutiny_edit_remarks").attr("data-required")) {
                    $("#scrutiny_edit_remarks").attr("data-required", false);
                }
            } else {
                $("#scrutiny_edit_remarks")
                    .closest(".form-group")
                    .find("label span")
                    .text("*");
                $("#scrutiny_edit_remarks").prop("required", true);
                if ($("#scrutiny_edit_remarks").attr("data-required")) {
                    $("#scrutiny_edit_remarks").attr("data-required", true);
                }
            }
        }
    }
);
$(document).on(
    "keyup",
    "#scrutiny_edit_bill_amount, #scrutiny_edit_approved_amount",
    function (e) {
        let bill_amount = $("#scrutiny_edit_bill_amount").val();
        let approved_amount = $("#scrutiny_edit_approved_amount").val();
        let deduction_amount = bill_amount - approved_amount;
        if (deduction_amount < 0) {
            $("#btnRecordUpdate").attr("disabled", true);
            $("#scrutiny_edit_deduction").val(0).trigger("change");
            $("#misMatchSpanModal").prop("hidden", false);
        } else {
            $("#btnRecordUpdate").attr("disabled", false);
            $("#scrutiny_edit_deduction")
                .val(deduction_amount)
                .trigger("change");
            $("#misMatchSpanModal").prop("hidden", true);
        }
    }
);

$(document).on("submit", "#scrutinyForm", function (e) {
    e.preventDefault();
    // Validate form data
    var isValid = true;
    $("#scrutinyForm input, #scrutinyForm select").each(function () {
        var isRequired =
            $(this).prop("required") || $(this).data("required") === true;
        var value = $(this).val();
        if (isRequired && ($(this).val() === "" || $(this).val() === null)) {
            isValid = false;
            $(this).attr("style", "border-color: #dc3545 !important");
            $(this)
                .next(".select2-container")
                .find(".select2-selection")
                .attr("style", "border-color: #dc3545 !important");
        } else {
            $(this).css("border-color", "");
            $(this)
                .next(".select2-container")
                .find(".select2-selection")
                .css("border-color", "");
        }
        if ($(this).attr("name") === "file" && isRequired) {
            var file = $(this)[0].files[0];
            if (file) {
                var fileType = file.type;
                var validTypes = [
                    "application/pdf",
                    "image/jpeg",
                    "image/png",
                    "image/jpg",
                ];
                if (!validTypes.includes(fileType)) {
                    isValid = false;
                    $(this).attr("style", "border-color: #dc3545 !important");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .attr("style", "border-color: #dc3545 !important");
                } else {
                    $(this).css("border-color", "");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .css("border-color", "");
                }
            }
        }
        // Additional validation for bill_amount
        if ($(this).attr("name") === "bill_amount" && isRequired) {
            if (isNaN(value) || value <= 0) {
                isValid = false;
                $(this).attr("style", "border-color: #dc3545 !important");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "#dc3545");
            } else {
                $(this).css("border-color", "");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "");
            }
        }
    });

    if (!isValid) {
        $("#addDataToTableAdd").prop("disabled", false);
        $("#addDataToTableAdd").html(
            $("#addDataToTableAdd").data("original-text")
        );
        showNotification(
            "Please fill valid data in all required fields..",
            "error"
        );
        return;
    }
    // Get input values
    var bill_no = $("#scrutiny_bill_no").val();
    var title_text = $("#scrutiny_title option:selected").text();
    var title_id = $("#scrutiny_title option:selected").val();
    var bill_amount = $("#scrutiny_bill_amount").val();
    var approved_amount = $("#scrutiny_approved_amount").val();
    var deduction = $("#scrutiny_deduction").val();
    var remarks = $("#scrutiny_remarks").val();
    var billFileInput = $("#scrutiny_file")[0].files[0];

    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileName = billFile;
    var uniqueId = "bill_file_scrunity" + Date.now() + "_" + Date.now();

    // serialNumber = parseInt(serialNumber);
    serialNumber = 1;
    let maxRowNo = null;

    $("#addDataToTable tr").each(function () {
        // Get the data-rowno attribute
        let rowNo = parseInt($(this).data("rowno"), 10);
        if (rowNo > maxRowNo) {
            maxRowNo = rowNo;
        }
    });
    if (maxRowNo != null) {
        serialNumber = parseInt(maxRowNo);
        serialNumber++;
    }
    showEditDeleteButtons =
        window.location.href.indexOf("claimscreening") > -1 ? "" : "d-none";
    // Append a new row to the table
    var newRow =
        '<tr data-rowno="' +
        serialNumber +
        '"' +
        ' id="scrutiny_row' +
        serialNumber +
        '">' +
        "<td><span class='scrutiny_sn'>" +
        serialNumber +
        "</span>" +
        // '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
        "</td>" +
        `<td id="scrutiny_bill_no${serialNumber}">` +
        `<span>${bill_no}</span>` +
        '<input type="hidden" name="bill_no[]" value="' +
        bill_no +
        '" /></td>' +
        `<td id="scrutiny_file${serialNumber}">
            <a href="${billFileURL}" target="_blank">${billFileName}</a>
            <span class="d-none">
                <input type="file" name="files[]" id="${uniqueId}">
            </span>
        </td>` +
        `<td id="scrutiny_title_id${serialNumber}">` +
        `<span>${title_text}</span>` +
        '<input type="hidden" name="heading_id[]" value="' +
        title_id +
        '" /></td>' +
        `<td id="scrutiny_bill_amount${serialNumber}">` +
        `<span>${bill_amount}</span>` +
        '<input type="hidden" name="bill_amount[]" value="' +
        bill_amount +
        '" /></td>' +
        `<td id="scrutiny_approved_amount${serialNumber}">` +
        `<span>${approved_amount}</span>` +
        '<input type="hidden" name="approved_amount[]" value="' +
        approved_amount +
        '" /></td>' +
        `<td id="scrutiny_deduction${serialNumber}">` +
        `<span>${deduction}</span>` +
        '<input type="hidden" name="deduct_amount[]" value="' +
        deduction +
        '" /></td>' +
        `<td id="scrutiny_remarks${serialNumber}">` +
        `<span>${remarks}</span>` +
        '<input type="hidden" name="remarks[]" value="' +
        remarks +
        '" />' +
        "</td>" +
        "<td>" +
        `<input type="hidden" name="scrunity_details_ids[]" value="">` +
        `<button type="button" class="btn btn-primary btn-sm scrutinyViewRow" data-row_no="${serialNumber}"><i class="fas fa-eye"></i> View</button>` +
        `<button type="button" class="btn btn-warning btn-sm text-white scrutinyEditRow ${showEditDeleteButtons}" data-row_no="${serialNumber}"><i class="fas fa-edit"></i> Edit</button> ` +
        `<button type="button" class="btn btn-danger btn-sm deleteRow ${showEditDeleteButtons}" data-row_no="${serialNumber}"><i class="fas fa-trash"></i> Delete</button>` +
        "</td>" +
        "</tr>";

    $(newRow).insertBefore("#total_row");
    var fileInput1 = $("#scrutiny_file")[0];
    var file = fileInput1.files[0];

    if (file) {
        // Create a new DataTransfer object
        var dataTransfer = new DataTransfer();
        // Add the selected file to the DataTransfer object
        dataTransfer.items.add(file);
        // Get the second file input and assign the files from DataTransfer object
        var fileInput2 = $("#" + uniqueId)[0];
        fileInput2.files = dataTransfer.files;
    }

    if (serialNumber >= 1) {
        $("#addDataToTable tfoot").removeClass("d-none");
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
    }
    // Increment the serial number for the next row
    serialNumber++;

    // Optionally, reset the form
    this.reset();
    refreshScrutinyTotal();
    refreshScrutinySn();
    filterSubmitClaimButton();
    $("#addDataToTableAdd").prop("disabled", false);
    $("#addDataToTableAdd").html($("#addDataToTableAdd").data("original-text"));
    showNotification("Data Added Sucessfully.", "success");
    $("#heading_id, #sub_heading_id").trigger("change");
});

function refreshScrutinyTotal() {
    let inputs = ["bill_amount", "approved_amount", "deduct_amount"];
    for (let input of inputs) {
        let total = 0;
        $(`input[name="${input}[]"]`).each(function () {
            // Append all other input elements' name and value to FormData
            total += parseInt($(this).val());
        });
        $(`#scrutiny_total_${input}`).text(total);
    }
}

function refreshScrutinySn() {
    let sn = 1;

    $(`.scrutiny_sn`).each(function () {
        $(this).text(sn++);
    });
    if ($(".scrutiny_sn").length >= 1) {
        $("#addDataToTable tfoot").removeClass("d-none");
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
    }
}

$(document).on("click", ".deleteRow", function deleteScrutinyRow(e) {
    let currbtn = $(this);
    let scrunity_details_id = currbtn.data("scrunity_details_id");
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            if (scrunity_details_id) {
                let dataurl = currbtn.attr("data-url");
                let token = $("input[name='_token']").val();
                var request = ajaxRequest(dataurl, { _token: token }, "DELETE");
                request.done(function (res) {
                    if (res.status === true) {
                        $("#scrutiny_row" + currbtn.data("row_no")).remove();
                        refreshScrutinyTotal();
                        refreshScrutinySn();
                    } else {
                        showNotification(res.message, "error");
                    }
                });
            } else {
                $("#scrutiny_row" + currbtn.data("row_no")).remove();
                refreshScrutinyTotal();
                refreshScrutinySn();
            }
        } else {
            swal("Your Data Is Safe!");
        }
        return;
        $("#scrutiny_row" + $(this).data("row_no")).remove();
        refreshScrutinyTotal();
        refreshScrutinySn();
    });
});
$(document).off("submit", "#submitClaimForm", function (e) {
    e.preventDefault();
    return;
});
$(document).off(
    "click",
    "#submitClaimForm #saveAsDraftlBtn,#submitClaimForm #saveSubmitClaim",
    function () {}
);
$(document).on(
    "click",
    "#submitClaimForm #saveAsDraftlBtn,#submitClaimForm #saveSubmitClaim",
    function (e) {
        e.preventDefault();
        $(".btnsendData").prop("disabled", true);
        let btnId = $(this).attr("id");
        let saveType;
        if (btnId == "saveAsDraftlBtn") {
            saveType = "draft";
        } else if (btnId == "saveSubmitClaim") {
            saveType = "request";
        } else {
            saveType = null;
        }
        let formData = new FormData($("#submitClaimForm")[0]);
        formData.append("status", saveType);
        formData.append("member_id", member_id);
        formData.append("claim_id", claim_id);
        formData.append("relative_id", relative_id ? relative_id : "");
        // Iterate through each file input element
        $("input[name='files[]']").each(function (index) {
            if (this.files && this.files.length > 0) {
                let file = this.files[0]; // Get the file at the current index
                formData.append(`scrunity_files[${index}]`, file);
            } else {
                formData.append(`scrunity_files[${index}]`, null);
            }
        });
        // formData.append("lot_id", lot_id);
        var request = ajaxRequest("claimscreening", formData, "POST", true);
        request.done(function (res) {
            if (res.status === true) {
                showNotification(res.message, "success");
                $("#scrutinyModal").modal("hide");
                $("#datatables-reponsive").dataTable().fnClearTable();
                $("#datatables-reponsive").dataTable().fnDestroy();
                getData();
            } else {
                showNotification(res.message, "error");
            }
            $(".btnsendData").prop("disabled", false);
        });
        request.fail(function (jqXHR, textStatus, errorThrown) {
            $(".btnsendData").prop("disabled", false);
        });
    }
);

$(document).on("click", ".scrutinyEditRow", function (e) {
    $("#scrutinyEditModalButtons").removeClass("d-none");
    $("#scrutinyEditRowForm").prop("inert", false);
    // Disable all form elements inside #scrutinyEditRowForm
    $("#scrutinyEditRowForm")
        .find("input, select, textarea, button")
        .prop("disabled", false);
    if ($(this).is("[data-scrunity_details_id]")) {
        $("#scrutiny_edit_file").removeAttr("data-required");
        $("#scrutiny_edit_file").removeAttr("required");
    } else {
        $("#scrutiny_edit_file").attr("data-required", true);
        $("#scrutiny_edit_file").attr("required", true);
    }
    populateScrunityEditModal($(this).data("row_no"));
});

$(document).on("click", ".scrutinyViewRow", function (e) {
    $("#scrutinyEditModalButtons").addClass("d-none");
    // Disable all form elements inside #scrutinyEditRowForm
    $("#scrutinyEditRowForm")
        .find("input, select, textarea, button")
        .prop("disabled", true);
    populateScrunityEditModal($(this).data("row_no"));
});

$(document).on("click", ".scrutinyEditRow", function (e) {
    $("#scrutinyEditRowForm").prop("inert", false);
    // Disable all form elements inside #scrutinyEditRowForm
    $("#scrutinyEditRowForm")
        .find("input, select, textarea, button")
        .prop("disabled", false);
    populateScrunityEditModal($(this).data("row_no"));
});

function populateScrunityEditModal(row_no) {
    $("#current_scrutiny_edit_row_no").val(row_no);
    $("#scrutiny_edit_bill_no").val(
        $(`#scrutiny_bill_no${row_no} input`).val()
    );
    $("#scrutiny_edit_title_id").val(
        $(`#scrutiny_title_id${row_no} input`).val()
    );
    $("#scrutiny_edit_title_id").trigger("change");
    $("#scrutiny_edit_bill_amount").val(
        $(`#scrutiny_bill_amount${row_no} input`).val()
    );
    $("#scrutiny_edit_approved_amount").val(
        $(`#scrutiny_approved_amount${row_no} input`).val()
    );
    $("#scrutiny_edit_deduction")
        .val($(`#scrutiny_deduction${row_no} input`).val())
        .trigger("change");
    $("#scrutiny_edit_remarks").val(
        $(`#scrutiny_remarks${row_no} input`).val()
    );

    $("#scrutiny_file_section").html("");
    $("#scrutiny_edit_file").val("");
    if (
        $(`#scrutiny_file${row_no}`).find('input[name="file_url[]"]').length > 0
    ) {
        var billFileURL = $(`#scrutiny_file${row_no} input`)
            .attr("name", "file_url[]")
            .val();
        if (billFileURL) {
            $("#scrutiny_file_section").html(
                '<a href="' + billFileURL + '" target="_blank" > View File</a>'
            );
        }
    } else {
        var fileInput1 = $(`#scrutiny_file${row_no} input`).attr(
            "name",
            "files[]"
        )[0];
        var file = fileInput1.files[0];

        if (file) {
            // Create a new DataTransfer object
            var dataTransfer = new DataTransfer();
            // Add the selected file to the DataTransfer object
            dataTransfer.items.add(file);
            // Get the second file input and assign the files from DataTransfer object
            var fileInput2 = $("#scrutiny_edit_file")[0];
            fileInput2.files = dataTransfer.files;
            var billFileInput = file;
            var billFileURL = billFileInput
                ? URL.createObjectURL(billFileInput)
                : "";
            $("#scrutiny_file_section").html(
                '<a href="' + billFileURL + '" target="_blank" > View File</a>'
            );
        }
    }

    $("#scrutinyModal").addClass("modal-backdrop");
    $("#scrutinyModal").css("opacity", "1");
    $("#scrutinyRowEditModal").modal("show");
}

$(document).on("click", "#scrutinyEditRowForm #btnRecordUpdate", function (e) {
    e.preventDefault();
    var isValid = true;
    $("#scrutinyEditRowForm input, #scrutinyEditRowForm select").each(
        function () {
            var isRequired =
                $(this).prop("required") || $(this).data("required") === true;
            var value = $(this).val();
            if (
                isRequired &&
                ($(this).val() === "" || $(this).val() === null)
            ) {
                isValid = false;
                $(this).attr("style", "border-color: #dc3545 !important");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "#dc3545");
            } else {
                $(this).css("border-color", "");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "");
            }
            if ($(this).attr("name") === "file" && isRequired) {
                var file = $(this)[0].files[0];
                if (file) {
                    var fileType = file.type;
                    var validTypes = [
                        "application/pdf",
                        "image/jpeg",
                        "image/png",
                        "image/jpg",
                    ];
                    if (!validTypes.includes(fileType)) {
                        isValid = false;
                        $(this).attr(
                            "style",
                            "border-color: #dc3545 !important"
                        );
                        $(this)
                            .next(".select2-container")
                            .find(".select2-selection")
                            .attr("style", "border-color: #dc3545 !important");
                    } else {
                        $(this).css("border-color", "");
                        $(this)
                            .next(".select2-container")
                            .find(".select2-selection")
                            .css("border-color", "");
                    }
                }
            }

            // Additional validation for bill_amount
            if ($(this).attr("name") === "bill_amount" && isRequired) {
                if (isNaN(value) || value <= 0) {
                    isValid = false;
                    $(this).attr("style", "border-color: #dc3545 !important");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .css("border-color", "#dc3545");
                } else {
                    $(this).css("border-color", "");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .css("border-color", "");
                }
            }
        }
    );

    if (!isValid) {
        showNotification(
            "Please fill valid data in all required fields..",
            "error"
        );
        return;
    }
    let row_no = $("#current_scrutiny_edit_row_no").val();
    let inputs = [
        "bill_no",
        "title_id",
        "bill_amount",
        "approved_amount",
        "deduction",
        "remarks",
    ];
    for (let id of inputs) {
        if (id == "title_id") {
            $(`#scrutiny_${id}${row_no} span`).text(
                $(`#scrutiny_edit_${id} :selected`).text()
            );
            $(`#scrutiny_${id}${row_no} input`).val(
                $(`#scrutiny_edit_${id}`).val()
            );
            continue;
        }
        $(`#scrutiny_${id}${row_no} span`).text(
            $(`#scrutiny_edit_${id}`).val()
        );
        $(`#scrutiny_${id}${row_no} input`).val(
            $(`#scrutiny_edit_${id}`).val()
        );
    }
    var billFileInput = $("#scrutinyRowEditModal").find(
        'input[name="files"]'
    )[0].files[0];
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    var billFileName = billFile;
    var uniqueId = "bill_file_scrunity" + Date.now() + "_" + Date.now();
    $(`#scrutiny_file${row_no}`).html("");
    $(
        `#scrutiny_file${row_no}`
    ).html(`<a href="${billFileURL}" target="_blank">${billFileName}</a>
            <span class="d-none">
                <input type="file" name="files[]" id="${uniqueId}">
            </span>`);

    // Get the selected file from the first input
    var fileInput1 = $("#scrutinyRowEditModal").find('input[name="files"]')[0];
    var file = fileInput1.files[0];

    if (file) {
        // Create a new DataTransfer object
        var dataTransfer = new DataTransfer();
        // Add the selected file to the DataTransfer object
        dataTransfer.items.add(file);
        // Get the second file input and assign the files from DataTransfer object
        var fileInput2 = $("#" + uniqueId)[0];
        fileInput2.files = dataTransfer.files;
    }
    refreshScrutinyTotal();
    $("#scrutinyModal").removeClass("modal-backdrop");
    $("#scrutinyModal").css("opacity", "");
    $("#scrutinyRowEditModal").modal("hide");
});
$("#scrutinyRowEditModal").on("hidden.bs.modal", function () {
    $("#scrutinyModal").removeClass("modal-backdrop");
    $("#scrutinyModal").css("opacity", "");
});
$(document).on("click", ".balance-button-container button", function (e) {
    let type = $(this).data("type");
    $(".modal.show").css("display", "none");
    swal({
        title: "Are you sure?",
        text: "Once you do this, you will not be able to submit for claims!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        content: {
            element: "textarea",
            attributes: {
                placeholder: "Enter your reason here...",
                rows: 5,
                cols: 50,
                id: "remarksTextArea",
                style: "outline: none; border: 1px solid #6db8ff; padding: 8px;",
            },
        },
    }).then((willDelete) => {
        $(".modal.show").css("display", "block");
        if (willDelete) {
            let reason = document
                .getElementById("remarksTextArea")
                .value.trim();

            // Validate textarea
            if (reason === "") {
                showNotification("Please enter a reason.", "error");
                return; // Exit function if textarea is empty
            }
            let postdata = {
                type: type,
                member_id: member_id,
                // lot_no: lot_id,
                claim_id: claim_id,
                relative_id: relative_id ? relative_id : "",
                remarks: reason,
                from_date: global_from_date,
                to_date: global_to_date,
            };
            var request = ajaxRequest("claim-status-change", postdata, "POST");
            request.done(function (res) {
                if (res.status === true) {
                    showNotification(res.message, "success");
                    should_show_submit_claim = false;
                    filterSubmitClaimButton();
                    $("#searchData").trigger("click");
                    if (type == "release" || type == "hold") {
                        $(
                            ".scrutinyBtn[data-claim_id='" + claim_id + "']"
                        ).trigger("click");
                    } else {
                        $("#scrutinyModal").modal("hide");
                    }
                } else {
                    showNotification(res.message, "error");
                }
            });
        } else {
            swal("Your Data Is Safe!");
        }
    });
});

function filterSubmitClaimButton() {
    !should_show_submit_claim ? $("#saveSubmitClaim").remove() : null;
}
$(document).on("click", ".vefify", function (e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append("member_id", member_id);
    formData.append("relative_id", relative_id);
    // formData.append("lot_id", lot_id);
    var request = ajaxRequest("claimscreening-settle", formData, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("click", ".clearScrunityForm", function (e) {
    e.preventDefault();
    $("#misMatchSpan").prop("hidden", true);
    $("#scrutinyForm input, #scrutinyForm select").val("").trigger("change");
});
