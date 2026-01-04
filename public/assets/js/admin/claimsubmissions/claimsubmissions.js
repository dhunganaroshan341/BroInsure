var serialNumber = 1;
let counterInitialRecords = 0;
let serialNumberResubmission = 0;
let documentEndDateOfMember = null;
let edit_row_no = null;
let headingAmountData = {};
let headingImitationDaysData = {};
let headingAmountDataClaimed = {};
let isSubmittedrefreshTable = false;
$(document).ready(function () {
    $("#employee_id").trigger("change");
    $("#sidebarTogger").trigger("click");
    $(
        "#employee_id, #heading_id ,#sub_heading_id,#resubmission_ClaimId,#resubmission_sub_heading_id"
    ).select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
    $("#document_date_bs").nepaliDatePicker({
        ndpYear: true,
        ndpMonth: true,
        ndpYearCount: 15,
        readOnlyInput: true,
        // disableBefore: "2081-06-10",
        disableAfter: NepaliFunctions.AD2BS(formatDate(new Date())),
        onChange: function (e) {
            $("#document_date").val(e.ad);
        },
    });

    $(document).on("change", "#document_date", function () {
        $("#document_date_bs").val(NepaliFunctions.AD2BS($(this).val()));
    });
    $(document).on("change", "#resubmission_document_date", function () {
        $("#resubmission_document_date_bs").val(
            NepaliFunctions.AD2BS($(this).val())
        );
    });
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

// Handle row deletion
$(document).off("submit", "#addDataToTableForm", function () {});
$(document).on("submit", "#addDataToTableForm", function (e) {
    e.preventDefault();
    // Validate form data
    var isValid = true;
    var billAmount = $("#bill_amount").val();
    var headingId = $("#heading_id").val();
    var documentTypeId = $("#document_type_id").val();

    let errorMsg;
    $("#addDataToTableForm input, #addDataToTableForm select").each(
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
                    .attr("style", "border-color: #dc3545 !important");
            } else {
                $(this).css("border-color", "");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "");
            }
            // Additional validation for bill_amount
            if ($(this).attr("name") === "bill_amount") {
                if (
                    isRequired &&
                    (value.trim() == "" || isNaN(value) || value < 0)
                ) {
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
                //modify
                // Check if headingId exists in headingAmountData, otherwise return 0
                headingAmountData[headingId] = headingAmountData[headingId]
                    ? headingAmountData[headingId]
                    : 0;

                // Check if headingId exists in headingAmountDataClaimed, otherwise return 0
                headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                    headingId
                ]
                    ? headingAmountDataClaimed[headingId]
                    : 0;

                let remainingAmount =
                    parseFloat(
                        headingAmountData[headingId] -
                            headingAmountDataClaimed[headingId]
                    ) || 0;
                if (billAmount > remainingAmount) {
                    isValid = false;
                    $(this).attr("style", "border-color: #dc3545 !important");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .attr("style", "border-color: #dc3545 !important");
                    errorMsg = "The bill amount exceeds the remaining amount.";
                }
            }

            // Additional validation for bill_file
            if ($(this).attr("name") === "bill_file" && isRequired) {
                var file = $(this)[0].files[0];
                if (file) {
                    var fileType = file.type;
                    var validTypes = [
                        // "application/pdf",
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

            // Additional validation for document_date
            if ($(this).attr("name") === "document_date" && isRequired) {
                // Assuming 'value' contains the date input value in YYYY-MM-DD format
                var value = $(this).val();
                // var endDate = documentEndDateOfMember;
                var endDate = null;
                if (headingImitationDaysData[headingId]) {
                    let imitation_date = new Date();
                    imitation_date.setDate(
                        imitation_date.getDate() -
                            parseInt(headingImitationDaysData[headingId])
                    );
                    endDate = formatDate(imitation_date);
                }

                // Assuming 'value' contains the date input value
                // Example: YYYY-MM-DD format
                var isValidDate = /^\d{4}-\d{2}-\d{2}$/.test(value);
                if (!isValidDate) {
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
                    var documentDate = new Date(value);
                    var dataEndDate = new Date(endDate);
                    var currentDate = new Date();
                    if ($("#employee_id").val()) {
                        if (endDate) {
                            // if (documentDate > dataEndDate) {
                            // if (
                            //     documentDate < dataEndDate ||
                            //     documentDate > currentDate
                            // ) {
                            //     isValid = false;
                            //     $(this).attr(
                            //         "style",
                            //         "border-color: #dc3545 !important"
                            //     );
                            //     $(this)
                            //         .next(".select2-container")
                            //         .find(".select2-selection")
                            //         .attr(
                            //             "style",
                            //             "border-color: #dc3545 !important"
                            //         );
                            //     // Add validation error message here if needed
                            //     errorMsg =
                            //         "Document date must be within Imitation days.";
                            // } else {
                            //     $(this).css("border-color", "");
                            //     $(this)
                            //         .next(".select2-container")
                            //         .find(".select2-selection")
                            //         .css("border-color", "");
                            //     $(this).next(".error-message").text(""); // Clear any previous error message
                            // }
                            if (documentTypeId === "bill") {
                                if (
                                    documentDate < dataEndDate ||
                                    documentDate > currentDate
                                ) {
                                    isValid = false;
                                    $(this).attr(
                                        "style",
                                        "border-color: #dc3545 !important"
                                    );
                                    $(this)
                                        .next(".select2-container")
                                        .find(".select2-selection")
                                        .attr(
                                            "style",
                                            "border-color: #dc3545 !important"
                                        );
                                    // Add validation error message here if needed
                                    errorMsg =
                                        "Document date must be within Imitation days.";
                                } else {
                                    $(this).css("border-color", "");
                                    $(this)
                                        .next(".select2-container")
                                        .find(".select2-selection")
                                        .css("border-color", "");
                                    $(this).next(".error-message").text(""); // Clear any previous error message
                                }
                            } else {
                                if (documentDate > currentDate) {
                                    isValid = false;
                                    $(this).attr(
                                        "style",
                                        "border-color: #dc3545 !important"
                                    );
                                    $(this)
                                        .next(".select2-container")
                                        .find(".select2-selection")
                                        .attr(
                                            "style",
                                            "border-color: #dc3545 !important"
                                        );
                                    // Add validation error message here if needed
                                    errorMsg =
                                        "Document date cannot be greater than current date.";
                                } else {
                                    $(this).css("border-color", "");
                                    $(this)
                                        .next(".select2-container")
                                        .find(".select2-selection")
                                        .css("border-color", "");
                                    $(this).next(".error-message").text(""); // Clear any previous error message
                                }
                            }
                        } else {
                            $("#employee_id").attr(
                                "style",
                                "border-color: #dc3545 !important"
                            );
                            errorMsg =
                                "Please select the policy of the client.";
                            isValid = false;
                        }
                    } else {
                        $("#employee_id").attr(
                            "style",
                            "border-color: #dc3545 !important"
                        );
                        isValid = false;
                        errorMsg = "Please select the employee.";
                    }
                }
            }
        }
    );

    if (!isValid) {
        $("#addDataToTableAdd").prop("disabled", false);
        $("#addDataToTableAdd").html(
            $("#addDataToTableAdd").data("original-text")
        );
        errorMsg =
            errorMsg ?? "Please fill valid data in all required fields..";
        showNotification(errorMsg, "error");
        return;
    }
    // Get input values
    var headingText = $("#heading_id option:selected").text();
    var subheadingId = $("#sub_heading_id").val();
    var subheadingText = $("#sub_heading_id option:selected").text();

    var documentTypeText = $("#document_type_id option:selected").text();
    var billFileInput = $("#bill_file")[0].files[0];
    var billFileName = $("#bill_file_name").val();
    var documentDate = $("#document_date").val();
    var clinicalFacilityName = $("#clinical_facility_name").val();
    var remark = $("#remark").val();
    var clinicalFacilityName = $("#clinical_facility_name").val();
    var diagnosisTreatment = $("#diagnosis_treatment").val();

    // Get file name, size, and URL
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileSize = billFileInput
        ? (billFileInput.size / 1024).toFixed(2) + " KB"
        : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    billFileName = billFileName ? billFileName : billFile;

    $("#clinical_facility_name_section").val(clinicalFacilityName);

    var uniqueId = "bill_file_" + Date.now() + "_" + Date.now();
    // Append a new row to the table
    var newRow =
        '<tr data-rowno="' +
        serialNumber +
        '">' +
        "<td><span>" +
        serialNumber +
        `</span><input type="checkbox" name="serial_number[]" class="serial_number" value="` +
        serialNumber +
        '" /></td>' +
        `<td id="row_document_type${serialNumber}">` +
        `<span>${documentTypeText}</span>` +
        `<input type="hidden" name="document_type[]" value="` +
        documentTypeId +
        '" /></td>' +
        `<td id="row_bill_file_name${serialNumber}"><a href="` +
        billFileURL +
        '" target="_blank">' +
        billFileName +
        "</a>" +
        '<span class="d-none">' +
        '<input type="file" name="bill_file[]" id="' +
        uniqueId +
        '">' +
        "</span>" +
        `<input type="hidden" name="bill_file_name[]" value="` +
        billFileName +
        '" /></td>' +
        `<td>` +
        billFileSize +
        '<input type="hidden" name="bill_file_size[]" value="' +
        billFileSize +
        '" /></td>' +
        `<td id="row_remark${serialNumber}">` +
        `<span>${remark}</span>` +
        `<input type="hidden" name="remark[]" value="` +
        remark +
        '" /></td>' +
        `<td id="row_document_date${serialNumber}">` +
        `<span>${documentDate}</span>` +
        `<input type="hidden" name="document_date[]" value="` +
        documentDate +
        '" /></td>' +
        `<td id="row_bill_amount${serialNumber}">` +
        `<span>${billAmount}</span>` +
        `<input type="hidden" name="bill_amount[]" value="` +
        billAmount +
        '" /></td>' +
        `<td id="row_heading_id${serialNumber}">` +
        `<span>${headingText}</span>` +
        `<input type="hidden" name="heading_id[]" value="` +
        headingId +
        '" /></td>' +
        `<td id="row_sub_heading_id${serialNumber}">` +
        `<span>${subheadingText}</span>` +
        `<input type="hidden" name="sub_heading_id[]" value="` +
        subheadingId +
        '" /></td>' +
        `<td id="row_clinical_facility_name${serialNumber}">` +
        `<span>${clinicalFacilityName}</span>` +
        `<input type="hidden" name="clinical_facility_name[]" value="` +
        clinicalFacilityName +
        '" /></td>' +
        `<td id="row_diagnosis_treatment${serialNumber}">` +
        `<span>${diagnosisTreatment}</span>` +
        `<input type="hidden" name="diagnosis_treatment[]" value="` +
        diagnosisTreatment +
        '" /></td>' +
        "<td>" +
        '<button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i> View</button> ' +
        '<button class="btn btn-warning btn-sm text-white editRow"><i class="fas fa-edit"></i> Edit</button> ' +
        '<button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i> Delete</button>' +
        "</td>" +
        "</tr>";

    $("#addDataToTable tbody").append(newRow);
    // Get the selected file from the first input
    var fileInput1 = $("#bill_file")[0];
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
        $("#clearBtnAppend").html(
            '<button type="button" class="mx-1 btn btn-danger labelsmaller btn-sm float-end" id="addDataToTableReset">Reset <i class="fa-sharp fas fa-brush "></i></button>'
        );
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", true);
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
        $("#clearBtnAppend").html("");
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", false);
    }
    // Increment the serial number for the next row
    serialNumber++;
    //Reduce Amount
    modifyRemainingHeadingAmount();
    // Optionally, reset the form
    this.reset();
    $("#addDataToTableAdd").prop("disabled", false);
    $("#addDataToTableAdd").html($("#addDataToTableAdd").data("original-text"));
    showNotification("Data Added Sucessfully.", "success");
    $("#heading_id, #sub_heading_id").trigger("change");
});
// Handle row deletion
$("#addDataToTable").on("click", ".deleteRow", function () {
    $(this).closest("tr").remove();
    refreshTable();
});
let editClaimHeadingId = null;
let editClaimAmount = null;
// When the modal is closed, reset the variables
$("#viewEditModal").on("hidden.bs.modal", function () {
    // Reset the variables to null when the modal is closed
    editClaimHeadingId = null;
    editClaimAmount = null;
});

// Handle row editing - Add your own functionality
$("#addDataToTable").on("click", ".editRow,.viewRow", function () {
    // Check if it's an editRow click
    var isEdit = $(this).hasClass("editRow");
    let tr = $(this).closest("tr");
    let row_no = tr.data("rowno");
    edit_row_no = row_no;
    var formElements = $("#viewEditModal input, #viewEditModal select").prop(
        "disabled",
        false
    );
    $("#viewEditModal #fileUrl").html("");
    // Iterate over all input elements within the <tr>
    let $tr = $(this).closest("tr");
    $tr.find("input").each(function () {
        var inputName = $(this).attr("name").replace("[]", "");
        var inputValue = $(this).val();
        if (inputName == "heading_id") {
            editClaimHeadingId = inputValue;
        }
        if (inputName == "bill_amount") {
            editClaimAmount = parseFloat(inputValue);
        }
        // Check if the input type is file
        if ($(this).attr("type") === "file") {
            // Check if files are selected sss
            if (this.files.length > 0) {
                // Append the selected file to FormData
                var fileInput1 = $(this)[0];
                var file = fileInput1.files[0];

                if (file) {
                    // Create a new DataTransfer object
                    var dataTransfer = new DataTransfer();
                    // Add the selected file to the DataTransfer object
                    dataTransfer.items.add(file);
                    // Get the second file input and assign the files from DataTransfer object
                    var fileInput2 = $("#viewEditModal").find(
                        'input[name="' + inputName + '"]'
                    )[0];
                    fileInput2.files = dataTransfer.files;
                    var billFileInput = file;
                    var billFileURL = billFileInput
                        ? URL.createObjectURL(billFileInput)
                        : "";
                    $("#viewEditModal #fileUrl").html(
                        '<a href="' +
                            billFileURL +
                            '" target="_blank" > View File</a>'
                    );
                }
            }
        } else {
            // Find corresponding input in `$("#viewEditModal")` form by name attribute
            $("#viewEditModal")
                .find('input[name="' + inputName + '"]')
                .val(inputValue);
            $("#viewEditModal")
                .find('select[name="' + inputName + '"]')
                .val(inputValue)
                .trigger("change");
        }
        $("#edit_heading_id").val();
    });
    populateSubHeading(
        $tr.find('input[name="heading_id[]"]').val(),
        $tr.find('input[name="sub_heading_id[]"]').val(),
        "#edit_sub_heading_id"
    );
    // Select all input and select elements within the form
    if (isEdit) {
        $("#viewEditModal #modalTitle").html("Edit Data");
        // Enable all input and select elements
        formElements.prop("disabled", false);
        $("#viewEditModal #submitBtn").html(
            '<button type="submit" class="btn btn-sm btn-success px-4 text-white" id="btnRecordUpdate">Update</button>'
        );
    } else {
        $("#viewEditModal #modalTitle").html("View Data");
        // Disable all input and select elements
        formElements.prop("disabled", true);
        $("#viewEditModal #submitBtn").html("");
    }
    $("#viewEditModal form").attr("id", "viewEditRecordForm");
    $("#viewEditModal").modal("show");
});

// Handle cancel tbody
$("#addDataToTable").on("click", "#cancelBtn", function (e) {
    e.preventDefault();
    $("#addDataToTable tbody").html("");
    $("#addDataToTable tfoot").addClass("d-none");
});
$(document).on("submit", "#addDataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off("submit", "#addDataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off(
    "click",
    "#addDataToTableFormSave #saveAsDraftlBtn,#addDataToTableFormSave #saveSubmitClaim",
    function () {}
);
$(document).on(
    "click",
    "#addDataToTableFormSave #saveAsDraftlBtn,#addDataToTableFormSave #saveSubmitClaim",
    function (e) {
        e.preventDefault();
        let currentEleemet = $(this);
        saveDraftSubmitClaim(currentEleemet);
    }
);
$(document).on("change", "#confirmSubmitBtn", function (e) {
    e.preventDefault();
    if ($(this).is(":checked")) {
        $(".savePDFPrint").html(
            '<button class="btn btn-success btn-sm" id="saveClaimList"><i class="fas fa-save"></i> Submit</button> '
        );
    } else {
        $(".savePDFPrint").html("");
    }
});
$(document).on("click", "#saveClaimList", function (e) {
    e.preventDefault();
    let currentEleemet = $(this);
    saveDraftSubmitClaim(currentEleemet, true);
});
function saveDraftSubmitClaim(currentEleemet, isStore = null) {
    let checkedCount = $(
        '#addDataToTableFormSave input[type="checkbox"].serial_number:checked'
    ).length;
    if (checkedCount <= 0) {
        showNotification(
            "Please select the items that you want to submit.",
            "error"
        );
        return;
    }
    $(".btnsendData").prop("disabled", true);

    let btnId = currentEleemet.attr("id");
    let saveType;
    if (btnId == "saveAsDraftlBtn") {
        saveType = "draft";
    } else if (btnId == "saveClaimList") {
        saveType = "claim";
    } else if (btnId == "saveSubmitClaim") {
        saveType = "claim";
        if (!isStore) {
            // let headingAmountData = [];
            // let hospital_name = null;
            // let treatment = null;
            // $("#addDataToTableFormSave")
            //     .find('input[type="checkbox"][name="serial_number[]"]:checked')
            //     .each(function () {
            //         // Find the closest <tr> parent element
            //         let $tr = $(this).closest("tr");

            //         // Initialize an object to store the headingName, AmountValue, and Remark for the current row
            //         let rowData = {};

            //         // Find the heading_id input and its corresponding span text
            //         $tr.find("input[name='heading_id[]']").each(function () {
            //             // Get the heading_id's associated span text
            //             let headingName = $(this)
            //                 .closest("td")
            //                 .find("span")
            //                 .text()
            //                 .trim();
            //             rowData.headingName = headingName; // Store the heading name
            //         });
            //         $tr.find("input[name='clinical_facility_name[]']").each(
            //             function () {
            //                 // Get the clinical_facility_name's associated span text
            //                 let hospitalName = $(this)
            //                     .closest("td")
            //                     .find("span")
            //                     .text()
            //                     .trim();
            //                 rowData.hospital_name = hospitalName; // Store the heading name
            //                 if (!hospital_name) {
            //                     hospital_name = hospitalName;
            //                 }
            //             }
            //         );
            //         $tr.find("input[name='diagnosis_treatment[]']").each(
            //             function () {
            //                 // Get the diagnosis_treatment's associated span text
            //                 let treatmentName = $(this)
            //                     .closest("td")
            //                     .find("span")
            //                     .text()
            //                     .trim();
            //                 rowData.treatment = treatmentName; // Store the heading name
            //                 if (!treatment) {
            //                     treatment = treatmentName;
            //                 }
            //             }
            //         );
            //         // Find the bill_amount input and its corresponding span text
            //         $tr.find("input[name='bill_amount[]']").each(function () {
            //             // Get the bill_amount's associated span value
            //             let AmountValue = $(this)
            //                 .closest("td")
            //                 .find("span")
            //                 .text()
            //                 .trim();
            //             rowData.AmountValue = AmountValue; // Store the amount value
            //         });

            //         // Find the remark input and its corresponding span text
            //         $tr.find("input[name='remark[]']").each(function () {
            //             // Get the remark's associated span value
            //             let remarkValue = $(this)
            //                 .closest("td")
            //                 .find("span")
            //                 .text()
            //                 .trim();
            //             rowData.remark = remarkValue; // Store the remark value
            //         });

            //         // Push the rowData object to the headingAmountData array if it has values
            //         if (Object.keys(rowData).length > 0) {
            //             headingAmountData.push(rowData);
            //         }
            //     });

            // let dataurlPDF = "get-claimid-confirm-view";
            // let postdataPDF = {
            //     member_id: $("#employee_id").val(),
            //     relative_id: $("#member_id").val(),
            //     policy_no: $("#policy_no").val(),
            //     hospital_name,
            //     treatment,
            //     headingAmountData,
            // };
            // var requestPDF = ajaxRequest(dataurlPDF, postdataPDF, "POST");
            // requestPDF.done(function (res) {
            //     $(".btnsendData").prop("disabled", false);
            //     $("#confirmModal .modal-body").html("");
            //     if (res.status === true) {
            //         $("#confirmModal .modal-body").html(res.response);
            //         $("#confirmModal").modal("show");
            //     } else {
            //         $("#confirmModal").modal("hide");
            //         showNotification(res.message, "error");
            //     }
            // });

            swal({
                title: "Are you sure you want to proceed?",
                text: "I declare that I have/my dependent has suffered the above described injuries/illness and that to the best of my knowledge And belief the forgoing particulars are in every respect true. I also declare that there is no other insurance or other source to recover the item claimed.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    saveDraftSubmitClaim($("#saveSubmitClaim"), true);
                } else {
                    $(".btnsendData").prop("disabled", false);
                }
            });
            $(".swal-text").css({
                "text-align": "justify", // Justify the text
                "font-size": "14px", // Optional: Adjust the font size if needed
            });
            $(".swal-title").css({
                "font-size": "18px", // Adjust to your preferred size
            });
            return;
        }
    } else {
        saveType = null;
    }
    let dataurl = $("#addDataToTableFormSave").attr("action");
    // Create FormData object from the form using jQuery
    // let postdata = new FormData($("#addDataToTableFormSave")[0]);

    // Create a FormData object to store data
    let postdata = new FormData();
    postdata.append("save_type", saveType);
    postdata.append("member_id", $("#employee_id").val());
    postdata.append("destination_id", $("#destination_id").val());
    postdata.append("branch_id", $("#branch_id").val());
    postdata.append("employee_name", $("#employee_name").val());
    postdata.append("relative_id", $("#member_id").val());
    postdata.append("relation_id", $("#relation_id").val());
    postdata.append("policy_no", $("#policy_no").val());
    // Iterate over each checkbox that is checked
    $("#addDataToTableFormSave")
        .find('input[type="checkbox"][name="serial_number[]"]:checked')
        .each(function () {
            // Find the closest <tr> parent element
            let $tr = $(this).closest("tr");
            // Iterate over all input elements within the <tr>
            $tr.find("input").each(function () {
                // Check if the input type is file
                if ($(this).attr("type") === "file") {
                    // Check if files are selected sss
                    if (this.files.length > 0) {
                        // Append the selected file to FormData
                        postdata.append($(this).attr("name"), this.files[0]);
                    }
                } else {
                    // Append all other input elements' name and value to FormData
                    postdata.append($(this).attr("name"), $(this).val());
                }
            });
        });

    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        $(".btnsendData").prop("disabled", false);
        if (res.status === true) {
            showNotification(res.message, "success");
            $(
                '#addDataToTableFormSave input[type="checkbox"][name="serial_number[]"]:checked'
            ).each(function () {
                $(this).closest("tr").remove();
            });
            isSubmittedrefreshTable = true;
            $("#member_id").trigger("change");
            // $.when($("#member_id").trigger("change")).done(function () {
            //     refreshTable();
            // });
        } else {
            showNotification(res.message, "error");
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        $(".btnsendData").prop("disabled", false);
    });
}

//Update tr record
$(document).off("submit", "#viewEditRecordForm", function () {});
$(document).on("submit", "#viewEditRecordForm", function (e) {
    e.preventDefault();
    var billAmount = $("#viewEditModal")
        .find('input[name="bill_amount"]')
        .val();
    var headingId = $("#viewEditModal").find('select[name="heading_id"]').val();
    var documentTypeId = $("#viewEditModal")
        .find('select[name="document_type"]')
        .val();
    // Validate form data
    var isValid = true;
    let errorMsg;
    $("#viewEditRecordForm input, #viewEditRecordForm select").each(
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
                    .attr("style", "border-color: #dc3545 !important");
            } else {
                $(this).css("border-color", "");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .css("border-color", "");
            }
            // Additional validation for bill_amount
            if ($(this).attr("name") === "bill_amount") {
                if (
                    isRequired &&
                    (value.trim() == "" || isNaN(value) || value < 0)
                ) {
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
                //modify

                // Check if headingId exists in headingAmountData, otherwise return 0
                headingAmountData[headingId] = headingAmountData[headingId]
                    ? headingAmountData[headingId]
                    : 0;
                // Check if headingId exists in headingAmountDataClaimed, otherwise return 0
                headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                    headingId
                ]
                    ? headingAmountDataClaimed[headingId]
                    : 0;

                let existingValue = 0;
                if (headingId == editClaimHeadingId) {
                    existingValue = editClaimAmount;
                }
                let totalCLaimedAmount =
                    headingAmountData[headingId] +
                    existingValue -
                    headingAmountDataClaimed[headingId];
                let remainingAmount = parseFloat(totalCLaimedAmount) || 0;
                if (billAmount > remainingAmount) {
                    isValid = false;
                    $(this).attr("style", "border-color: #dc3545 !important");
                    $(this)
                        .next(".select2-container")
                        .find(".select2-selection")
                        .attr("style", "border-color: #dc3545 !important");
                    errorMsg = "The bill amount exceeds the remaining amount.";
                }
            }

            // Additional validation for document_date
            if ($(this).attr("name") === "document_date" && isRequired) {
                // Assuming 'value' contains the date input value
                // Example: YYYY-MM-DD format
                var isValidDate = /^\d{4}-\d{2}-\d{2}$/.test(value);
                if (!isValidDate) {
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

            // Additional validation for bill_file
            if ($(this).attr("name") === "bill_file" && isRequired) {
                var file = $(this)[0].files[0];
                if (file) {
                    var fileType = file.type;
                    var validTypes = [
                        // "application/pdf",
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
        }
    );

    if (!isValid) {
        $("#btnRecordUpdate").prop("disabled", false);
        $("#btnRecordUpdate").html($("#btnRecordUpdate").data("original-text"));
        errorMsg =
            errorMsg ?? "Please fill valid data in all required fields..";
        showNotification(errorMsg, "error");
        return;
    }
    // Get input values
    var serialNumber = $("#viewEditModal")
        .find('input[name="serial_number"]')
        .val();
    var headingText = $("#viewEditModal")
        .find('select[name="heading_id"] option:selected')
        .text();
    var subHeadingId = $("#viewEditModal")
        .find('select[name="sub_heading_id"]')
        .val();
    var subHeadingText = $("#viewEditModal")
        .find('select[name="sub_heading_id"] option:selected')
        .text();

    var documentTypeText = $("#viewEditModal")
        .find('select[name="document_type"] option:selected')
        .text();

    var billFileInput = $("#viewEditModal").find('input[name="bill_file"]')[0]
        .files[0];
    var billFileName = $("#viewEditModal")
        .find('input[name="bill_file_name"]')
        .val();
    var documentDate = $("#viewEditModal")
        .find('input[name="document_date"]')
        .val();

    var clinicalFacilityName = $("#viewEditModal")
        .find('input[name="clinical_facility_name"]')
        .val();
    var remark = $("#viewEditModal").find('input[name="remark"]').val();
    var diagnosisTreatment = $("#viewEditModal")
        .find('input[name="diagnosis_treatment"]')
        .val();

    // Get file name, size, and URL
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileSize = billFileInput
        ? (billFileInput.size / 1024).toFixed(2) + " KB"
        : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    billFileName = billFileName ? billFileName : billFile;

    var uniqueId = "bill_file_" + Date.now() + "_" + Date.now();

    // Find the checkbox with name="serial_number[]" and value="5"
    var checkbox = $(
        'input[name="serial_number[]"][value="' + serialNumber + '"]'
    );
    // Check if the checkbox is checked
    var isChecked = checkbox.is(":checked");
    // Find the closest tr element to the checkbox
    var closestTr = checkbox.closest("tr");
    closestTr.html("");
    // Append a new row to the table
    var newRow =
        "<td>" +
        serialNumber +
        '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
        serialNumber +
        '"' +
        (isChecked ? " checked" : "") +
        " /></td>" +
        "<td>" +
        documentTypeText +
        '<input type="hidden" name="document_type[]" value="' +
        documentTypeId +
        '" /></td>' +
        '<td><a href="' +
        billFileURL +
        '" target="_blank">' +
        billFileName +
        "</a>" +
        '<span class="d-none">' +
        '<input type="file" name="bill_file[]" id="' +
        uniqueId +
        '">' +
        "</span>" +
        '<input type="hidden" name="bill_file_name[]" value="' +
        billFileName +
        '" /></td>' +
        "<td>" +
        billFileSize +
        '<input type="hidden" name="bill_file_size[]" value="' +
        billFileSize +
        '" /></td>' +
        "<td>" +
        remark +
        '<input type="hidden" name="remark[]" value="' +
        remark +
        '" /></td>' +
        "<td>" +
        documentDate +
        '<input type="hidden" name="document_date[]" value="' +
        documentDate +
        '" /></td>' +
        "<td>" +
        billAmount +
        '<input type="hidden" name="bill_amount[]" value="' +
        billAmount +
        '" /></td>' +
        "<td>" +
        headingText +
        '<input type="hidden" name="heading_id[]" value="' +
        headingId +
        '" /></td>' +
        "<td>" +
        subHeadingText +
        '<input type="hidden" name="sub_heading_id[]" value="' +
        subHeadingId +
        '" /></td>' +
        "<td>" +
        clinicalFacilityName +
        '<input type="hidden" name="clinical_facility_name[]" value="' +
        clinicalFacilityName +
        '" /></td>' +
        "<td>" +
        diagnosisTreatment +
        '<input type="hidden" name="diagnosis_treatment[]" value="' +
        diagnosisTreatment +
        '" /></td>' +
        "<td>" +
        '<button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i> View</button> ' +
        '<button class="btn btn-warning btn-sm text-white editRow"><i class="fas fa-edit"></i> Edit</button> ' +
        '<button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i> Delete</button>' +
        "</td>";

    closestTr.append(newRow);
    // Get the selected file from the first input
    var fileInput1 = $("#viewEditModal").find('input[name="bill_file"]')[0];
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
    modifyRemainingHeadingAmount();
    $("#btnRecordUpdate").prop("disabled", false);
    $("#btnRecordUpdate").html($("#btnRecordUpdate").data("original-text"));
    $("#viewEditModal").modal("hide");
    showNotification("Record Data Updated Sucessfully.", "success");
});

$(document).on("change", "#employee_id", function () {
    let employee_id = $("#employee_id").find(":selected").val();
    var employeeName = $("#employee_id option:selected").text();
    employeeName = employeeName.replace(/\s*\(.*?\)\s*/g, "");
    $("#employee_name").val($.trim(employeeName));
    populate_members(employee_id);
});
function populate_members(id, selected = null) {
    if (!id) {
        return;
    }
    let dataurl = "get-relatives/" + id;
    var request = getRequest(dataurl);
    // $('#member_id option').remove();
    $('#member_id option[value!=""]').remove();
    let totalInsured = 0;
    let totalClaimed = 0;
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response.relatives, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                $("#member_id").append(
                    '<option value="' +
                        option.id +
                        '" data-id="' +
                        option.id +
                        '"' +
                        (isSelected
                            ? " selected"
                            : "" + 'data-rel="' + option.rel_relation + '"') +
                        ">" +
                        option.rel_name +
                        "</option>"
                );
            });
            $("#destination_id").val(res.response.details.designation);
            $("#relation_id").val("");
            $("#branch_id").val(res.response.details.branch);
            $("#expiryDate").html(res.response.details.expiry_date);
            $("#policy_no").val(res.response.details.policy_no);
            // $("#document_date").attr(
            //     "data-end_date",
            //     res.response.details.end_date
            // );
            // $("#document_date_bs").attr(
            //     "data-end_date",
            //     NepaliFunctions.AD2BS(res.response.details.end_date)
            // );
            $(".heading_select").empty();
            $(".heading_select").append(
                '<option value="">Select Heading</option>'
            );
            documentEndDateOfMember = res.response.details.end_date;
            // let imitation_date = new Date();
            // imitation_date.setDate(
            //     imitation_date.getDate() -
            //         parseInt(res.response.details.imitation_days)
            // );
            // // currentDate.setDate(currentDate.getDate() - 5);
            // $("#document_date").val(null);
            // $("#document_date_bs").val(null).trigger("change");
            // $("#document_date, #edit_document_date").attr({
            //     min: formatDate(imitation_date),
            //     max: formatDate(new Date()),
            // });

            // $("#document_date_bs").nepaliDatePicker({
            //     ndpYear: true,
            //     ndpMonth: true,
            //     ndpYearCount: 15,
            //     readOnlyInput: true,
            //     disableBefore: NepaliFunctions.AD2BS(
            //         formatDate(imitation_date)
            //     ),
            //     disableAfter: NepaliFunctions.AD2BS(formatDate(new Date())),
            //     onChange: function (e) {
            //         $("#document_date").val(e.ad);
            //     },
            // });
            headingImitationDaysData = {};
            $.each(res.response.headings, function (index, heading) {
                $(".heading_select").append(
                    '<option value="' +
                        heading.heading_id +
                        '">' +
                        toUpperCase(heading?.heading?.name) +
                        "</option>"
                );
                // headingImitationDaysData[heading.heading_id] =
                //     heading.imitation_days
                //         ? parseInt(heading.imitation_days)
                //         : 0;
                if ( res.response.details.member_type==='individual') {
                    headingImitationDaysData[heading.heading_id] =
                         res.response.details.imitation_days
                            ? parseInt( res.response.details.imitation_days)
                            : 0;
                } else {
                    
                    headingImitationDaysData[heading.heading_id] =
                         heading.imitation_days
                             ? parseInt(heading.imitation_days)
                             : 0;
                }
            });
            $("#heading_id").select2({
                theme: "bootstrap-5",
                width: "100%",
                placeholder: $(this).data("placeholder"),
            });
            headingAmountData = {};
            $("#headingSpan").empty();
            $.each(res.response.policy, function (index, option) {
                totalInsured += parseInt(option.insuranced_amount);
                totalClaimed += parseInt(option.claimed_amount);
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
                let remaining =
                    option.insuranced_amount - option.claimed_amount;
                headingAmountData[option.heading_id] = remaining;

                $("#headingSpan").append(
                    '<span class="d-block mb-1" data-heading_id="' +
                        option.heading_id +
                        '">' +
                        toUpperCase(option.heading_name) +
                        ": <span>Rs." +
                        formatNepaliCurrency(remaining) +
                        " / Rs. " +
                        formatNepaliCurrency(option.insuranced_amount) +
                        "</span> </span>"
                );
            });
            let totalAmount = Math.max(totalInsured - totalClaimed, 0);
            // Update the HTML and the attribute accordingly
            $("#totalInsuredAmount").html(formatNepaliCurrency(totalAmount));
            $("#all_totalInsuredAmount").html(
                formatNepaliCurrency(totalInsured)
            );
            $("#totalInsuredAmount").attr(
                "total",
                formatNepaliCurrency(totalAmount)
            );
            if (isSubmittedrefreshTable) {
                isSubmittedrefreshTable = false;
                refreshTable();
            }
        } else {
            $("#policy_no").val(null);
            $(".heading_select").empty();
            $(".heading_select").append(
                '<option value="">Select Heading</option>'
            );
            headingImitationDaysData = {};
            showNotification(res.message, "error");
        }
    });
}

$(document).on("change", "#member_id", function () {
    $("#relation_id").val($("#member_id").find(":selected").attr("data-rel"));
    let selectedMem = $(this).find(":selected").val();
    if (selectedMem) {
        memberChangeAction(selectedMem);
    } else {
        $("#employee_id").trigger("change");
    }
});

$(document).on(
    "change",
    "#heading_id,#resubmission_heading_id, #viewEditModal select[name='heading_id'], #resubmission_viewEditModal select[name='heading_id']",
    function () {
        let heading_id = $(this).find(":selected").val();
        let documentDateElementEn = null;
        let documentDateElementNp = null;
        let headingElement = $(this).attr("id");
        if (headingElement == "heading_id") {
            documentDateElementEn = $("#document_date");
            documentDateElementNp = $("#document_date_bs");
        } else if (headingElement == "resubmission_heading_id") {
            documentDateElementEn = $("#resubmission_document_date");
            documentDateElementNp = $("#resubmission_document_date_bs");
        } else if (headingElement == "edit_heading_id") {
            documentDateElementEn = $("#edit_document_date");
            documentDateElementNp = $("#edit_document_date_bs");
        }
        if (heading_id) {
            let imitation_date = null;
            if (headingImitationDaysData[heading_id]) {
                imitation_date = new Date();
                imitation_date.setDate(
                    imitation_date.getDate() -
                        parseInt(headingImitationDaysData[heading_id])
                );
            }
            // Check if documentDateElementEn exists, then set attributes and properties
            if (documentDateElementEn?.length) {
                documentDateElementEn.prop("disabled", false);
                // Clear previous date value and set min/max attributes
                const attributes = { max: formatDate(new Date()) };
                if (imitation_date) {
                    attributes.min = formatDate(imitation_date);
                }
                documentDateElementEn.attr(attributes);
                if (headingElement == "edit_heading_id") {
                    if ($("#edit_document_type").val() !== "bill") {
                        documentDateElementEn.removeAttr("min");
                    }
                }
            } else {
                console.warn(
                    "documentDateElementEn (#document_date) does not exist."
                );
            }

            // Check if documentDateElementNp exists, then initialize the Nepali date picker
            if (documentDateElementNp?.length) {
                documentDateElementNp.prop("disabled", false);
                // Clear previous date value and initialize the Nepali date picker
                documentDateElementNp.val(null).trigger("change");
                const disableBeforeDate = imitation_date
                    ? NepaliFunctions.AD2BS(formatDate(imitation_date))
                    : null;
                documentDateElementNp.nepaliDatePicker({
                    ndpYear: true,
                    ndpMonth: true,
                    ndpYearCount: 15,
                    readOnlyInput: true,
                    disableBefore: disableBeforeDate,
                    disableAfter: NepaliFunctions.AD2BS(formatDate(new Date())),
                    onChange: function (e) {
                        if (documentDateElementEn?.length) {
                            documentDateElementEn.val(e.ad);
                        }
                    },
                });
            } else {
                console.warn(
                    "documentDateElementNp (#document_date_bs) does not exist."
                );
            }
        } else {
            documentDateElementEn.val(null);
            documentDateElementNp.val(null);
            documentDateElementEn.prop("disabled", true);
            documentDateElementNp.prop("disabled", true);
            documentDateElementEn.removeAttr("data-end_date");
        }
        let elememtSelected = null;
        if ($(this).is("#heading_id")) {
            elememtSelected = "#sub_heading_id";
        } else if ($(this).is("#resubmission_heading_id")) {
            elememtSelected = "#resubmission_sub_heading_id";
        } else if ($(this).closest("#viewEditModal").length > 0) {
            elememtSelected = "#viewEditModal select[name='sub_heading_id']";
        } else if ($(this).closest("#resubmission_viewEditModal").length > 0) {
            elememtSelected =
                "#resubmission_viewEditModal select[name='sub_heading_id']";
        }
        populateSubHeading(heading_id, null, elememtSelected);
    }
);
function populateSubHeading(
    id,
    selected = null,
    subheading_element_id = "#sub_heading_id"
) {
    let selectedEmp;
    if (
        subheading_element_id == "#resubmission_sub_heading_id" ||
        subheading_element_id == "#resubmission_edit_sub_heading_id" ||
        subheading_element_id ==
            "#resubmission_viewEditModal select[name='sub_heading_id']"
    ) {
        selectedEmp = $("#resubmission_employee_id").text().trim();
    } else if (subheading_element_id == "#old_sub_heading_id") {
        selectedEmp = $("#old_employee_id").find(":selected").val();
    } else if (
        subheading_element_id == "#viewEditModal select[name='sub_heading_id']"
    ) {
        if ($("#viewEditModal form").attr("id") == "old_viewEditRecordForm") {
            selectedEmp = $("#old_employee_id").find(":selected").val();
        } else {
            selectedEmp = $("#employee_id").find(":selected").val();
        }
    } else {
        selectedEmp = $("#employee_id").find(":selected").val();
    }
    $(`${subheading_element_id} option[value!=""]`).remove();
    let dataurl = "get-sub-headings/" + id + "?employee_id=" + selectedEmp;
    if (id) {
        var request = getRequest(dataurl);
        request.done(function (res) {
            if (res.status === true) {
                $.each(res.response, function (index, option) {
                    var isSelected =
                        selected !== null &&
                        option.id.toString() === selected.toString();
                    //
                    $(subheading_element_id).append(
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
function refreshTable() {
    // Recalculate serial numbers
    serialNumber = 1;
    $("#addDataToTable tbody tr").each(function () {
        let $td = $(this).find("td:first");
        let isChecked = $td
            .find('input[type="checkbox"].serial_number')
            .prop("checked");

        $td.html(
            serialNumber +
                '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
                serialNumber +
                '"' +
                (isChecked ? " checked" : "") +
                " />"
        );
        serialNumber++;
    });
    if (serialNumber > 1) {
        $("#addDataToTable tfoot").removeClass("d-none");
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
    }

    modifyRemainingHeadingAmount();
}
$(document).on("click", "#addDataToTableReset", function () {
    let member_id = $("#member_id").val();
    if (member_id) {
        $("#member_id").trigger("change");
    } else {
        $("#employee_id").trigger("change");
    }
    resetDataToTable(true);
});
function resetDataToTable(notify) {
    serialNumber = 0;
    $("#addDataToTable tbody").html("");
    if (serialNumber >= 1) {
        $("#addDataToTable tfoot").removeClass("d-none");
        $("#clearBtnAppend").html(
            '<button type="button" class="mx-1 btn btn-danger labelsmaller btn-sm float-end" id="addDataToTableReset">Reset <i class="fa-sharp fas fa-brush "></i></button>'
        );
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", true);
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
        $("#clearBtnAppend").html("");
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", false);
    }
    // Increment the serial number for the next row
    serialNumber++;

    // Optionally, reset the form
    $("#addDataToTableAdd").prop("disabled", false);
    $("#addDataToTableAdd").html($("#addDataToTableAdd").data("original-text"));
    if (notify == true) {
        showNotification("Data Reset Sucessfully.", "success");
    }
    $("#heading_id, #sub_heading_id").trigger("change");
}

$(document).on(
    "change",
    "#document_type_id,#resubmission_document_type_id",
    function () {
        // Determine the ID of the bill amount based on the document type
        var billAmountId =
            $(this).attr("id") == "resubmission_document_type_id"
                ? "#resubmission_bill_amount"
                : "#bill_amount";
        if ($(this).val() == "prescription" || $(this).val() == "report") {
            $(billAmountId).val(0);
            $(billAmountId).closest("div").addClass("d-none");
        } else $(billAmountId).closest("div").removeClass("d-none");
    }
);

$(document).on(
    "change",
    "#edit_document_type,#resubmission_edit_document_type",
    function () {
        var billAmountId =
            $(this).attr("id") == "resubmission_edit_document_type"
                ? "#resubmission_edit_bill_amount"
                : "#edit_bill_amount";
        if ($(this).val() == "prescription" || $(this).val() == "report") {
            $(billAmountId).val(0);
            $(billAmountId).closest("div").addClass("d-none");
        } else $(billAmountId).closest("div").removeClass("d-none");
    }
);

function memberChangeAction(id, selected = null) {
    let dataurl = "get-ralatives-amt/" + id;
    var request = getRequest(dataurl);
    // $('#member_id option').remove();
    let totalInsured = 0;
    let totalClaimed = 0;
    request.done(function (res) {
        if (res.status === true) {
            $(".heading_select").empty();
            $(".heading_select").append(
                '<option value="">Select Heading</option>'
            );
            headingImitationDaysData = {};
            $.each(res.response.headings, function (index, heading) {
                $(".heading_select").append(
                    '<option value="' +
                        heading.heading_id +
                        '">' +
                        heading?.heading?.name +
                        "</option>"
                );
                headingImitationDaysData[heading.heading_id] =
                    heading.imitation_days
                        ? parseInt(heading.imitation_days)
                        : 0;
            });
            $("#heading_id").select2({
                theme: "bootstrap-5",
                width: "100%",
                placeholder: $(this).data("placeholder"),
            });
            $("#headingSpan").empty();
            headingAmountData = {};
            $.each(res.response.policy, function (index, option) {
                totalInsured += parseInt(option.insuranced_amount);
                totalClaimed += parseInt(option.claimed_amount);
                // $("#headingSpan").append(
                //     '<span class="d-block mb-1">' +
                //         option.heading_name +
                //         ": <span>Rs." +
                //         option.insuranced_amount +
                //         " / Rs." +
                //         option.claimed_amount +
                //         "</span> </span>"
                // );
                let remaining =
                    option.insuranced_amount - option.claimed_amount;
                headingAmountData[option.heading_id] = remaining;
                $("#headingSpan").append(
                    '<span class="d-block mb-1" data-heading_id="' +
                        option.heading_id +
                        '">' +
                        toUpperCase(option.heading_name) +
                        ": <span>Rs." +
                        formatNepaliCurrency(
                            option.insuranced_amount - option.claimed_amount
                        ) +
                        " / Rs. " +
                        formatNepaliCurrency(option.insuranced_amount) +
                        "</span> </span>"
                );
            });
            let remainingtotalAmount = Math.max(totalInsured - totalClaimed, 0);
            $("#totalInsuredAmount").html(
                formatNepaliCurrency(remainingtotalAmount)
            );
            $("#all_totalInsuredAmount").html(
                formatNepaliCurrency(totalInsured)
            );
            // $("#totalClaimedAmount").html(totalClaimed);
            if (isSubmittedrefreshTable) {
                isSubmittedrefreshTable = false;
                refreshTable();
            }
        } else {
            showNotification(res.message, "error");
        }
    });
}

//Resubmission
//for resubmission
$(document).on("click", ".nav-tabs button", function () {
    $("#resubmission_Div").removeClass("d-none");
    clearRequiredStyleAttributes();

    $("#resubmission_ClaimId").val("").trigger("change");
    if ($(this).attr("id") === "nav-new-tab") {
        $("#employee_id").val("").trigger("change");
        $("#addDataToTableReset").trigger("click");
        $("#destination_id").val("");
        $("#relation_id").val("");
        $("#branch_id").val("");
        $("#expiryDate").html("YYYY/MM/DD");
        $("#policy_no").val("");
        $("#totalInsuredAmount").html("0");
        $("#document_date").attr("data-end_date", "");
        $('#member_id option[value!=""]').remove();
        $(".heading_select").empty();
        $(".heading_select").append('<option value="">Select Heading</option>');
        $("#headingSpan").empty();
        $("#sub_heading_id option[value='']").remove();
        $("#addDataToTableForm")[0].reset();
        resetDataToTable(false);
        $("#addDataToTable tbody").empty();
        $("table tfoot").addClass("d-none");
        $("#document_date").val(null);
        $("#document_date_bs").val(null);
        $("#document_date").prop("disabled", true);
        $("#document_date_bs").prop("disabled", true);
    } else if ($(this).attr("id") === "nav-resubmission-tab") {
        $("#resubmission_ClaimId").val("").trigger("change");
        $(".resubmission_heading_select").empty();
        $(".resubmission_heading_select").append(
            '<option value="">Select Heading</option>'
        );
        $("#resubmission_sub_heading_id option[value='']").remove();

        $("#resubmission_employee_id").text("");
        $("#resubmission_employee_name").text("");
        $("#reasonSection").text("");
        $("#resubmission_destination_id").text("");
        $("#resubmission_member_id").text("");
        $("#resubmission_relation_id").text("");
        $("#resubmission_branch_id").text("");
        $("#resubmission_expiryDate").html("");
        $("#resubmission_policy_no").text("");
        $("#resubmission_document_date").attr("data-end_date", "");

        $("#resubmission_AddDataToTableForm")[0].reset();
        $("#resubmission_DataToTable tbody").empty();
        $("table tfoot").addClass("d-none");
        $("#resubmission_document_date").val(null);
        $("#resubmission_document_date_bs").val(null);
        $("#resubmission_document_date").prop("disabled", true);
        $("#resubmission_document_date_bs").prop("disabled", true);
    } else if ($(this).attr("id") === "nav-old-tab") {
        $("#old_employee_id").val("").trigger("change");
        $("#old_addDataToTableReset").trigger("click");
        $("#old_destination_id").val("");
        $("#old_relation_id").val("");
        $("#old_branch_id").val("");
        $("#old_expiryDate").html("YYYY/MM/DD");
        $("#old_policy_no").val("");
        $("#old_totalInsuredAmount").html("0");
        $("#old_document_date").attr("data-end_date", "");
        $('#old_member_id option[value!=""]').remove();
        $(".heading_select").empty();
        $(".heading_select").append('<option value="">Select Heading</option>');
        $("#old_headingSpan").empty();
        $("#old_sub_heading_id option[value='']").remove();
        $("#old_addDataToTableForm")[0].reset();
        old_resetDataToTable(false);
        $("#old_addDataToTable tbody").empty();
        $("table tfoot").addClass("d-none");
        $("#old_document_date").val(null);
        $("#old_document_date_bs").val(null);
        $("#old_document_date").prop("disabled", true);
        $("#old_document_date_bs").prop("disabled", true);
    }
});
function old_resetDataToTable(notify) {
    old_serialNumber = 0;
    $("#old_addDataToTable tbody").html("");
    if (old_serialNumber >= 1) {
        $("#old_addDataToTable tfoot").removeClass("d-none");
        $("#old_clearBtnAppend").html(
            '<button type="button" class="mx-1 btn btn-danger labelsmaller btn-sm float-end" id="addDataToTableReset">Reset <i class="fa-sharp fas fa-brush "></i></button>'
        );
        $("#old_employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", true);
    } else {
        $("#old_addDataToTable tfoot").addClass("d-none");
        $("#old_clearBtnAppend").html("");
        $("#old_employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", false);
    }
    // Increment the serial number for the next row
    old_serialNumber++;

    // Optionally, reset the form
    $("#old_addDataToTableAdd").prop("disabled", false);
    $("#old_addDataToTableAdd").html(
        $("#old_addDataToTableAdd").data("original-text")
    );
    if (notify == true) {
        showNotification("Data Reset Sucessfully.", "success");
    }
    $("#old_heading_id, #old_sub_heading_id").trigger("change");
}
$(document).on("change", "#resubmission_ClaimId", function () {
    let claim_id = $(this).find(":selected").val();
    if (claim_id) {
        let dataurl = "get-claimid-data/" + claim_id;
        var request = ajaxRequest(dataurl);
        request.done(function (res) {
            if (res.status === true) {
                resubmission_populate_members(res.response);

                addDatasToTable(res.response.insuranceClaim);
                $("#resubmission_Div").removeClass("d-none");
            } else {
                showNotification(res.message, "error");
            }
        });
    } else {
        $("#resubmission_DataToTable tbody").empty();
        $("#resubmission_DataToTable tfoot").addClass("d-none");
        // $("#nav-resubmission-tab").trigger("click");
        $("#resubmission_Div").addClass("d-none");
    }
});
function resubmission_populate_members(response) {
    let details = response?.details;
    let resubmission_employee_id = details?.member_id;
    var employeeName = details?.member_name;
    $("#resubmission_employee_id").text(resubmission_employee_id);
    $("#resubmission_employee_name").text($.trim(employeeName));
    $("#reasonSection").text(details?.reason);
    $("#resubmission_destination_id").text(details?.designation);
    $("#resubmission_member_id").text(details?.relative_name);
    $("#resubmission_relation_id").text(details?.relative_relation);
    $("#resubmission_branch_id").text(details?.branch);
    $("#resubmission_expiryDate").html(details?.expiry_date);
    $("#resubmission_policy_no").text(details?.policy_no);
    $("#resubmission_document_date").attr("data-end_date", details?.end_date);
    $(".resubmission_heading_select").empty();
    $(".resubmission_heading_select").append(
        '<option value="">Select Heading</option>'
    );
    documentEndDateOfMember = details?.end_date;
    // let imitation_date = new Date();
    // imitation_date.setDate(
    //     imitation_date.getDate() - parseInt(details?.imitation_days)
    // );
    // currentDate.setDate(currentDate.getDate() - 5);
    // $("#resubmission_document_date, #resubmission_edit_document_date").attr({
    //     min: formatDate(imitation_date),
    //     max: formatDate(new Date()),
    // });
    headingImitationDaysData = {};
    $.each(response.headings, function (index, heading) {
        $(".resubmission_heading_select").append(
            '<option value="' +
                heading.heading_id +
                '">' +
                heading?.heading?.name +
                "</option>"
        );
        // headingImitationDaysData[heading.heading_id] = heading.imitation_days
        //     ? parseInt(heading.imitation_days)
        //     : 0;
    });
    $("#resubmission_heading_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
    $("#resubmission_headingSpan").empty();
    let totalInsured = 0;
    let totalClaimed = 0;
    headingAmountData = {};
    $.each(response.policy, function (index, option) {
        totalInsured += parseInt(option.insuranced_amount);
        totalClaimed += parseInt(option.claimed_amount);
        let remaining = option.insuranced_amount - option.claimed_amount;
        headingAmountData[option.heading_id] = remaining;
        $("#resubmission_headingSpan").append(
            '<span class="d-block mb-1" data-heading_id="' +
                option.heading_id +
                '">' +
                toUpperCase(option.heading_name) +
                ": <span>Rs." +
                formatNepaliCurrency(
                    option.insuranced_amount - option.claimed_amount
                ) +
                " / Rs. " +
                formatNepaliCurrency(option.insuranced_amount) +
                "</span> </span>"
        );
    });
    // $("#resubmission_totalInsuredAmount").html(totalInsured - totalClaimed);
    let remainingtotalAmount = Math.max(totalInsured - totalClaimed, 0);
    $("#resubmission_totalInsuredAmount").html(
        formatNepaliCurrency(remainingtotalAmount)
    );
    $("#all_resubmission_totalInsuredAmount").html(
        formatNepaliCurrency(totalInsured)
    );
}
function addDatasToTable(data) {
    let htmlOutput = "";
    counterInitialRecords = parseInt(data.length);
    $.each(data, function (index, row) {
        // Get input values
        serialNumberResubmission = ++index;
        var memberId = row.member_id;
        var headingId = row.heading_id;
        var headingText = toUpperCase(row.insurance_heading_name);
        var subHeadingId = row.sub_heading_id;
        var subHeadingText = row.insurance_sub_heading_name;

        var documentTypeId = row.document_type;
        var documentTypeText = $("#viewEditModal")
            .find(
                'select[name="document_type"] option[value="' +
                    documentTypeId +
                    '"]'
            )
            .text();
        //need to change
        var billFileInput = $("#viewEditModal").find(
            'input[name="bill_file"]'
        )[0].files[0];

        var billFileName = row.bill_file_name;
        var documentDate = row.document_date;
        var billAmount = row.bill_amount;
        var clinicalFacilityName = row.clinical_facility_name;
        var remark = row.remark;
        var diagnosisTreatment = row.diagnosis_treatment;
        if (row.file_path) {
            row.file_path = "/" + row.file_path;
        }

        // Get file name, size, and URL
        var billFile = row.file_path ? row.bill_file_name : "";
        var billFileSize = row.bill_file_size;

        var billFileURL = row.file_path ? row.file_path : "";
        billFileName = billFileName ? billFileName : billFile;

        var uniqueId = "bill_file_" + Date.now() + "_" + Date.now();

        // Find the checkbox with name="submission_id[]" and value="5"
        var checkbox = $(
            'input[name="submission_id[]"][value="' +
                serialNumberResubmission +
                '"]'
        );
        // Check if the checkbox is checked
        var isChecked = checkbox.is(":checked");
        // Find the closest tr element to the checkbox
        var closestTr = checkbox.closest("tr");
        closestTr.html("");
        // Append a new row to the table
        var newRow =
            "<tr data-rowno='" +
            serialNumberResubmission +
            "'><td>" +
            serialNumberResubmission +
            "<input type='hidden' name='claim_submission_id[]' value='" +
            row.id +
            "' /><input type='hidden' name='member_id[]' value='" +
            memberId +
            "' /></td>" +
            "<td>" +
            documentTypeText +
            '<input type="hidden" name="document_type[]" value="' +
            documentTypeId +
            '" /></td>' +
            '<td><a href="' +
            billFileURL +
            '" target="_blank">' +
            billFileName +
            "</a>" +
            '<span class="d-none">' +
            '<input type="file" name="bill_file[]" id="' +
            uniqueId +
            '"><input type="hidden" name="bill_file_url[]" value="' +
            billFileURL +
            '">' +
            "</span>" +
            '<input type="hidden" name="bill_file_name[]" value="' +
            billFileName +
            '" /></td>' +
            "<td>" +
            billFileSize +
            '<input type="hidden" name="bill_file_size[]" value="' +
            billFileSize +
            '" /></td>' +
            "<td>" +
            remark +
            '<input type="hidden" name="remark[]" value="' +
            remark +
            '" /></td>' +
            "<td>" +
            documentDate +
            '<input type="hidden" name="document_date[]" value="' +
            documentDate +
            '" /></td>' +
            "<td>" +
            billAmount +
            '<input type="hidden" name="bill_amount[]" value="' +
            billAmount +
            '" /></td>' +
            "<td>" +
            headingText +
            '<input type="hidden" name="heading_id[]" value="' +
            headingId +
            '" /></td>' +
            "<td>" +
            subHeadingText +
            '<input type="hidden" name="sub_heading_id[]" value="' +
            subHeadingId +
            '" /></td>' +
            "<td>" +
            clinicalFacilityName +
            '<input type="hidden" name="clinical_facility_name[]" value="' +
            clinicalFacilityName +
            '" /></td>' +
            "<td>" +
            diagnosisTreatment +
            '<input type="hidden" name="diagnosis_treatment[]" value="' +
            diagnosisTreatment +
            '" /></td>' +
            "<td>" +
            '<button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i> View</button> ' +
            "</td></tr>";
        htmlOutput += newRow;
    });
    $("#resubmission_DataToTable tbody").html(htmlOutput);
    serialNumberResubmission++;
}
$(document).off("submit", "#resubmission_AddDataToTableForm", function () {});
$(document).on("submit", "#resubmission_AddDataToTableForm", function (e) {
    e.preventDefault();
    // Validate form data
    var isValid = true;
    var headingId = $("#resubmission_heading_id").val();
    var billAmount = $("#resubmission_bill_amount").val();

    let errorMsg;
    $(
        "#resubmission_AddDataToTableForm input, #resubmission_AddDataToTableForm select"
    ).each(function () {
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
        // Additional validation for bill_amount
        if ($(this).attr("name") === "bill_amount") {
            if (
                isRequired &&
                (value.trim() == "" || isNaN(value) || value < 0)
            ) {
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
            //modify
            // Check if headingId exists in headingAmountData, otherwise return 0
            headingAmountData[headingId] = headingAmountData[headingId]
                ? headingAmountData[headingId]
                : 0;

            // Check if headingId exists in headingAmountDataClaimed, otherwise return 0
            headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                headingId
            ]
                ? headingAmountDataClaimed[headingId]
                : 0;

            let remainingAmount =
                parseFloat(
                    headingAmountData[headingId] -
                        headingAmountDataClaimed[headingId]
                ) || 0;
            if (billAmount > remainingAmount) {
                isValid = false;
                $(this).attr("style", "border-color: #dc3545 !important");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .attr("style", "border-color: #dc3545 !important");
                errorMsg = "The bill amount exceeds the remaining amount.";
            }
        }

        // Additional validation for bill_file
        if ($(this).attr("name") === "bill_file" && isRequired) {
            var file = $(this)[0].files[0];
            if (file) {
                var fileType = file.type;
                var validTypes = [
                    // "application/pdf",
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

        // Additional validation for document_date
        if ($(this).attr("name") === "document_date" && isRequired) {
            // Assuming 'value' contains the date input value in YYYY-MM-DD format
            var value = $(this).val();
            // var endDate = documentEndDateOfMember;
            var endDate = null;
            if (headingImitationDaysData[headingId]) {
                let imitation_date = new Date();
                imitation_date.setDate(
                    imitation_date.getDate() -
                        parseInt(headingImitationDaysData[headingId])
                );
                endDate = formatDate(imitation_date);
            }
            // Assuming 'value' contains the date input value
            // Example: YYYY-MM-DD format
            var isValidDate = /^\d{4}-\d{2}-\d{2}$/.test(value);
            if (!isValidDate) {
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
                var documentDate = new Date(value);
                var dataEndDate = new Date(endDate);
                if ($("#resubmission_employee_id").text().trim()) {
                    if (endDate) {
                        // if (documentDate > dataEndDate) {
                        if (
                            documentDate < dataEndDate ||
                            documentDate > currentDate
                        ) {
                            isValid = false;
                            $(this).attr(
                                "style",
                                "border-color: #dc3545 !important"
                            );
                            $(this)
                                .next(".select2-container")
                                .find(".select2-selection")
                                .attr(
                                    "style",
                                    "border-color: #dc3545 !important"
                                );
                            // Add validation error message here if needed
                            errorMsg =
                                "Document date must be within Imitation days.";
                        } else {
                            $(this).css("border-color", "");
                            $(this)
                                .next(".select2-container")
                                .find(".select2-selection")
                                .css("border-color", "");
                            $(this).next(".error-message").text(""); // Clear any previous error message
                        }
                        $(this).css("border-color", "");
                        $(this)
                            .next(".select2-container")
                            .find(".select2-selection")
                            .css("border-color", "");
                        $(this).next(".error-message").text(""); // Clear any previous error message
                    } else {
                        // $("#employee_id").attr(
                        //     "style",
                        //     "border-color: #dc3545 !important"
                        // );
                        // errorMsg = "Please select the policy of the client.";
                        // isValid = false;
                    }
                } else {
                    $("#employee_id").attr(
                        "style",
                        "border-color: #dc3545 !important"
                    );
                    isValid = false;
                    errorMsg = "Please select the employee.";
                }
            }
        }
    });

    if (!isValid) {
        $("#resubmission_addDataToTableAdd").prop("disabled", false);
        $("#resubmission_addDataToTableAdd").html(
            $("#resubmission_addDataToTableAdd").data("original-text")
        );
        errorMsg =
            errorMsg ?? "Please fill valid data in all required fields..";
        showNotification(errorMsg, "error");
        return;
    }
    // Get input values
    var headingText = $("#resubmission_heading_id option:selected").text();
    var subheadingId = $("#resubmission_sub_heading_id").val();
    var subheadingText = $(
        "#resubmission_sub_heading_id option:selected"
    ).text();

    var documentTypeId = $("#resubmission_document_type_id").val();
    var documentTypeText = $(
        "#resubmission_document_type_id option:selected"
    ).text();
    var billFileInput = $("#resubmission_bill_file")[0].files[0];
    var billFileName = $("#resubmission_bill_file_name").val();
    var documentDate = $("#resubmission_document_date").val();
    var clinicalFacilityName = $("#resubmission_clinical_facility_name").val();
    var remark = $("#resubmission_remark").val();
    var clinicalFacilityName = $("#resubmission_clinical_facility_name").val();
    var diagnosisTreatment = $("#resubmission_diagnosis_treatment").val();

    // Get file name, size, and URL
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileSize = billFileInput
        ? (billFileInput.size / 1024).toFixed(2) + " KB"
        : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    billFileName = billFileName ? billFileName : billFile;

    $("#resubmission_clinical_facility_name_section").val(clinicalFacilityName);

    var uniqueId = "bill_file_resubmission" + Date.now() + "_" + Date.now();
    // Append a new row to the table
    var newRow =
        '<tr data-rowno="' +
        serialNumberResubmission +
        '">' +
        "<td><span>" +
        serialNumberResubmission +
        `</span><input type="checkbox" name="serial_number[]" class="serial_number" value="` +
        serialNumberResubmission +
        '" /></td>' +
        `<td id="row_document_type${serialNumberResubmission}">` +
        `<span>${documentTypeText}</span>` +
        `<input type="hidden" name="document_type[]" value="` +
        documentTypeId +
        '" /></td>' +
        `<td id="row_bill_file_name${serialNumberResubmission}"><a href="` +
        billFileURL +
        '" target="_blank">' +
        billFileName +
        "</a>" +
        '<span class="d-none">' +
        '<input type="file" name="bill_file[]" id="' +
        uniqueId +
        '">' +
        "</span>" +
        `<input type="hidden" name="bill_file_name[]" value="` +
        billFileName +
        '" /></td>' +
        `<td>` +
        billFileSize +
        '<input type="hidden" name="bill_file_size[]" value="' +
        billFileSize +
        '" /></td>' +
        `<td id="row_remark${serialNumberResubmission}">` +
        `<span>${remark}</span>` +
        `<input type="hidden" name="remark[]" value="` +
        remark +
        '" /></td>' +
        `<td id="row_document_date${serialNumberResubmission}">` +
        `<span>${documentDate}</span>` +
        `<input type="hidden" name="document_date[]" value="` +
        documentDate +
        '" /></td>' +
        `<td id="row_bill_amount${serialNumberResubmission}">` +
        `<span>${billAmount}</span>` +
        `<input type="hidden" name="bill_amount[]" value="` +
        billAmount +
        '" /></td>' +
        `<td id="row_heading_id${serialNumberResubmission}">` +
        `<span>${headingText}</span>` +
        `<input type="hidden" name="heading_id[]" value="` +
        headingId +
        '" /></td>' +
        `<td id="row_sub_heading_id${serialNumberResubmission}">` +
        `<span>${subheadingText}</span>` +
        `<input type="hidden" name="sub_heading_id[]" value="` +
        subheadingId +
        '" /></td>' +
        `<td id="row_clinical_facility_name${serialNumberResubmission}">` +
        `<span>${clinicalFacilityName}</span>` +
        `<input type="hidden" name="clinical_facility_name[]" value="` +
        clinicalFacilityName +
        '" /></td>' +
        `<td id="row_diagnosis_treatment${serialNumberResubmission}">` +
        `<span>${diagnosisTreatment}</span>` +
        `<input type="hidden" name="diagnosis_treatment[]" value="` +
        diagnosisTreatment +
        '" /></td>' +
        "<td>" +
        '<button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i> View</button> ' +
        '<button class="btn btn-warning btn-sm text-white editRow"><i class="fas fa-edit"></i> Edit</button> ' +
        '<button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i> Delete</button>' +
        "</td>" +
        "</tr>";

    $("#resubmission_DataToTable tbody").append(newRow);
    // Get the selected file from the first input
    var fileInput1 = $("#resubmission_bill_file")[0];
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

    if (serialNumberResubmission >= 1) {
        $("#addDataToTable tfoot").removeClass("d-none");
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", true);
    } else {
        $("#addDataToTable tfoot").addClass("d-none");
        $("#clearBtnAppend").html("");
        $("#employeeDetailsDiv")
            .find("input, select, textarea, button")
            .attr("disabled", false);
    }
    // Increment the serial number for the next row
    serialNumberResubmission++;
    //Reduce Amount
    modifyRemainingHeadingAmount("resubmission");
    // Optionally, reset the form
    this.reset();
    var counter = $("#resubmission_DataToTable tbody tr").length;
    if (counter > counterInitialRecords) {
        $("#resubmission_DataToTable tfoot").removeClass("d-none");
    } else {
        $("#resubmission_DataToTable tfoot").addClass("d-none");
    }
    $("#resubmission_addDataToTableAdd").prop("disabled", false);
    $("#resubmission_addDataToTableAdd").html(
        $("#resubmission_addDataToTableAdd").data("original-text")
    );
    showNotification("Data Added Sucessfully.", "success");
    $("#resubmission_heading_id, #resubmission_sub_heading_id").trigger(
        "change"
    );
});
// Handle row deletion
$("#resubmission_DataToTable").on("click", ".deleteRow", function () {
    $(this).closest("tr").remove();
    refreshResubmissionTable();
});
let resubmission_editClaimHeadingId = null;
let resubmission_editClaimAmount = null;
// When the modal is closed, reset the variables
$("#resubmission_viewEditModal").on("hidden.bs.modal", function () {
    // Reset the variables to null when the modal is closed
    resubmission_editClaimHeadingId = null;
    resubmission_editClaimAmount = null;
});
$("#resubmission_DataToTable").on("click", ".editRow,.viewRow", function (e) {
    e.preventDefault();
    // Check if it's an editRow click
    var isEdit = $(this).hasClass("editRow");
    let $tr = $(this).closest("tr");
    let row_no = $tr.data("rowno");
    edit_row_no = row_no;
    var formElements = $(
        "#resubmission_viewEditModal input, #resubmission_viewEditModal select"
    ).prop("disabled", false);
    $("#resubmission_viewEditModal #resubmission_fileUrl").html("");
    // Iterate over all input elements within the <tr>
    let bill_file_url = $tr.find('input[name="bill_file_url[]"]').val();
    $tr.find("input").each(function () {
        var inputName = $(this).attr("name").replace("[]", "");
        var inputValue = $(this).val();
        if (inputName == "heading_id") {
            resubmission_editClaimHeadingId = inputValue;
        }
        if (inputName == "bill_amount") {
            resubmission_editClaimAmount = parseFloat(inputValue);
        }
        if ($(this).attr("type") === "file") {
            // Check if the input type is file
            // Check if files are selected sss
            if (bill_file_url) {
                $("#resubmission_viewEditModal #resubmission_fileUrl").html(
                    '<a href="' +
                        bill_file_url +
                        '" target="_blank" > View File</a>'
                );
            } else if (this.files.length > 0) {
                // Append the selected file to FormData
                var fileInput1 = $(this)[0];
                var file = fileInput1.files[0];

                if (file) {
                    // Create a new DataTransfer object
                    var dataTransfer = new DataTransfer();
                    // Add the selected file to the DataTransfer object
                    dataTransfer.items.add(file);
                    // Get the second file input and assign the files from DataTransfer object
                    var fileInput2 = $("#resubmission_viewEditModal").find(
                        'input[name="' + inputName + '"]'
                    )[0];
                    fileInput2.files = dataTransfer.files;
                    var billFileInput = file;
                    var billFileURL = billFileInput
                        ? URL.createObjectURL(billFileInput)
                        : "";
                    $("#resubmission_viewEditModal #resubmission_fileUrl").html(
                        '<a href="' +
                            billFileURL +
                            '" target="_blank" > View File</a>'
                    );
                }
            }
        } else {
            // Find corresponding input in `$("#resubmission_viewEditModal")` form by name attribute
            $("#resubmission_viewEditModal")
                .find('input[name="' + inputName + '"]')
                .val(inputValue);
            $("#resubmission_viewEditModal")
                .find('select[name="' + inputName + '"]')
                .val(inputValue)
                .trigger("change");
        }
        $("#resubmission_edit_heading_id").val();
    });
    populateSubHeading(
        $tr.find('input[name="heading_id[]"]').val(),
        $tr.find('input[name="sub_heading_id[]"]').val(),
        "#resubmission_edit_sub_heading_id"
    );
    // Select all input and select elements within the form
    if (isEdit) {
        $("#resubmission_viewEditModal #modalTitle").html("Edit Data");
        // Enable all input and select elements
        formElements.prop("disabled", false);
        $("#resubmission_viewEditModal #resubmission_submitBtn").html(
            '<button type="submit" class="btn btn-sm btn-success px-4 text-white" id="resubmission_btnRecordUpdate">Update</button>'
        );
    } else {
        $("#resubmission_viewEditModal #modalTitle").html("View Data");
        // Disable all input and select elements
        formElements.prop("disabled", true);
        $("#resubmission_viewEditModal #submitBtn").html("");
    }
    $("#resubmission_viewEditModal").modal("show");
});
function refreshResubmissionTable() {
    // Recalculate serial numbers
    serialNumberResubmission = counterInitialRecords + 1;
    $("#resubmission_DataToTable tbody tr").each(function (index) {
        if (index >= counterInitialRecords) {
            let $td = $(this).find("td:first");
            let isChecked = $td
                .find('input[type="checkbox"].serial_number')
                .prop("checked");

            $td.html(
                serialNumberResubmission +
                    '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
                    serialNumberResubmission +
                    '"' +
                    (isChecked ? " checked" : "") +
                    " />"
            );
            serialNumberResubmission++;
        }
    });
    var counter = $("#resubmission_DataToTable tbody tr").length;
    if (counter > counterInitialRecords) {
        $("#resubmission_DataToTable tfoot").removeClass("d-none");
    } else {
        $("#resubmission_DataToTable tfoot").addClass("d-none");
    }
    modifyRemainingHeadingAmount("resubmission");
}
$(document).off("submit", "#resubmission_viewEditRecordForm", function () {});
$(document).on("submit", "#resubmission_viewEditRecordForm", function (e) {
    e.preventDefault();
    // Validate form data
    var isValid = true;
    let errorMsg;
    var billAmount = $("#resubmission_viewEditModal")
        .find('input[name="bill_amount"]')
        .val();
    var headingId = $("#resubmission_viewEditModal")
        .find('select[name="heading_id"]')
        .val();
    $(
        "#resubmission_viewEditRecordForm input, #resubmission_viewEditRecordForm select"
    ).each(function () {
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
        // Additional validation for bill_amount
        if ($(this).attr("name") === "bill_amount") {
            if (
                isRequired &&
                (value.trim() == "" || isNaN(value) || value < 0)
            ) {
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
            //modify

            // Check if headingId exists in headingAmountData, otherwise return 0
            headingAmountData[headingId] = headingAmountData[headingId]
                ? headingAmountData[headingId]
                : 0;
            // Check if headingId exists in headingAmountDataClaimed, otherwise return 0
            headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                headingId
            ]
                ? headingAmountDataClaimed[headingId]
                : 0;

            let existingValue = 0;
            if (headingId == resubmission_editClaimHeadingId) {
                existingValue = resubmission_editClaimAmount;
            }
            let totalCLaimedAmount =
                headingAmountData[headingId] +
                existingValue -
                headingAmountDataClaimed[headingId];
            let remainingAmount = parseFloat(totalCLaimedAmount) || 0;
            if (billAmount > remainingAmount) {
                isValid = false;
                $(this).attr("style", "border-color: #dc3545 !important");
                $(this)
                    .next(".select2-container")
                    .find(".select2-selection")
                    .attr("style", "border-color: #dc3545 !important");
                errorMsg = "The bill amount exceeds the remaining amount.";
            }
        }

        // Additional validation for document_date
        if ($(this).attr("name") === "document_date" && isRequired) {
            // Assuming 'value' contains the date input value
            // Example: YYYY-MM-DD format
            var isValidDate = /^\d{4}-\d{2}-\d{2}$/.test(value);
            if (!isValidDate) {
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

        // Additional validation for bill_file
        if ($(this).attr("name") === "bill_file" && isRequired) {
            var file = $(this)[0].files[0];
            if (file) {
                var fileType = file.type;
                var validTypes = [
                    // "application/pdf",
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
    });

    if (!isValid) {
        $("#resubmission_btnRecordUpdate").prop("disabled", false);
        $("#resubmission_btnRecordUpdate").html(
            $("#resubmission_btnRecordUpdate").data("original-text")
        );
        errorMsg =
            errorMsg ?? "Please fill valid data in all required fields..";
        showNotification(errorMsg, "error");
        return;
    }
    // Get input values
    var serialNumber = $("#resubmission_viewEditModal")
        .find('input[name="serial_number"]')
        .val();
    var headingText = $("#resubmission_viewEditModal")
        .find('select[name="heading_id"] option:selected')
        .text();
    var subHeadingId = $("#resubmission_viewEditModal")
        .find('select[name="sub_heading_id"]')
        .val();
    var subHeadingText = $("#resubmission_viewEditModal")
        .find('select[name="sub_heading_id"] option:selected')
        .text();

    var documentTypeId = $("#resubmission_viewEditModal")
        .find('select[name="document_type"]')
        .val();
    var documentTypeText = $("#resubmission_viewEditModal")
        .find('select[name="document_type"] option:selected')
        .text();

    var billFileInput = $("#resubmission_viewEditModal").find(
        'input[name="bill_file"]'
    )[0].files[0];
    var billFileName = $("#resubmission_viewEditModal")
        .find('input[name="bill_file_name"]')
        .val();
    var documentDate = $("#resubmission_viewEditModal")
        .find('input[name="document_date"]')
        .val();
    var clinicalFacilityName = $("#resubmission_viewEditModal")
        .find('input[name="clinical_facility_name"]')
        .val();
    var remark = $("#resubmission_viewEditModal")
        .find('input[name="remark"]')
        .val();
    var diagnosisTreatment = $("#resubmission_viewEditModal")
        .find('input[name="diagnosis_treatment"]')
        .val();

    // Get file name, size, and URL
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileSize = billFileInput
        ? (billFileInput.size / 1024).toFixed(2) + " KB"
        : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    billFileName = billFileName ? billFileName : billFile;

    var uniqueId = "resubmission_bill_file_" + Date.now() + "_" + Date.now();

    // Find the checkbox with name="serial_number[]" and value="5"
    var checkbox = $(
        'input[name="serial_number[]"][value="' + serialNumber + '"]'
    );
    // Check if the checkbox is checked
    var isChecked = checkbox.is(":checked");
    // Find the closest tr element to the checkbox
    var closestTr = checkbox.closest("tr");
    closestTr.html("");
    // Append a new row to the table
    var newRow =
        "<td>" +
        serialNumber +
        '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
        serialNumber +
        '"' +
        (isChecked ? " checked" : "") +
        " /></td>" +
        "<td>" +
        documentTypeText +
        '<input type="hidden" name="document_type[]" value="' +
        documentTypeId +
        '" /></td>' +
        '<td><a href="' +
        billFileURL +
        '" target="_blank">' +
        billFileName +
        "</a>" +
        '<span class="d-none">' +
        '<input type="file" name="bill_file[]" id="' +
        uniqueId +
        '">' +
        "</span>" +
        '<input type="hidden" name="bill_file_name[]" value="' +
        billFileName +
        '" /></td>' +
        "<td>" +
        billFileSize +
        '<input type="hidden" name="bill_file_size[]" value="' +
        billFileSize +
        '" /></td>' +
        "<td>" +
        remark +
        '<input type="hidden" name="remark[]" value="' +
        remark +
        '" /></td>' +
        "<td>" +
        documentDate +
        '<input type="hidden" name="document_date[]" value="' +
        documentDate +
        '" /></td>' +
        "<td>" +
        billAmount +
        '<input type="hidden" name="bill_amount[]" value="' +
        billAmount +
        '" /></td>' +
        "<td>" +
        headingText +
        '<input type="hidden" name="heading_id[]" value="' +
        headingId +
        '" /></td>' +
        "<td>" +
        subHeadingText +
        '<input type="hidden" name="sub_heading_id[]" value="' +
        subHeadingId +
        '" /></td>' +
        "<td>" +
        clinicalFacilityName +
        '<input type="hidden" name="clinical_facility_name[]" value="' +
        clinicalFacilityName +
        '" /></td>' +
        "<td>" +
        diagnosisTreatment +
        '<input type="hidden" name="diagnosis_treatment[]" value="' +
        diagnosisTreatment +
        '" /></td>' +
        "<td>" +
        '<button class="btn btn-primary btn-sm viewRow"><i class="fas fa-eye"></i> View</button> ' +
        '<button class="btn btn-warning btn-sm text-white editRow"><i class="fas fa-edit"></i> Edit</button> ' +
        '<button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i> Delete</button>' +
        "</td>";

    closestTr.append(newRow);
    // Get the selected file from the first input
    var fileInput1 = $("#resubmission_viewEditModal").find(
        'input[name="bill_file"]'
    )[0];
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
    var counter = $("#resubmission_DataToTable tbody tr").length;
    if (counter > counterInitialRecords) {
        $("#resubmission_DataToTable tfoot").removeClass("d-none");
    } else {
        $("#resubmission_DataToTable tfoot").addClass("d-none");
    }
    $("#resubmission_btnRecordUpdate").prop("disabled", false);
    $("#resubmission_btnRecordUpdate").html(
        $("#resubmission_btnRecordUpdate").data("original-text")
    );
    modifyRemainingHeadingAmount("resubmission");
    $("#resubmission_viewEditModal").modal("hide");
    showNotification("Record Data Updated Sucessfully.", "success");
});
$("#resubmission_DataToTable").on(
    "click",
    "#resubmission_cancelBtn",
    function (e) {
        e.preventDefault();
        $("#resubmission_DataToTable tbody").html("");
        $("#resubmission_DataToTable tfoot").addClass("d-none");
        refreshTable();
    }
);
$("#addDataToTable").on("click", "#cancelBtn", function (e) {
    e.preventDefault();
    $("#addDataToTable tbody").html("");
    $("#addDataToTable tfoot").addClass("d-none");
});
$(document).on("submit", "#resubmission_DataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off("submit", "#resubmission_DataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off(
    "click",
    "#resubmission_DataToTableFormSave #resubmission_saveAsDraftlBtn,#resubmission_DataToTableFormSave #resubmission_saveSubmitClaim",
    function () {}
);
$(document).on(
    "click",
    "#resubmission_DataToTableFormSave #resubmission_saveAsDraftlBtn,#resubmission_DataToTableFormSave #resubmission_saveSubmitClaim",
    function (e) {
        e.preventDefault();
        let checkedCount = $(
            '#resubmission_DataToTableFormSave input[type="checkbox"].serial_number:checked'
        ).length;
        if (checkedCount <= 0) {
            showNotification(
                "Please select the items that you want to submit.",
                "error"
            );
            return;
        }
        $(".resubmission_btnsendData").prop("disabled", true);
        let dataurl = $("#resubmission_DataToTableFormSave").attr("action");
        // Create FormData object from the form using jQuery
        // let postdata = new FormData($("#resubmission_DataToTableFormSave")[0]);

        let btnId = $(this).attr("id");
        let saveType;
        if (btnId == "resubmission_saveAsDraftlBtn") {
            saveType = "draft";
        } else if (btnId == "resubmission_saveSubmitClaim") {
            saveType = "claim";
        } else {
            saveType = null;
        }
        // Create a FormData object to store data
        let postdata = new FormData();
        postdata.append("save_type", saveType);
        let claim_id = $("#resubmission_ClaimId").val();
        postdata.append("claim_id", claim_id);
        postdata.append(
            "member_id",
            $("#resubmission_employee_id").text().trim()
        );

        // Iterate over each checkbox that is checked
        $("#resubmission_DataToTableFormSave")
            .find('input[type="checkbox"][name="serial_number[]"]:checked')
            .each(function () {
                // Find the closest <tr> parent element
                let $tr = $(this).closest("tr");
                // Iterate over all input elements within the <tr>
                $tr.find("input").each(function () {
                    // Check if the input type is file
                    if ($(this).attr("type") === "file") {
                        // Check if files are selected sss
                        if (this.files.length > 0) {
                            // Append the selected file to FormData
                            postdata.append(
                                $(this).attr("name"),
                                this.files[0]
                            );
                        }
                    } else {
                        // Append all other input elements' name and value to FormData
                        postdata.append($(this).attr("name"), $(this).val());
                    }
                });
            });
        swal({
            title: "Are you sure you want to proceed?",
            text: "I declare that I have/my dependent has suffered the above described injuries/illness and that to the best of my knowledge And belief the forgoing particulars are in every respect true. I also declare that there is no other insurance or other source to recover the item claimed.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var request = ajaxRequest(dataurl, postdata, "POST", true);
                request.done(function (res) {
                    $(".resubmission_btnsendData").prop("disabled", false);
                    if (res.status === true) {
                        showNotification(res.message, "success");
                        $("#resubmission_DataToTableFormSave tbody").empty();
                        refreshResubmissionTable();
                        $(
                            "#resubmission_ClaimId option[value='" +
                                claim_id +
                                "']"
                        ).remove();
                        $("#resubmission_ClaimId").val("").trigger("change");
                    } else {
                        showNotification(res.message, "error");
                    }
                });
                request.fail(function (jqXHR, textStatus, errorThrown) {
                    $(".resubmission_btnsendData").prop("disabled", false);
                });
            } else {
                $(".resubmission_btnsendData").prop("disabled", false);
            }
        });
    }
);
$(document).on("change", "input, select", function () {
    let value = $(this).val(); // Get the value of the input or select
    if (value !== "" && value !== null) {
        // For normal input elements
        if (
            $(this).attr("style") &&
            $(this).attr("style").includes("border-color: #dc3545")
        ) {
            $(this).css("border-color", ""); // Remove border color
        }

        // For Select2 elements
        let select2Element = $(this)
            .next(".select2-container")
            .find(".select2-selection");
        if (
            select2Element.attr("style") &&
            select2Element.attr("style").includes("border-color: #dc3545")
        ) {
            select2Element.removeAttr("style"); // Remove inline style from Select2 container
        }
    }
});
function clearRequiredStyleAttributes() {
    $("select,input").each(function () {
        // Check if the current element has the red border style
        if (
            $(this).attr("style") &&
            $(this).attr("style").includes("border-color: #dc3545")
        ) {
            $(this).css("border-color", ""); // Remove border color
        }

        // For Select2 elements
        let select2Element = $(this)
            .next(".select2-container")
            .find(".select2-selection");
        if (
            select2Element.attr("style") &&
            select2Element.attr("style").includes("border-color: #dc3545")
        ) {
            select2Element.removeAttr("style");
        }
    });
}
function modifyRemainingHeadingAmount(claimType = null) {
    // Create an object to hold the sums for each heading_id
    headingAmountDataClaimed = {};
    if (claimType == "resubmission") {
        // Iterate over each row in the table body
        $("#resubmission_DataToTable tbody tr")
            .has('td:first-child input[type="checkbox"]')
            .each(function () {
                // Extract heading_id and bill_amount from the current row
                let headingId = $(this)
                    .find('input[name="heading_id[]"]')
                    .val(); // Get the heading_id
                let billAmount = parseFloat(
                    $(this).find('input[name="bill_amount[]"]').val()
                );

                // Initialize the heading id in the totals object if it doesn't exist
                if (!headingAmountDataClaimed[headingId]) {
                    headingAmountDataClaimed[headingId] = 0; // Start with 0 if this is the first entry for this heading_id
                }
                // Add the bill amount to the appropriate heading id
                headingAmountDataClaimed[headingId] += billAmount;
            });

        // Append the totals to a summary section (make sure this section exists in your HTML)
        $.each(headingAmountData, function (headingId, amount) {
            let remainingElement = $("#resubmission_headingSpan").find(
                "span[data-heading_id='" + headingId + "']"
            );
            let totalAmount = parseFloat(amount || 0);
            headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                headingId
            ]
                ? headingAmountDataClaimed[headingId]
                : 0;
            let newAmount = Math.max(
                totalAmount - headingAmountDataClaimed[headingId],
                0
            );
            // remainingElement.find("span").html("Rs. " + newAmount.toFixed(2));
            updateSpanWithAmount(remainingElement, newAmount);
        });
        let totalClaimedRemaining = Object.values(
            headingAmountDataClaimed
        ).reduce((acc, value) => acc + value, 0);
        let totalValue = Object.values(headingAmountData).reduce(
            (acc, value) => acc + value,
            0
        );
        let totalRemaining = totalValue - totalClaimedRemaining;
        $("#resubmission_totalInsuredAmount").html(
            formatNepaliCurrency(totalRemaining)
        );
    } else {
        // Iterate over each row in the table body
        $("#addDataToTable tbody tr").each(function () {
            // Extract heading_id and bill_amount from the current row
            let headingId = $(this).find('input[name="heading_id[]"]').val(); // Get the heading_id
            let billAmount = parseFloat(
                $(this).find('input[name="bill_amount[]"]').val()
            );

            // Initialize the heading id in the totals object if it doesn't exist
            if (!headingAmountDataClaimed[headingId]) {
                headingAmountDataClaimed[headingId] = 0; // Start with 0 if this is the first entry for this heading_id
            }
            // Add the bill amount to the appropriate heading id
            headingAmountDataClaimed[headingId] += billAmount;
        });

        // Append the totals to a summary section (make sure this section exists in your HTML)
        $.each(headingAmountData, function (headingId, amount) {
            let remainingElement = $("#headingSpan").find(
                "span[data-heading_id='" + headingId + "']"
            );
            let totalAmount = parseFloat(amount || 0);
            headingAmountDataClaimed[headingId] = headingAmountDataClaimed[
                headingId
            ]
                ? headingAmountDataClaimed[headingId]
                : 0;
            let newAmount = Math.max(
                totalAmount - headingAmountDataClaimed[headingId],
                0
            );
            // remainingElement.find("span").html("Rs. " + newAmount.toFixed(2));
            updateSpanWithAmount(remainingElement, newAmount);
        });
        let totalClaimedRemaining = Object.values(
            headingAmountDataClaimed
        ).reduce((acc, value) => acc + value, 0);
        let totalValue = Object.values(headingAmountData).reduce(
            (acc, value) => acc + value,
            0
        );
        let totalRemaining = totalValue - totalClaimedRemaining;
        $("#totalInsuredAmount").html(formatNepaliCurrency(totalRemaining));
    }
}

$(".customSelect").click(function () {
    $(this).parent().toggleClass("open");
});
$(document).on("click", function (event) {
    // Check if the click is outside the .customSelect element
    if (!$(event.target).closest(".customSelect").length) {
        // Check if .custom-select-wrapper has the 'open' class
        if ($(".custom-select-wrapper").hasClass("open")) {
            // Remove the 'open' class
            $(".custom-select-wrapper").removeClass("open");
        }
    }
});
// Change the selected flag and close the dropdown when an option is clicked
$(".custom-option").click(function () {
    var selectedValue = $(this).data("value");
    var selectedFlag = $(this).find("img").attr("src");
    let englishNepaliDiv = $(this).closest(".englishNepaliDiv");
    let dataType = englishNepaliDiv.data("type");
    let document_date_bs = null;
    let document_date = null;
    if (dataType == "new") {
        document_date_bs = $("#document_date_bs");
        document_date = $("#document_date");
    } else {
        document_date_bs = $("#" + dataType + "_document_date_bs");
        document_date = $("#" + dataType + "_document_date");
    }
    if (selectedValue == "bs") {
        document_date_bs.attr("hidden", false);
        document_date.attr("hidden", true);
    } else {
        document_date.attr("hidden", false);
        document_date_bs.attr("hidden", true);
    }
    // Update the displayed selected flag and text
    englishNepaliDiv.find(".customSelect .flag-img").attr("src", selectedFlag);

    // Optionally, set the value of the actual hidden input for form submission

    // Close the dropdown
    $(this).closest(".custom-select-wrapper").removeClass("open");
});
$(document).on(
    "change",
    "#document_type_id,#old_document_type_id,#edit_document_type",
    function () {
        const value = $(this).val();
        let heading_id = null;
        let documentDateElementEn = null;
        let documentDateElementNp = null;
        let documentTypeElement = $(this).attr("id");
        let imitationDate = null;
        const today = new Date();
        const formattedToday = formatDate(today);
        if (documentTypeElement == "document_type_id") {
            documentDateElementEn = $("#document_date");
            documentDateElementNp = $("#document_date_bs");
            heading_id = $("#heading_id").val();
            imitationDate = headingImitationDaysData[heading_id]
                ? new Date(
                      today.getTime() -
                          parseInt(headingImitationDaysData[heading_id]) *
                              86400000
                  )
                : null;
        } else if (documentTypeElement == "old_document_type_id") {
            documentDateElementEn = $("#old_document_date");
            documentDateElementNp = $("#old_document_date_bs");
            heading_id = $("#old_heading_id").val();
            imitationDate = old_headingImitationDaysData[heading_id]
                ? new Date(
                      today.getTime() -
                          parseInt(old_headingImitationDaysData[heading_id]) *
                              86400000
                  )
                : null;
        } else if (documentTypeElement == "edit_document_type") {
            documentDateElementEn = $("#edit_document_date");
            documentDateElementNp = $("#edit_document_date_bs");
            heading_id = $("#edit_heading_id").val();
            imitationDate = headingImitationDaysData[heading_id]
                ? new Date(
                      today.getTime() -
                          parseInt(headingImitationDaysData[heading_id]) *
                              86400000
                  )
                : null;
        }

        const resetFields = () => {
            documentDateElementEn
                ?.val(null)
                .prop("disabled", true)
                .removeAttr("min data-end_date");
            documentDateElementNp
                ?.val(null)
                .prop("disabled", true)
                .trigger("change");
        };

        const initializeEnglishDateField = (minDate = null) => {
            if (!documentDateElementEn?.length) {
                console.warn(
                    "documentDateElementEn (#document_date) does not exist."
                );
                return;
            }

            const attributes = { max: formattedToday };
            if (minDate) attributes.min = formatDate(minDate);

            documentDateElementEn
                .prop("disabled", false)
                .attr(attributes)
                .val(null);
        };

        const initializeNepaliDateField = (minDate = null) => {
            if (!documentDateElementNp?.length) {
                console.warn(
                    "documentDateElementNp (#document_date_bs) does not exist."
                );
                return;
            }

            const disableBeforeDate = minDate
                ? NepaliFunctions.AD2BS(formatDate(minDate))
                : null;

            documentDateElementNp
                .prop("disabled", false)
                .val(null)
                .trigger("change")
                .nepaliDatePicker({
                    ndpYear: true,
                    ndpMonth: true,
                    ndpYearCount: 15,
                    readOnlyInput: true,
                    disableBefore: disableBeforeDate,
                    disableAfter: NepaliFunctions.AD2BS(formattedToday),
                    onChange: function (e) {
                        if (documentDateElementEn?.length) {
                            documentDateElementEn.val(e.ad);
                        }
                    },
                });
        };

        if (!heading_id) {
            resetFields();
            return;
        }

        resetFields(); // Clear values and reset fields initially

        if (value === "bill") {
            initializeEnglishDateField(imitationDate);
            initializeNepaliDateField(imitationDate);
        } else {
            initializeEnglishDateField(); // Without minDate for non-bill types
            initializeNepaliDateField(); // Nepali date picker without minDate
        }
    }
);
function updateSpanWithAmount(element, newAmount) {
    let $span = element.find("span");
    let [beforeSlash, afterSlash] = $span.text().split("/");
    if (afterSlash) {
        $span.text(
            `Rs. ${formatNepaliCurrency(
                newAmount.toFixed(2)
            )} / ${afterSlash.trim()}`
        );
    } else {
        $span.text(`Rs. ${formatNepaliCurrency(newAmount.toFixed(2))}`);
    }
}
