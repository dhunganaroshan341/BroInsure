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
        $(".RegisterDiv").addClass("d-none");
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive").DataTable().destroy();
    }
    $("#datatables-reponsive").DataTable({
        fixedColumns: {
            start: 1,
        },
        //     paging: false,
        // scrollCollapse: true,
        // scrollX: true,
        // scrollY: 300,
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "claimregistration",
            type: "GET",
            data: {
                fiscal_year_id: $("#fiscal_year_id").val(),
                from_date: $("#from_date").val(),
                to_date: $("#to_date").val(),
                status: $("#status").val(),
                client_id: $("#client_id").val(),
                // lot_id: $("#lot_id").val(),
                group_id: $("#group_id").val(),
                heading_id: $("#heading_id").val(),
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
            {
                data: null,
                render: function (data, type, row, meta) {
                    // Calculate the correct row index across pages
                    var pageIndex = meta.settings._iDisplayStart;
                    var index = pageIndex + meta.row + 1;
                    if (row.register_no === null) {
                        return (
                            '<input type="checkbox" name="insurance_claim_id[]" class="claim-checkbox insurance_claim_id" value="' +
                            row.id +
                            '"' +
                            ` data-insurance_claim_ids="${row.insurance_claim_ids}"` +
                            '> ' +
                            index
                        );
                    } else {
                        return index;
                    }
                },
                orderable: false,
                searchable: false,
                width: "10%",
            },
            // { data: "lot_no" },
            { data: "claim_id" },
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
    $('input[type="checkbox"].insurance_claim_id:checked').prop(
        "checked",
        false
    );
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
    let insurance_claim_ids = [];
    $("#mainTableForm")
        .find('input[type="checkbox"][name="insurance_claim_id[]"]:checked')
        .each(function () {
            // Append all other input elements' name and value to FormData
            let insurance_claim_ids_str = $(this).data("insurance_claim_ids");
            insurance_claim_ids.push(
                ...insurance_claim_ids_str.toString().split(",")
            );
        });
    postdata.append("insurance_claim_id", JSON.stringify(insurance_claim_ids));

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
            $(".RegisterDiv").removeClass("d-none");
        } else {
            $(".RegisterDiv").addClass("d-none");
        }
    }
);

$(document).off("click", ".previewData", function () {});
$(document).on("click", ".previewData", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    // let relative_id = $(this).attr("data-relative_id");
    let dataurl = $(this).attr("data-url");
    postdata = {
        fiscal_year_id: $("#fiscal_year_id").val(),
        // from_date: $("#from_date").val(),
        // to_date: $("#to_date").val(),
        status: $("#status").val(),
        client_id: $("#client_id").val(),
        // group_id: $("#group_id").val(),
        // heading_id: $("#heading_id").val(),
        // lot_id: $("#lot_id").val(),
        global_search: $("#global_search").val(),
        member_id: id,
        type:'register',
        claim_ids: $(this).attr("data-claim_id"),
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
//     let type = "received";
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
    // if (!client_id || !group_id || !lot_id) {
    // if (!client_id || !group_id) {
    //     if (!client_id) {
    //         showNotification("Select Client First.", "error");
    //     } else if (!group_id) {
    //         showNotification("Select Group First.", "error");
    //     } 
    //     // else if (!lot_id) {
    //     //     showNotification("Select Lot First.", "error");
    //     // }
    //      else {
    //         showNotification("something went wrong sdfsdf.", "error");
    //     }
    // } else {
        getData();
    // }
});
