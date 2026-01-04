let select_subheading_id = null;
let relative_id = null;
var global_claim_id = new URLSearchParams(window.location.search).get(
    "claim_id"
)
    ? new URLSearchParams(window.location.search).get("claim_id")
    : null;
$(document).ready(function () {
    // Get the current date
    var currentDate = new Date();
    $("#claim_heading").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
    $("#claim_sub_heading").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
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

    // Set the values of the input fields
    $("#claim_from_date").val(formattedWeekBeforeDate);
    $("#claim_to_date").val(formattedCurrentDate);
    $("#client_from_date").val(formattedWeekBeforeDate);
    $("#client_to_date").val(formattedCurrentDate);

    getData();
});
$(document).on("click", "#claim_details_search", function (e) {
    e.preventDefault();
    getData();
});
$(document).on("click", "#claim_details_search_clear", function (e) {
    e.preventDefault();
    $("#claim_report_form")[0].reset();
    getData();
});
function getData() {
    
    if ($.fn.DataTable.isDataTable("#claim-details-datatable")) {
        // If the DataTable instance exists, destroy it
        $("#claim-details-datatable").DataTable().destroy();
    }
    $("#claim-details-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "reports/claim-details",
            type: "GET",
            data: function (d) {
                d.from_date = $("#claim_from_date").val();
                d.to_date = $("#claim_to_date").val();
                d.employee_id = $("#claim_emp_name").find(":selected").val();
                d.heading_id = $("#claim_heading").find(":selected").val();
                d.sub_heading = $("#claim_sub_heading").find(":selected").val();
                d.client_id = $("#claim_client").find(":selected").val();
                d.policy_no = $("#claim_policy_no").val();
                d.claim_claim_no = $("#claim_claim_no").val();
                // d.claim_status= $('input[name="claim_status"]:checked').val();
                d.type = $('input[name="claim_type"]:checked').val();
                var selectedClaimStatus = [];
                $('input[name="claim_status[]"]:checked').each(function () {
                    selectedClaimStatus.push($(this).val());
                });
                d.claim_status = selectedClaimStatus;
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
        ],

        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "policy_no" },
            { data: "claim_id" },
            {
                data: null,
                render: function (data, type, row) {
                    return changeDateFormat(row.created_at);
                },
            },

            {
                data: "logs",
                render: function (data, type, row) {
                    const RegisteredLogs = data.filter(
                        (log) => log.type === "Registered"
                    );
                    const lastRegisteredLog =
                        RegisteredLogs[RegisteredLogs.length - 1];
                    return lastRegisteredLog
                        ? changeDateFormat(lastRegisteredLog.created_at)
                        : "";
                },
            },
            {
                data: "logs",
                render: function (data, type, row) {
                    const ScrunityScrunityLogs = data.filter(
                        (log) => log.type === "Scrunity"
                    );
                    const lastScrunityScrunityLog =
                        ScrunityScrunityLogs[ScrunityScrunityLogs.length - 1];
                    return lastScrunityScrunityLog
                        ? changeDateFormat(lastScrunityScrunityLog.created_at)
                        : "";
                },
            },
            { data: "client_name" },
            { data: "sub_heading" },
            { data: "member_name" },
            { data: "heading" },
            // { data: "branch" },
            { data: "member" },
            // { data: "relation" },
            { data: "bill_amount" },
            // { data: "clam_type" },
            { data: "status" },
            // { data: "status_remarks" },
            { data: "approved_amt" },
            {
                data: "logs",
                render: function (data, type, row) {
                    const ApprovedLogs = data.filter(
                        (log) => log.type === "Approved"
                    );
                    const lastApprovedLog =
                        ApprovedLogs[ApprovedLogs.length - 1];
                    return lastApprovedLog
                        ? changeDateFormat(lastApprovedLog.created_at)
                        : "";
                },
            },
            // { data: "approved_amt" },
        ],
        drawCallback: function (settings) {
            if (global_claim_id) {
                // Trigger click for the element with class previewData and matching data-claim_id
                $(
                    '.previewData[data-claim_id="' + global_claim_id + '"]'
                ).trigger("click");
            }
        },
    });
    clientDatatable();
}

function changeDateFormat(value) {
    console.log(value);
    var date = new Date(value);
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2); // Months are zero-based
    var day = ("0" + date.getDate()).slice(-2);

    // Format the date as YYYY-MM-DD
    var formattedDate = year + "-" + month + "-" + day;
    return formattedDate;
}
// $(document).on('change','#claim_client,input[name="claim_type"]',function(){
//     populateEmp()
// });
// function populateEmp() {
//     let type= $('input[name="claim_type"]:checked').val();
//     let client_id=  $("#claim_client").find(':selected').val();
//     if (type==='group') {

//         $('#claim_emp_name option[value!=""]').remove();
//         $.ajax({
//             url: "client-members",
//             type: "GET",
//             dataType: "json",
//             data: {client_id},
//             success: function (res) {
//                 if (res.status === true) {
//                     $.each(res.response.relatives, function (index, option) {

//                         $("#claim_emp_name").append(
//                             '<option value="' +
//                                 option.id +
//                                 '" data-id="' +
//                                 option.id +
//                                 '"' +
//                                 ">" +
//                                 option.name +
//                                 "</option>"
//                         );
//                     });
//                 }
//             },
//         });
//     }
// }

//cleint details
function clientDatatable(){
    if ($.fn.DataTable.isDataTable("#client-details-datatable")) {
        // If the DataTable instance exists, destroy it
        $("#client-details-datatable").DataTable().destroy();
    }
    $("#client-details-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "reports/client-details",
            type: "GET",
            data: function (d) {
                d.from_date = $("#client_from_date").val();
                d.to_date = $("#client_to_date").val();
                d.employee_id = $("#client_emp_name").find(":selected").val();
                d.heading_id = $("#client_heading").find(":selected").val();
                // d.sub_heading = $("#client_sub_heading").find(":selected").val();
                d.client_id = $("#client_client").find(":selected").val();
                d.policy_no = $("#client_policy_no").val();
                // d.client_client_no = $("#client_client_no").val();
                // d.client_status= $('input[name="client_status"]:checked').val();
                // d.type = $('input[name="client_type"]:checked').val();
                var selectedclientStatus = [];
                $('input[name="client_status[]"]:checked').each(function () {
                    selectedclientStatus.push($(this).val());
                });
                d.client_status = selectedclientStatus;
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
        ],
    
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "policy_no" },
            { data: "client_name" },
            { data: "issue_date" },
            { data: "actual_issue_date" },
            { data: "valid_date" },
            { data: "insured_amount" },
            // { data: "branch" },
            { data: "imitation_days" },
            // { data: "relation" },
            { data: "total_claim" },
            // { data: "clam_type" },
            { data: "total_claim_amount" },
            // { data: "status_remarks" },
            { data: "approved_amt" },
            { data: "status" },
            
            // { data: "approved_amt" },
        ],
        drawCallback: function (settings) {
            if (global_claim_id) {
                // Trigger click for the element with class previewData and matching data-claim_id
                $(
                    '.previewData[data-claim_id="' + global_claim_id + '"]'
                ).trigger("click");
            }
        },
    });
    
}
$(document).on("click", "#client_details_search", function (e) {
    e.preventDefault();
    clientDatatable();
});
$(document).on("click", "#client_details_search_clear", function (e) {
    e.preventDefault();
    $("#client_report_form")[0].reset();
    clientDatatable();
});
