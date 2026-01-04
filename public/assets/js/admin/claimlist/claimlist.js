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
    $("#modal_employee_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
        dropdownParent: $("#viewEditModal"),
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
    $("#from_date").val(formattedWeekBeforeDate);
    $("#to_date").val(formattedCurrentDate);

    getData();
});
$(document).on(
    "change",
    "#employee_id,#claim_type,#from_date,#to_date",
    function () {
        if ($(this).attr("id") === "employee_id") {
            if (window.location.search.includes("?member_id=")) {
                let newURL = removeURLParameter(
                    window.location.href,
                    "member_id"
                );
                history.replaceState(null, null, newURL);
            }
        }
        getData();
    }
);
function getData() {
    if ($.fn.DataTable.isDataTable("#datatables-reponsive")) {
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive").DataTable().destroy();
    }
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "claimlist",
            type: "GET",
            data: {
                employee_id: $("#employee_id").val(),
                claim_type: $("#claim_type").val(),
                from_date: $("#from_date").val(),
                to_date: $("#to_date").val(),
                type: "group",
                claim_id: global_claim_id,
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8,9,10,11,12],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8,9,10,11,12],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8,9,10,11,12],
                },
            },
        ],

        columns: [
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
                    return data;
                },
            },
            { data: "claim_id" },
            { data: "member_id" },
            { data: "member_name" },
            { data: "designation" },
            { data: "branch" },
            { data: "member" },
            { data: "relation" },
            { data: "policy_no" },
            { data: "bill_amount" },

            // { data: "document_type" },
            // { data: "file" },
            // { data: "bill_file_size" },
            // { data: "remark" },
            // { data: "document_date" },
            // { data: "heading" },
            // { data: "sub_heading" },
            // { data: "clinical_facility_name" },
            // { data: "diagnosis_treatment" },
            { data: "clam_type" },
            { data: "status" },
            { data: "status_remarks" },
            { data: "action" },
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
let activeCLaimId = null;
$(document).off("click", ".previewData", function () {});
$(document).on("click", ".previewData", function (e) {
    e.preventDefault();
    let claim_id = $(this).data("claim_id");
    activeCLaimId = claim_id;
    $("#modalTitleClaimID").html(claim_id);
    $("#detailsCLaimsOfCLaimIdModal").modal("show");
    getDataIndividual(claim_id);
});
function getDataIndividual(claim_id) {
    if ($.fn.DataTable.isDataTable("#datatables-reponsive-individual")) {
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive-individual").DataTable().destroy();
    }
    $("#datatables-reponsive-individual").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "claimlist",
            type: "GET",
            data: {
                // employee_id: $("#employee_id").val(),
                // claim_type: $("#claim_type").val(),
                // from_date: $("#from_date").val(),
                // to_date: $("#to_date").val(),
                // type: "group",
                claim_id: claim_id,
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
                    return data;
                },
            },
            // { data: "claim_id" },
            // { data: "member_id" },
            // { data: "member_name" },
            // { data: "designation" },
            // { data: "branch" },
            // { data: "member" },
            // { data: "relation" },
            // { data: "policy_no" },
            { data: "bill_amount" },
            { data: "document_type" },
            { data: "file" },
            { data: "bill_file_size" },
            { data: "remark" },
            { data: "document_date" },
            { data: "heading" },
            { data: "sub_heading" },
            { data: "clinical_facility_name" },
            { data: "diagnosis_treatment" },
            { data: "clam_type" },
            { data: "status" },
            { data: "action" },
        ],
        initComplete: function () {
            var table = $.fn.dataTable.Api(this);

            // Check if any claim_type is 'draft'
            var isDraftExists = table
                .rows()
                .data()
                .toArray()
                .some(function (row) {
                    return row.clam_type === "draft";
                });

            // Create a message if a draft exists
            if (isDraftExists) {
                // Create a button and append it directly below the DataTable
                $("#datatables-reponsive-individual").after(`
                <div style="text-align: right; margin-top: 10px;">
                    <a href="javascript:void(0)" class="btn labelsmaller btn-success btn-sm makeClaimByClaimID"
                        data-claim_id="${claim_id}">
                        Claim
                    </a>
                </div>
            `);
            }
            let data = table.rows().data();
            if (data.length > 0) {
                let firstRecord = data[0]; // Get the first record
                let claim_id = firstRecord.claim_id || "No Claim ID"; // Adjust key to match your data source
                let member_id = firstRecord.member_id || "N/A";
                let member_name = firstRecord.member_name || "N/A";
                let designation = firstRecord.designation || "N/A";
                let branch = firstRecord.branch || "N/A";
                let policy_no = firstRecord.policy_no || "N/A";
                let member = firstRecord.member || "Self";
                let relation = firstRecord.relation || null;

                // Update modal title with concatenated details (example)
                let relationHTML = relation
                    ? `<span class="text-light bg-dark p-1 rounded me-2"><strong>Relation:</strong> ${relation}</span>`
                    : "";

                $("#modalTitleClaimID").html(`
                <span class="text-primary bg-light p-1 rounded me-2"><strong>Claim ID:</strong> ${claim_id}</span>
                <span class="text-success bg-light p-1 rounded me-2"><strong>Policy No.:</strong> ${policy_no}</span>
                <span class="text-info bg-light p-1 rounded me-2"><strong>Member ID:</strong> ${member_id}</span>
                <span class="text-danger bg-light p-1 rounded me-2"><strong>Member Name:</strong> ${member_name}</span>
                <span class="text-warning bg-light p-1 rounded me-2"><strong>Designation:</strong> ${designation}</span>
                <span class="text-muted bg-light p-1 rounded me-2"><strong>Branch:</strong> ${branch}</span>
                <span class="text-secondary bg-light p-1 rounded"><strong>Dependent:</strong> ${member}</span>
                ${relationHTML}
            `);
            }
        },
    });
}
$("#viewEditModal").on("show.bs.modal", function () {
    $("#detailsCLaimsOfCLaimIdModal").addClass("d-none");
});

// When #viewEditModal is hidden (after closing)
$("#viewEditModal").on("hidden.bs.modal", function () {
    $("#detailsCLaimsOfCLaimIdModal").removeClass("d-none");
});
$("#detailsCLaimsOfCLaimIdModal").on("hidden.bs.modal", function () {
    activeCLaimId = null;
    if (global_claim_id) {
        global_claim_id = null;
        getData();
    }
});
$(document).off("click", "#addData", function () {});
$(document).on("click", "#addData", function (e) {
    e.preventDefault();
    $("#FormModal").modal("show");
    $(".modal-title").html("Add User Type");
    $(".form").attr("id", "dataForm");
    $("#dataForm")[0].reset();
    $("#btnSubmit").show();
    $("#btnUpdate").hide();
});

$(document).off("click", ".makeClaim", function () {});
$(document).on("click", ".makeClaim", function (e) {
    e.preventDefault();
    let dataurl = $(this).data("url");
    let postdata = {};
    let element = this;
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            // $("#dataForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            $(element).remove();
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
});
$(document).off("click", ".makeClaimByClaimID", function () {});
$(document).on("click", ".makeClaimByClaimID", function (e) {
    e.preventDefault();
    let claim_id = $(this).data("claim_id");
    let dataurl = "make-claim-by-claim-id/" + claim_id;
    let postdata = {};
    let element = this;
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            // $("#dataForm")[0].reset();
            getDataIndividual(claim_id);
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            $(element).remove();
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
    $(".form").find("#policy_no").prop("disabled", true);
    relative_id = $(this).attr("data-relative_id");
    let dataurl = $(this).attr("data-url");
    let imitation_days = parseInt($(this).data("imitation_days"));

    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $(".modal-title").html("Edit Claim");
            $("#viewEditModal #submitBtn").html(
                '<button type="submit" class="btn btn-sm btn-success px-4 text-white">Update</button>'
            );
            $(".form").attr("id", "updatedataForm");
            $("#viewEditModal").modal("show");
            $("#insurance_claim_id").val(res.response.id);
            $("#heading_id").val(res.response.heading_id);
            $("#document_type").val(res.response.document_type);
            $("#bill_amount").val(res.response.bill_amount);
            $(".form")
                .find("input[name='bill_file_name']")
                .val(res.response.bill_file_name);
            $(".form")
                .find("#fileUrl")
                .html(
                    '<a href="/' +
                        res.response.file_path +
                        '" target="_blank">' +
                        res.response.bill_file_name +
                        "</a>"
                );
            $("#document_date").val(res.response.document_date);
            $("#remark").val(res.response.remark);
            $("#clinical_facility_name").val(
                res.response.clinical_facility_name
            );
            $("#diagnosis_treatment").val(res.response.diagnosis_treatment);
            $("#modal_employee_id")
                .val(res.response.member_id)
                .trigger("change");
            if (imitation_days) {
                let imitation_date = new Date();
                imitation_date.setDate(
                    imitation_date.getDate() - parseInt(imitation_days)
                );
                // currentDate.setDate(currentDate.getDate() - 5);
                $("#document_date").attr({
                    min: formatDate(imitation_date),
                    max: formatDate(new Date()),
                });
            } else {
                $("#document_date").attr({
                    min: "",
                    max: "",
                });
            }

            select_subheading_id = res.response.sub_heading_id;
            populateSubHeading(res.response.heading_id, select_subheading_id);
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("submit", "#updatedataForm", function (e) {
    e.preventDefault();
    // return
    let id = $("#insurance_claim_id").val();
    let dataurl = "claimsubmissions/" + id;
    let postdata = new FormData(this);
    postdata.append("_method", "PUT");
    // postdata.append('heading_id', $('#heading_id').val())
    // postdata.append('document_type', $('#document_type').val())
    // postdata.append('bill_amount', $('#bill_amount').val())
    // postdata.append('document_date', $('#document_date').val())
    // postdata.append('remark', $('#remark').val())
    // postdata.append('diagnosis_treatment', $('#diagnosis_treatment').val())
    // let postdata=$('#updatedataForm').serialize();
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        if (res.status === true) {
            showNotification(res.message, "success");
            $("#viewEditModal").modal("hide");
            $("#updatedataForm")[0].reset();
            $("#datatables-reponsive").dataTable().fnClearTable();
            $("#datatables-reponsive").dataTable().fnDestroy();
            getDataIndividual(activeCLaimId);
            getData();
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).on("change", "#heading_id", function () {
    let heading_id = $("#heading_id").find(":selected").val();
    populateSubHeading(heading_id);
});
function populateSubHeading(id, selected = null) {
    $('#sub_heading_id option[value!=""]').remove();
    let selectedEmp = $("#modal_employee_id").find(":selected").val();
    console.log(selectedEmp);
    let dataurl = "get-sub-headings/" + id + "?employee_id=" + selectedEmp;

    if (id) {
        var request = getRequest(dataurl);
        request.done(function (res) {
            if (res.status === true) {
                $.each(res.response, function (index, option) {
                    var isSelected =
                        selected !== null &&
                        option.id.toString() === selected.toString();
                    $("#sub_heading_id").append(
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
}

$(document).on("change", "#modal_employee_id", function () {
    let employee_id = this.value;
    let employee_name = $(this).find(":selected").text().trim();
    populate_members(employee_id, relative_id);
    $("#employee_name").val(employee_name);
});

$(document).on("change", "#relative_id", function () {
    let relation = $(this).find(":selected").attr("data-rel");
    $("#relation").val($(this).find(":selected").attr("data-rel"));
});

function formatDate(date) {
    let month = date.getMonth() + 1;
    return `${date.getFullYear()}-${addZeroInfront(month)}-${addZeroInfront(
        date.getDate()
    )}`;
}

function addZeroInfront(num) {
    return num <= 9 ? "0" + num : num;
}

function populate_members(id, selected = null) {
    let dataurl = "get-relatives/" + id;
    var request = getRequest(dataurl);
    // $('#member_id option').remove();
    $('#relative_id option[value!=""]').remove();
    // let totalInsured = 0;
    // let totalClaimed = 0;
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response.relatives, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                $("#relative_id").append(
                    '<option value="' +
                        option.id +
                        '" data-id="' +
                        option.id +
                        '"' +
                        ' data-rel="' +
                        option.rel_relation +
                        '"' +
                        (isSelected ? " selected" : "") +
                        ">" +
                        option.rel_name +
                        "</option>"
                );
            });
            $("#relative_id").val(selected).trigger("change");
            $("#destination_id").val(res.response.details.designation);
            $("#branch_id").val(res.response.details.branch);
            $("#policy_no").val(res.response.details.policy_no);
            // $("#expiryDate").html(res.response.details.expiry_date);
            // $("#headingSpan").empty();
            // $.each(res.response.policy, function (index, option) {
            //     totalInsured += parseInt(option.insuranced_amount);
            //     totalClaimed += parseInt(option.claimed_amount);
            //     $("#headingSpan").append(
            //         '<span class="d-block mb-1">' +
            //             option.heading_name +
            //             ": <span>Rs." +
            //             option.insuranced_amount +
            //             " / Rs." +
            //             option.claimed_amount +
            //             "</span> </span>"
            //     );
            // });
            // $("#totalInsuredAmount").html(totalInsured);
            // $("#totalClaimedAmount").html(totalClaimed);
        } else {
            showNotification(res.message, "error");
        }
    });
}
