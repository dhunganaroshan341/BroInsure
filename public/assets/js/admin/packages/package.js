$(document).ready(function () {
    getData();
    $("#heading_id, #sub_heading_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
        dropdownParent: $("#FormModal"),
    });
});

function getData() {
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: "packages",
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
            { data: "heading" },
            { data: "action" },
        ],
    });
}

$(document).off("click", "#addData", function () {});
$(document).on("click", "#addData", function (e) {
    e.preventDefault();
    $("#FormModal").modal("show");
    $(".modal-title").html("Add Package");
    $(".form").attr("id", "dataForm");
    $("#dataForm")[0].reset();
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
    $("#dataForm input[type='checkbox']:checked").each(function () {
        var headingId = $(this).attr("data-heading_id");

        // Check if the headingId is already in the array
        if (headingIds.indexOf(headingId) === -1) {
            headingIds.push(headingId); // Add the headingId to the array if it's not already there
            postdata.append("heading_id[]", headingId);
        }
    });

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
$("#FormModal").on("hidden.bs.modal", function () {
    // Select all accordion buttons that are currently expanded
    var $expandedButtons = $(".accordion-button[aria-expanded='true']");

    // Trigger click event on each expanded button to collapse the accordion items
    $expandedButtons.each(function () {
        $(this).trigger("click");
    });
});
$(document).off("click", ".editData", function () {});
$(document).on("click", ".editData", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-pid");
    $(".modal-title").html("Edit Package");
    let dataurl = $(this).attr("data-url");
    var request = getRequest(dataurl);
    request.done(function (res) {
        if (res.status === true) {
            $("#btnSubmit").hide();
            $("#btnUpdate").show();
            $(".form").attr("id", "updatedataForm");
            $("#FormModal").modal("show");
            $("#name").val(res.response.name);
            $(".sub_heading_id").prop("checked", false);

            res.response.packageheadings.forEach(function (valuerow) {
                var array = JSON.parse(valuerow.exclusive);
                // Select all collapse buttons that are currently expanded
                $(
                    "#heading" + valuerow.heading_id + " .accordion-button"
                ).trigger("click");
                array.forEach(function (value) {
                    $("#subHeading" + value + "_" + valuerow.heading_id).prop(
                        "checked",
                        true
                    );
                });
            });
            $("#id").val(res.response.id);
        } else {
            showNotification(res.message, "error");
        }
    });
});

$(document).off("submit", "#updatedataForm", function () {});
$(document).on("submit", "#updatedataForm", function (e) {
    e.preventDefault();
    let id = $("#id").val();
    let dataurl = "packages/" + id;
    let postdata = $("#updatedataForm").serialize();

    var headingIds = []; // Array to store unique heading_id values
    // Iterate over each checked checkbox
    $("#updatedataForm input[type='checkbox']:checked").each(function () {
        var headingId = $(this).attr("data-heading_id");

        // Check if the headingId is already in the array
        if (headingIds.indexOf(headingId) === -1) {
            headingIds.push(headingId); // Add the headingId to the array if it's not already there
            postdata += "&heading_id[]=" + encodeURIComponent(headingId); // Append heading_id to serialized data
        }
    });
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
