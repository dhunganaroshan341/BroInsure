var old_serialNumber = 1;
let old_headingAmountData = {};
let old_headingAmountDataClaimed = {};
let old_headingImitationDaysData = {};
let old_isSubmittedrefreshTable = false;
$(document).ready(function () {
    $("#old_employee_id, #old_heading_id ,#old_sub_heading_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
    $("#old_document_date_bs").nepaliDatePicker({
        ndpYear: true,
        ndpMonth: true,
        ndpYearCount: 15,
        readOnlyInput: true,
        // disableBefore: "2081-06-10",
        disableAfter: NepaliFunctions.AD2BS(formatDate(new Date())),
        onChange: function (e) {
            $("#old_document_date").val(e.ad);
        },
    });

    $(document).on("change", "#old_document_date", function () {
        $("#old_document_date_bs").val(NepaliFunctions.AD2BS($(this).val()));
    });
});
$(document).on("change", "#old_employee_id", function () {
    let employee_id = $("#old_employee_id").find(":selected").val();
    var employeeName = $("#old_employee_id option:selected").text();
    employeeName = employeeName.replace(/\s*\(.*?\)\s*/g, "");
    $("#old_employee_name").val($.trim(employeeName));
    old_populate_members(employee_id);
});
function old_populate_members(id, selected = null) {
    if (!id) {
        return;
    }
    let dataurl = "get-relatives/" + id + "?type=old";
    var request = getRequest(dataurl);
    // $('#old_member_id option').remove();
    $('#old_member_id option[value!=""]').remove();
    $('#old_policy_no option[value!=""]').remove();
    let totalInsured = 0;
    let totalClaimed = 0;
    request.done(function (res) {
        if (res.status === true) {
            $.each(res.response.relatives, function (index, option) {
                var isSelected =
                    selected !== null &&
                    option.id.toString() === selected.toString();
                $("#old_member_id").append(
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
            $.each(res.response.oldPolicies, function (index, option) {
                $("#old_policy_no").append(
                    '<option value="' +
                        option.id +
                        '">' +
                        option.policy_no +
                        "</option>"
                );
            });

            $("#old_destination_id").val(res.response.details.designation);
            $("#old_relation_id").val("");
            $("#old_branch_id").val(res.response.details.branch);
            $("#old_expiryDate").html(res.response.details.expiry_date);

            $("#old_policy_no").val(res.response.details.policy_no);
            // $("#old_document_date").attr(
            //     "data-end_date",
            //     res.response.details.end_date
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
            // $("#old_document_date, #old_edit_document_date").attr({
            //     min: formatDate(imitation_date),
            //     max: formatDate(new Date()),
            // });
            old_headingImitationDaysData = {};
            $.each(res.response.headings, function (index, heading) {
                $(".heading_select").append(
                    '<option value="' +
                        heading.heading_id +
                        '">' +
                        heading?.heading?.name +
                        "</option>"
                );
                old_headingImitationDaysData[heading.heading_id] =
                    heading.imitation_days
                        ? parseInt(heading.imitation_days)
                        : 0;
            });
            $("#old_heading_id").select2({
                theme: "bootstrap-5",
                width: "100%",
                placeholder: $(this).data("placeholder"),
            });
            old_headingAmountData = {};
            $("#old_headingSpan").empty();
            $.each(res.response.policy, function (index, option) {
                totalInsured += parseInt(option.insuranced_amount);
                totalClaimed += parseInt(option.claimed_amount);
                //     $("#old_headingSpan").append(
                //         '<span class="d-block mb-1">' +
                //             option.heading_name +
                //             ": <span>Rs." +
                //             option.insuranced_amount +
                //             " / Rs." +
                //             option.claimed_amount +
                //             "</span> </span>"
                //     );
                // });
                // $("#old_totalInsuredAmount").html(totalInsured);
                // $("#old_totalClaimedAmount").html(totalClaimed);
                let remaining =
                    option.insuranced_amount - option.claimed_amount;
                old_headingAmountData[option.heading_id] = remaining;

                $("#old_headingSpan").append(
                    '<span class="d-block mb-1" data-heading_id="' +
                        option.heading_id +
                        '">' +
                        option.heading_name +
                        ": <span>Rs." +
                        formatNepaliCurrency(remaining) +
                        " / Rs. " +
                        formatNepaliCurrency(option.insuranced_amount) +
                        "</span>  </span>"
                );
            });
            let totalAmount = Math.max(totalInsured - totalClaimed, 0);
            // Update the HTML and the attribute accordingly
            // $("#old_totalInsuredAmount").html(totalAmount);
            $("#old_totalInsuredAmount").attr("total", totalAmount);
            $("#old_totalInsuredAmount").html(
                formatNepaliCurrency(totalAmount)
            );
            $("#all_old_totalInsuredAmount").html(
                formatNepaliCurrency(totalInsured)
            );
            if (old_isSubmittedrefreshTable) {
                old_isSubmittedrefreshTable = false;
                old_refreshTable();
            }
        } else {
            showNotification(res.message, "error");
        }
    });
}

$(document).on("change", "#old_member_id", function () {
    $("#old_relation_id").val(
        $("#old_member_id").find(":selected").attr("data-rel")
    );
    let selectedMem = $(this).find(":selected").val();
    if (selectedMem) {
        old_memberChangeAction(selectedMem).then(function () {
            $("#old_policy_no").trigger("change");
        });
    } else {
        $("#old_employee_id").trigger("change");
    }
});
$(document).on("change", "#old_policy_no", function () {
    let id = $(this).val();
    $(".heading_select").empty();
    $(".heading_select").append('<option value="">Select Heading</option>');
    old_headingImitationDaysData = {};
    if (!id) {
        showNotification("Please Select the Policy No.", "error");
        return;
    }
    let dataurl = "get-headings-by-policy/" + id + "?type=old";
    let postdata = {
        employee_id: $("#old_employee_id").val(),
        member_id: $("#old_member_id").val(),
    };
    var request = ajaxRequest(dataurl, postdata, "POST");
    let totalInsured = 0;
    let totalClaimed = 0;

    request.done(function (res) {
        if (res.status === true) {
            $("#old_expiryDate").html(res.response.details.expiry_date);
            $("#old_document_date").attr(
                "data-end_date",
                res.response.details.end_date
            );
            documentEndDateOfMember = res.response.details.end_date;
            // let imitation_date = new Date();
            // imitation_date.setDate(
            //     imitation_date.getDate() -
            //         parseInt(res.response.details.imitation_days)
            // );
            // // currentDate.setDate(currentDate.getDate() - 5);
            // $("#old_document_date, #old_edit_document_date").attr({
            //     min: formatDate(imitation_date),
            //     max: formatDate(new Date()),
            // });
            $.each(res.response.headings, function (index, heading) {
                $(".heading_select").append(
                    '<option value="' +
                        heading.heading_id +
                        '">' +
                        heading?.heading?.name +
                        "</option>"
                );
                old_headingImitationDaysData[heading.heading_id] =
                    heading.imitation_days
                        ? parseInt(heading.imitation_days)
                        : 0;
            });
            $("#old_heading_id").select2({
                theme: "bootstrap-5",
                width: "100%",
                placeholder: $(this).data("placeholder"),
            });
            old_headingAmountData = {};
            $("#old_headingSpan").empty();
            $.each(res.response.policy, function (index, option) {
                totalInsured += parseInt(option.insuranced_amount);
                totalClaimed += parseInt(option.claimed_amount);
                let remaining =
                    option.insuranced_amount - option.claimed_amount;
                old_headingAmountData[option.heading_id] = remaining;

                $("#old_headingSpan").append(
                    '<span class="d-block mb-1" data-heading_id="' +
                        option.heading_id +
                        '">' +
                        option.heading_name +
                        ": <span>Rs." +
                        formatNepaliCurrency(remaining) +
                        " / Rs. " +
                        formatNepaliCurrency(option.insuranced_amount) +
                        "</span> </span>"
                );
            });
            let totalAmount = Math.max(totalInsured - totalClaimed, 0);
            // Update the HTML and the attribute accordingly
            // $("#old_totalInsuredAmount").html(totalAmount);
            $("#old_totalInsuredAmount").attr("total", totalAmount);
            $("#old_totalInsuredAmount").html(
                formatNepaliCurrency(totalAmount)
            );
            $("#all_old_totalInsuredAmount").html(
                formatNepaliCurrency(totalInsured)
            );
        } else {
            showNotification(res.message, "error");
        }
    });
});
function old_memberChangeAction(id, selected = null) {
    let dataurl = "get-ralatives-amt/" + id + "?type=old";
    var request = getRequest(dataurl);
    let totalInsured = 0;
    let totalClaimed = 0;
    request.done(function (res) {
        if (res.status === true) {
            $(".heading_select").empty();
            $(".heading_select").append(
                '<option value="">Select Heading</option>'
            );
            old_headingImitationDaysData = {};
            $.each(res.response.headings, function (index, heading) {
                $(".heading_select").append(
                    '<option value="' +
                        heading.heading_id +
                        '">' +
                        heading?.heading?.name +
                        "</option>"
                );
                old_headingImitationDaysData[heading.heading_id] =
                    heading.imitation_days
                        ? parseInt(heading.imitation_days)
                        : 0;
            });
            $("#old_heading_id").select2({
                theme: "bootstrap-5",
                width: "100%",
                placeholder: $(this).data("placeholder"),
            });
            $("#old_headingSpan").empty();
            old_headingAmountData = {};
            $.each(res.response.policy, function (index, option) {
                totalInsured += parseInt(option.insuranced_amount);
                totalClaimed += parseInt(option.claimed_amount);
                // $("#old_headingSpan").append(
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
                old_headingAmountData[option.heading_id] = remaining;
                $("#old_headingSpan").append(
                    '<span class="d-block mb-1" data-heading_id="' +
                        option.heading_id +
                        '">' +
                        option.heading_name +
                        ": <span>Rs." +
                        (option.insuranced_amount - option.claimed_amount) +
                        "</span> </span>"
                );
            });
            // $("#old_totalInsuredAmount").html(totalInsured - totalClaimed);
            // $("#old_totalClaimedAmount").html(totalClaimed);
            let remainingtotalAmount = Math.max(totalInsured - totalClaimed, 0);
            $("#old_totalInsuredAmount").html(
                formatNepaliCurrency(remainingtotalAmount)
            );
            $("#all_old_totalInsuredAmount").html(
                formatNepaliCurrency(totalInsured)
            );
            if (old_isSubmittedrefreshTable) {
                old_isSubmittedrefreshTable = false;
                old_refreshTable();
            }
        } else {
            showNotification(res.message, "error");
        }
    });
}
$(document).on("change", "#old_heading_id", function () {
    let heading_id = $(this).find(":selected").val();
    let elememtSelected = null;
    let documentDateElementEn = null;
    let documentDateElementNp = null;
    let headingElement = $(this).attr("id");
    if ($(this).is("#old_heading_id")) {
        elememtSelected = "#old_sub_heading_id";
        documentDateElementEn = $("#old_document_date");
        documentDateElementNp = $("#old_document_date_bs");
    }
    if (heading_id) {
        let imitation_date = null;
        if (old_headingImitationDaysData[heading_id]) {
            imitation_date = new Date();
            imitation_date.setDate(
                imitation_date.getDate() -
                    parseInt(old_headingImitationDaysData[heading_id])
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
        documentDateElementNp.removeAttr("data-end_date");
    }
    old_populateSubHeading(heading_id, null, elememtSelected);
});
$(document).off("submit", "#old_addDataToTableForm", function () {});
$(document).on("submit", "#old_addDataToTableForm", function (e) {
    e.preventDefault();
    // Validate form data
    var isValid = true;
    var billAmount = $("#old_bill_amount").val();
    var headingId = $("#old_heading_id").val();
    var documentTypeId = $("#old_document_type_id").val();

    let errorMsg;
    $("#old_addDataToTableForm input, #old_addDataToTableForm select").each(
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
                // Check if headingId exists in old_headingAmountData, otherwise return 0
                old_headingAmountData[headingId] = old_headingAmountData[
                    headingId
                ]
                    ? old_headingAmountData[headingId]
                    : 0;

                // Check if headingId exists in old_headingAmountDataClaimed, otherwise return 0
                old_headingAmountDataClaimed[headingId] =
                    old_headingAmountDataClaimed[headingId]
                        ? old_headingAmountDataClaimed[headingId]
                        : 0;

                let remainingAmount =
                    parseFloat(
                        old_headingAmountData[headingId] -
                            old_headingAmountDataClaimed[headingId]
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
                if (old_headingImitationDaysData[headingId]) {
                    let imitation_date = new Date();
                    imitation_date.setDate(
                        imitation_date.getDate() -
                            parseInt(old_headingImitationDaysData[headingId])
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
                    if ($("#old_employee_id").val()) {
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
                            $("#old_employee_id").attr(
                                "style",
                                "border-color: #dc3545 !important"
                            );
                            errorMsg =
                                "Please select the policy of the client.";
                            isValid = false;
                        }
                    } else {
                        $("#old_employee_id").attr(
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
        $("#old_addDataToTableAdd").prop("disabled", false);
        $("#old_addDataToTableAdd").html(
            $("#old_addDataToTableAdd").data("original-text")
        );
        errorMsg =
            errorMsg ?? "Please fill valid data in all required fields..";
        showNotification(errorMsg, "error");
        return;
    }
    // Get input values
    var headingText = $("#old_heading_id option:selected").text();
    var subheadingId = $("#old_sub_heading_id").val();
    var subheadingText = $("#old_sub_heading_id option:selected").text();

    var documentTypeText = $("#old_document_type_id option:selected").text();
    var billFileInput = $("#old_bill_file")[0].files[0];
    var billFileName = $("#old_bill_file_name").val();
    var documentDate = $("#old_document_date").val();
    var clinicalFacilityName = $("#old_clinical_facility_name").val();
    var remark = $("#old_remark").val();
    var clinicalFacilityName = $("#old_clinical_facility_name").val();
    var diagnosisTreatment = $("#old_diagnosis_treatment").val();

    // Get file name, size, and URL
    var billFile = billFileInput ? billFileInput.name : "";
    var billFileSize = billFileInput
        ? (billFileInput.size / 1024).toFixed(2) + " KB"
        : "";
    var billFileURL = billFileInput ? URL.createObjectURL(billFileInput) : "";
    billFileName = billFileName ? billFileName : billFile;

    $("#old_clinical_facility_name_section").val(clinicalFacilityName);

    var uniqueId = "old_bill_file_" + Date.now() + "_" + Date.now();
    // Append a new row to the table
    var newRow =
        '<tr data-rowno="' +
        old_serialNumber +
        '">' +
        "<td><span>" +
        old_serialNumber +
        `</span><input type="checkbox" name="serial_number[]" class="serial_number" value="` +
        old_serialNumber +
        '" /></td>' +
        `<td id="row_document_type${old_serialNumber}">` +
        `<span>${documentTypeText}</span>` +
        `<input type="hidden" name="document_type[]" value="` +
        documentTypeId +
        '" /></td>' +
        `<td id="row_bill_file_name${old_serialNumber}"><a href="` +
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
        `<td id="row_remark${old_serialNumber}">` +
        `<span>${remark}</span>` +
        `<input type="hidden" name="remark[]" value="` +
        remark +
        '" /></td>' +
        `<td id="row_document_date${old_serialNumber}">` +
        `<span>${documentDate}</span>` +
        `<input type="hidden" name="document_date[]" value="` +
        documentDate +
        '" /></td>' +
        `<td id="row_bill_amount${old_serialNumber}">` +
        `<span>${billAmount}</span>` +
        `<input type="hidden" name="bill_amount[]" value="` +
        billAmount +
        '" /></td>' +
        `<td id="row_heading_id${old_serialNumber}">` +
        `<span>${headingText}</span>` +
        `<input type="hidden" name="heading_id[]" value="` +
        headingId +
        '" /></td>' +
        `<td id="row_sub_heading_id${old_serialNumber}">` +
        `<span>${subheadingText}</span>` +
        `<input type="hidden" name="sub_heading_id[]" value="` +
        subheadingId +
        '" /></td>' +
        `<td id="row_clinical_facility_name${old_serialNumber}">` +
        `<span>${clinicalFacilityName}</span>` +
        `<input type="hidden" name="clinical_facility_name[]" value="` +
        clinicalFacilityName +
        '" /></td>' +
        `<td id="row_diagnosis_treatment${old_serialNumber}">` +
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

    $("#old_addDataToTable tbody").append(newRow);
    // Get the selected file from the first input
    var fileInput1 = $("#old_bill_file")[0];
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
    if (old_serialNumber >= 1) {
        $("#old_addDataToTable tfoot").removeClass("d-none");
        $("#old_clearBtnAppend").html(
            '<button type="button" class="mx-1 btn btn-danger labelsmaller btn-sm float-end" id="old_addDataToTableReset">Reset <i class="fa-sharp fas fa-brush "></i></button>'
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
    //Reduce Amount
    old_modifyRemainingHeadingAmount();
    // Optionally, reset the form
    this.reset();
    $("#old_addDataToTableAdd").prop("disabled", false);
    $("#old_addDataToTableAdd").html(
        $("#old_addDataToTableAdd").data("original-text")
    );
    showNotification("Data Added Sucessfully.", "success");
    $("#old_heading_id, #old_sub_heading_id").trigger("change");
});
function old_modifyRemainingHeadingAmount() {
    // Create an object to hold the sums for each heading_id
    old_headingAmountDataClaimed = {};
    // Iterate over each row in the table body
    $("#old_addDataToTable tbody tr").each(function () {
        // Extract heading_id and bill_amount from the current row
        let headingId = $(this).find('input[name="heading_id[]"]').val(); // Get the heading_id
        let billAmount = parseFloat(
            $(this).find('input[name="bill_amount[]"]').val()
        );

        // Initialize the heading id in the totals object if it doesn't exist
        if (!old_headingAmountDataClaimed[headingId]) {
            old_headingAmountDataClaimed[headingId] = 0; // Start with 0 if this is the first entry for this heading_id
        }
        // Add the bill amount to the appropriate heading id
        old_headingAmountDataClaimed[headingId] += billAmount;
    });

    // Append the totals to a summary section (make sure this section exists in your HTML)
    $.each(old_headingAmountData, function (headingId, amount) {
        let remainingElement = $("#old_headingSpan").find(
            "span[data-heading_id='" + headingId + "']"
        );
        let totalAmount = parseFloat(amount || 0);
        old_headingAmountDataClaimed[headingId] = old_headingAmountDataClaimed[
            headingId
        ]
            ? old_headingAmountDataClaimed[headingId]
            : 0;
        let newAmount = Math.max(
            totalAmount - old_headingAmountDataClaimed[headingId],
            0
        );
        // remainingElement.find("span").html("Rs. " + newAmount.toFixed(2));
        updateSpanWithAmount(remainingElement, newAmount);
    });
    let totalClaimedRemaining = Object.values(
        old_headingAmountDataClaimed
    ).reduce((acc, value) => acc + value, 0);
    let totalValue = Object.values(old_headingAmountData).reduce(
        (acc, value) => acc + value,
        0
    );
    let totalRemaining = totalValue - totalClaimedRemaining;
    $("#old_totalInsuredAmount").html(formatNepaliCurrency(totalRemaining));
}
$(document).on("change", "#old_document_type_id", function () {
    // Determine the ID of the bill amount based on the document type
    var billAmountId =
        $(this).attr("id") == "old_document_type_id" ? "#old_bill_amount" : "";
    if ($(this).val() == "prescription" || $(this).val() == "report") {
        $(billAmountId).val(0);
        $(billAmountId).closest("div").addClass("d-none");
    } else $(billAmountId).closest("div").removeClass("d-none");
});
// Handle row deletion
$("#old_addDataToTable").on("click", ".deleteRow", function () {
    $(this).closest("tr").remove();
    old_refreshTable();
});
// Handle row editing - Add your own functionality
$("#old_addDataToTable").on("click", ".editRow,.viewRow", function () {
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
        $("#old_edit_heading_id").val();
    });
    old_populateSubHeading(
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
    $("#viewEditModal form").attr("id", "old_viewEditRecordForm");
    $("#viewEditModal").modal("show");
});
//Update tr record

$(document).off("submit", "#old_viewEditRecordForm", function () {});
$(document).on("submit", "#old_viewEditRecordForm", function (e) {
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
    $("#old_viewEditRecordForm input, #old_viewEditRecordForm select").each(
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

                // Check if headingId exists in old_headingAmountData, otherwise return 0
                old_headingAmountData[headingId] = old_headingAmountData[
                    headingId
                ]
                    ? old_headingAmountData[headingId]
                    : 0;
                // Check if headingId exists in old_headingAmountDataClaimed, otherwise return 0
                old_headingAmountDataClaimed[headingId] =
                    old_headingAmountDataClaimed[headingId]
                        ? old_headingAmountDataClaimed[headingId]
                        : 0;

                let existingValue = 0;
                if (headingId == editClaimHeadingId) {
                    existingValue = editClaimAmount;
                }
                let totalCLaimedAmount =
                    old_headingAmountData[headingId] +
                    existingValue -
                    old_headingAmountDataClaimed[headingId];
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

    var uniqueId = "old_bill_file_" + Date.now() + "_" + Date.now();

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
        $("#old_addDataToTable tfoot").removeClass("d-none");
    } else {
        $("#old_addDataToTable tfoot").addClass("d-none");
    }
    old_modifyRemainingHeadingAmount();
    $("#old_btnRecordUpdate").prop("disabled", false);
    $("#old_btnRecordUpdate").html(
        $("#old_btnRecordUpdate").data("original-text")
    );
    $("#viewEditModal").modal("hide");
    showNotification("Record Data Updated Sucessfully.", "success");
});
// Handle cancel tbody
$("#old_addDataToTable").on("click", "#old_cancelBtn", function (e) {
    e.preventDefault();
    $("#old_addDataToTable tbody").html("");
    $("#old_addDataToTable tfoot").addClass("d-none");
    old_refreshTable();
});
$(document).on("submit", "#old_addDataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off("submit", "#old_addDataToTableFormSave", function (e) {
    e.preventDefault();
    return;
});
$(document).off(
    "click",
    "#old_addDataToTableFormSave #old_saveAsDraftlBtn,#old_addDataToTableFormSave #old_saveSubmitClaim",
    function () {}
);
$(document).on(
    "click",
    "#old_addDataToTableFormSave #old_saveAsDraftlBtn,#old_addDataToTableFormSave #old_saveSubmitClaim",
    function (e) {
        e.preventDefault();
        let currentEleemet = $(this);
        old_saveDraftSubmitClaim(currentEleemet);
    }
);
function old_saveDraftSubmitClaim(currentEleemet, isStore = null) {
    let checkedCount = $(
        '#old_addDataToTableFormSave input[type="checkbox"].serial_number:checked'
    ).length;
    if (checkedCount <= 0) {
        showNotification(
            "Please select the items that you want to submit.",
            "error"
        );
        return;
    }
    $(".btnsendData").prop("disabled", true);
    let dataurl = $("#old_addDataToTableFormSave").attr("action");
    // Create FormData object from the form using jQuery
    // let postdata = new FormData($("#old_addDataToTableFormSave")[0]);

    let btnId = currentEleemet.attr("id");
    let saveType;
    if (btnId == "old_saveAsDraftlBtn") {
        saveType = "draft";
    } else if (btnId == "old_saveSubmitClaim") {
        saveType = "claim";
        if (!isStore) {
            swal({
                title: "Are you sure you want to proceed?",
                text: "I declare that I have/my dependent has suffered the above described injuries/illness and that to the best of my knowledge And belief the forgoing particulars are in every respect true. I also declare that there is no other insurance or other source to recover the item claimed.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    old_saveDraftSubmitClaim($("#old_saveSubmitClaim"), true);
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
    // Create a FormData object to store data
    let postdata = new FormData();
    postdata.append("save_type", saveType);
    postdata.append("type", "old");
    postdata.append("member_id", $("#old_employee_id").val());
    postdata.append("destination_id", $("#old_destination_id").val());
    postdata.append("branch_id", $("#old_branch_id").val());
    postdata.append("employee_name", $("#old_employee_name").val());
    postdata.append("relative_id", $("#old_member_id").val());
    postdata.append("relation_id", $("#old_relation_id").val());
    postdata.append("policy_id", $("#old_policy_no").val());
    // Iterate over each checkbox that is checked
    $("#old_addDataToTableFormSave")
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
                '#old_addDataToTableFormSave input[type="checkbox"][name="serial_number[]"]:checked'
            ).each(function () {
                $(this).closest("tr").remove();
            });
            old_isSubmittedrefreshTable = true;
            $("#old_member_id").trigger("change");
            // $.when($("#old_member_id").trigger("change")).done(function () {
            //     old_refreshTable();
            // });
        } else {
            showNotification(res.message, "error");
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        $(".btnsendData").prop("disabled", false);
    });
}
function old_refreshTable() {
    // Recalculate serial numbers
    old_serialNumber = 1;
    $("#old_addDataToTable tbody tr").each(function () {
        let $td = $(this).find("td:first");
        let isChecked = $td
            .find('input[type="checkbox"].serial_number')
            .prop("checked");

        $td.html(
            old_serialNumber +
                '<input type="checkbox" name="serial_number[]" class="serial_number" value="' +
                old_serialNumber +
                '"' +
                (isChecked ? " checked" : "") +
                " />"
        );
        old_serialNumber++;
    });
    if (old_serialNumber > 1) {
        $("#old_addDataToTable tfoot").removeClass("d-none");
    } else {
        $("#old_addDataToTable tfoot").addClass("d-none");
    }

    old_modifyRemainingHeadingAmount();
}
$(document).on("click", "#old_addDataToTableReset", function () {
    let member_id = $("#old_member_id").val();
    if (member_id) {
        $("#old_member_id").trigger("change");
    } else {
        $("#old_employee_id").trigger("change");
    }
    old_resetDataToTable(true);
});
function old_resetDataToTable(notify) {
    old_serialNumber = 0;
    $("#old_addDataToTable tbody").html("");
    if (old_serialNumber >= 1) {
        $("#old_addDataToTable tfoot").removeClass("d-none");
        $("#old_clearBtnAppend").html(
            '<button type="button" class="mx-1 btn btn-danger labelsmaller btn-sm float-end" id="old_addDataToTableReset">Reset <i class="fa-sharp fas fa-brush "></i></button>'
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
function old_populateSubHeading(
    id,
    selected = null,
    subheading_element_id = "#sub_heading_id"
) {
    let selectedEmp;
    if (subheading_element_id == "#old_sub_heading_id") {
        selectedEmp = $("#old_employee_id").find(":selected").val();
    } else {
        selectedEmp = $("#old_employee_id").find(":selected").val();
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
