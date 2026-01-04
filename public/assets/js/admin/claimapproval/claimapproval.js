let select_subheading_id = null;
let relative_id = null;
$(document).ready(function () {
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

    // Set the values of the input fields
    $("#from_date").val(formattedWeekBeforeDate);
    $("#to_date").val(formattedCurrentDate);

    getData();
});
function getData() {
    if ($.fn.DataTable.isDataTable("#datatables-reponsive")) {
        // If the DataTable instance exists, destroy it
        $("#datatables-reponsive").DataTable().destroy();
    }
    $("#datatables-reponsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "claimapproval",
            type: "GET",
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
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "claim_id" },
            { data: "member_name" },
            { data: "client_name" },
            { data: "file_no" },
            { data: "claim_amount" },
            { data: "bill_amount" },
            { data: "status" },
            { data: "action" },
        ],
    });
}
$(document).on("click", ".previewData", function () {
    $("#FormModal").modal("show");

    if ($.fn.DataTable.isDataTable("#scrunity_table")) {
        // If the DataTable instance exists, destroy it
        $("#scrunity_table").DataTable().destroy();
    }
    $("#scrunity_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `claimapproval/${$(this).data("claim_note_id")}/scrunity-list`,
            type: "GET",
            dataSrc: function (json) {
                $("#modal_claim_no .value").text(json.details.claim_no);
                $("#modal_claim_intimation_date .value").text(
                    json.details.claim_intimation_date
                );
                $("#modal_document_no .value").text(json.details.document_no);
                $("#modal_period_of_insured .value").text(
                    json.details.period_of_insured
                );
                $("#modal_name_of_insured .value").text(
                    json.details.name_of_insured
                );
                $("#modal_premium_balance .value").text(
                    json.details.premium_balance
                );
                return json.data;
            },
        },
        dom: "Blfrtip",
        buttons: [
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i>',
                titleAttr: "CSV",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                titleAttr: "Print",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
                title: "",
                responsive: true,
                customize: function (win) {
                    // Optional: Customize the body style
                    $(win.document.body).css("font-size", "9pt"); // Set the base font size for the print view

                    // Optionally, you can adjust the font size for tables specifically
                    $(win.document.body).find("table").css("font-size", "9pt"); // Adjust the table font size
                },
                messageTop: function () {
                    const now = new Date();
                    const formattedDate = now.toLocaleString();
                    let claimDetailsHTML = `
                    <div style="display: flex; align-items: center;">
                        <img src="/admin/assets/images/midas.jpg" class="logo-img" alt="" style="width: 15%; margin-right: 20px;">
                        <div>
                            <h5 style="margin: 0;">IGI Prudential Insurance Ltd.</h5>
                            <p style="margin: 0;">Narayanchaur, Naxal, Kathmandu-1, Nepal</p>
                            <p style="margin: 0;">4511510, 4511520, 4525508, 4525509, 4511736</p>
                        </div>
                    </div>`;

                    claimDetailsHTML += `
                    <p style="border-top: 1px solid #000;border-bottom: 1px solid #000;margin-bottom:5px;"><i><strong>Medical Claim Details</strong> <span style="float:right;">Date: ${formattedDate}&nbsp;</span></i></p>

                    <div class="claim-note-details" id="claimNoteDetailsTop">
                        <div class="claim-detail">
                            <strong>Claim No.</strong> <span id="modal_claim_no">: <span class="value">${$(
                                "#modal_claim_no .value"
                            ).text()}</span></span>
                        </div>
                        <div class="claim-detail">
                            <strong>Claim Intimation Date</strong> <span id="modal_claim_intimation_date">: <span class="value">${$(
                                "#modal_claim_intimation_date .value"
                            ).text()}</span></span>
                        </div>
                        <div class="claim-detail">
                            <strong>Document No.</strong> <span id="modal_document_no">: <span class="value">${$(
                                "#modal_document_no .value"
                            ).text()}</span></span>
                        </div>
                        <div class="claim-detail">
                            <strong>Period Of Insured</strong> <span id="modal_period_of_insured">: <span class="value">${$(
                                "#modal_period_of_insured .value"
                            ).text()}</span></span>
                        </div>
                        <div class="claim-detail">
                            <strong>Name Of Insured</strong> <span id="modal_name_of_insured">: <span class="value">${$(
                                "#modal_name_of_insured .value"
                            ).text()}</span></span>
                        </div>
                        <div class="claim-detail">
                            <strong>Premium Balance</strong> <span id="modal_premium_balance">: <span class="value">${$(
                                "#modal_premium_balance .value"
                            ).text()}</span></span>
                        </div>
                    </div>`;

                    // Return the generated HTML
                    return claimDetailsHTML;
                },
                messageBottom: function () {
                    let api = $("#scrunity_table").DataTable().ajax.json();
                    const totalAccessAmount = api.totalAccessAmount;
                    const selectedPolicies = api.selectedPolicies;
                    let totalPPN = 0;
                    let totalAmount = 0;
                    const policiesList = Object.entries(selectedPolicies)
                        .map(([key, policy], index) => {
                            policy = parseFloat(policy) || 0;
                            totalPPN += policy;
                            let amount = (policy * totalAccessAmount) / 100;
                            totalAmount += amount;

                            return `<tr>
                                <td style="border: 1px solid #000; padding: 8px;">${
                                    index + 1
                                }</td>
                                <td style="border: 1px solid #000; padding: 8px;">${
                                    key || ""
                                }</td>
                                <td style="border: 1px solid #000; padding: 8px;">${policy.toFixed(
                                    2
                                )}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${
                                    amount.toLocaleString("en-IN", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    }) || "0.00"
                                }</td>
                            </tr>
                        `;
                        })
                        .join("");
                    return `
                        <div class="table-footer particularsTable" style="margin-top: 10px;">
                            <table style="width: 50%;margin-bottom:5px; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #000; padding: 8px;">S.N.</th>
                                        <th style="border: 1px solid #000; padding: 8px;">Particulars</th>
                                        <th style="border: 1px solid #000; padding: 8px;">PPN</th>
                                        <th style="border: 1px solid #000; padding: 8px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>${policiesList}</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="border: 1px solid #000; padding: 8px; text-align: center;">Total</th>
                                        <th style="border: 1px solid #000; padding: 8px;">${totalPPN.toFixed(
                                            2
                                        )}</th>
                                        <th style="border: 1px solid #000; padding: 8px;">${
                                            totalAmount.toLocaleString(
                                                "en-IN",
                                                {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2,
                                                }
                                            ) || "0.00"
                                        }</th>
                                    </tr>
                                    </tfoot>
                            </table>
                            <p style="font-style: italic;">As the submitted documents are found in order, the claim file is hereby recommended for settlement of amount
                            <span style="text-transform: capitalize;">${numberToWords(
                                totalAmount
                            ).toLowerCase()}.</span></p>
                        </div>
                        <div class="signatures">
                            <div class="signature-box">
                                <p class="signature-line"></p>
                                <p class="signature-text">Prepared By</p>
                            </div>
                            <div class="signature-box">
                                <p class="signature-line"></p>
                                <p class="signature-text">Checked & Recommended By</p>
                            </div>
                            <div class="signature-box">
                                <p class="signature-line"></p>
                                <p class="signature-text">Approved By</p>
                            </div>
                        </div>
                        `;
                },
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i>',
            //     titleAttr: "PDF",
            //     title: "",
            //     orientation: "landscape",
            //     exportOptions: {
            //         columns: [0, 1, 2, 3, 4, 5, 6, 7],
            //     },
            //     // responsive: true,
            //     header: true,
            //     footer: true,
            //     pageSize: "A4",
            //     customize: function (doc) {
            //         if (doc) {
            //             // Use 'doc' instead of 'win'
            //             $(doc).css("font-size", "9pt");
            //             $(doc).find("table").css("font-size", "9pt");

            //             // Set the HTML content
            //             $(doc.body).prepend(`
            //                 ${this.messageTop()}
            //             `);

            //             // Optionally, append bottom content if needed
            //             $(doc.body).append(this.messageBottom());
            //         } else {
            //             console.error("The doc object is undefined.");
            //         }
            //     },
            //     messageTop: function () {
            //         const now = new Date();
            //         const formattedDate = now.toLocaleString();

            //         let claimDetailsHTML = `
            //         <div style="display: flex; align-items: center;">
            //             <img src="/admin/assets/images/midas.jpg" class="logo-img" alt="" style="width: 15%; margin-right: 20px;">
            //             <div>
            //                 <h5 style="margin: 0;">IGI Prudential Insurance Ltd.</h5>
            //                 <p style="margin: 0;">Narayanchaur, Naxal, Kathmandu-1, Nepal</p>
            //                 <p style="margin: 0;">4511510, 4511520, 4525508, 4525509, 4511736</p>
            //             </div>
            //         </div>
            //         <p style="border-top: 1px solid #000;border-bottom: 1px solid #000;margin-bottom:5px;">
            //             <i><strong>Medical Claim Details</strong> <span style="float:right;">Date: ${formattedDate}&nbsp;</span></i>
            //         </p>
            //         <div class="claim-note-details" id="claimNoteDetailsTop">
            //             <div class="claim-detail">
            //                 <strong>Claim No.</strong> <span id="modal_claim_no">: <span class="value">${$(
            //                     "#modal_claim_no .value"
            //                 ).text()}</span></span>
            //             </div>
            //             <div class="claim-detail">
            //                 <strong>Claim Intimation Date</strong> <span id="modal_claim_intimation_date">: <span class="value">${$(
            //                     "#modal_claim_intimation_date .value"
            //                 ).text()}</span></span>
            //             </div>
            //             <div class="claim-detail">
            //                 <strong>Document No.</strong> <span id="modal_document_no">: <span class="value">${$(
            //                     "#modal_document_no .value"
            //                 ).text()}</span></span>
            //             </div>
            //             <div class="claim-detail">
            //                 <strong>Period Of Insured</strong> <span id="modal_period_of_insured">: <span class="value">${$(
            //                     "#modal_period_of_insured .value"
            //                 ).text()}</span></span>
            //             </div>
            //             <div class="claim-detail">
            //                 <strong>Name Of Insured</strong> <span id="modal_name_of_insured">: <span class="value">${$(
            //                     "#modal_name_of_insured .value"
            //                 ).text()}</span></span>
            //             </div>
            //             <div class="claim-detail">
            //                 <strong>Premium Balance</strong> <span id="modal_premium_balance">: <span class="value">${$(
            //                     "#modal_premium_balance .value"
            //                 ).text()}</span></span>
            //             </div>
            //         </div>`;

            //         return claimDetailsHTML;
            //     },
            //     messageBottom: function () {
            //         let api = $("#scrunity_table").DataTable().ajax.json();
            //         const totalAccessAmount = api.totalAccessAmount;
            //         const selectedPolicies = api.selectedPolicies;
            //         let totalPPN = 0;
            //         let totalAmount = 0;
            //         const policiesList = Object.entries(selectedPolicies)
            //             .map(([key, policy], index) => {
            //                 policy = parseFloat(policy) || 0;
            //                 totalPPN += policy;
            //                 let amount = (policy * totalAccessAmount) / 100;
            //                 totalAmount += amount;

            //                 return `<tr>
            //                     <td style="border: 1px solid #000; padding: 8px;">${
            //                         index + 1
            //                     }</td>
            //                     <td style="border: 1px solid #000; padding: 8px;">${
            //                         key || ""
            //                     }</td>
            //                     <td style="border: 1px solid #000; padding: 8px;">${policy.toFixed(
            //                         2
            //                     )}</td>
            //                     <td style="border: 1px solid #000; padding: 8px;">${
            //                         amount.toLocaleString("en-IN", {
            //                             minimumFractionDigits: 2,
            //                             maximumFractionDigits: 2,
            //                         }) || "0.00"
            //                     }</td>
            //                 </tr>`;
            //             })
            //             .join("");

            //         return `
            //             <div class="table-footer particularsTable" style="margin-top: 10px;">
            //                 <table style="width: 50%;margin-bottom:5px; border-collapse: collapse;">
            //                     <thead>
            //                         <tr>
            //                             <th style="border: 1px solid #000; padding: 8px;">S.N.</th>
            //                             <th style="border: 1px solid #000; padding: 8px;">Particulars</th>
            //                             <th style="border: 1px solid #000; padding: 8px;">PPN</th>
            //                             <th style="border: 1px solid #000; padding: 8px;">Amount</th>
            //                         </tr>
            //                     </thead>
            //                     <tbody>${policiesList}</tbody>
            //                     <tfoot>
            //                         <tr>
            //                             <th colspan="2" style="border: 1px solid #000; padding: 8px; text-align: center;">Total</th>
            //                             <th style="border: 1px solid #000; padding: 8px;">${totalPPN.toFixed(
            //                                 2
            //                             )}</th>
            //                             <th style="border: 1px solid #000; padding: 8px;">${
            //                                 totalAmount.toLocaleString(
            //                                     "en-IN",
            //                                     {
            //                                         minimumFractionDigits: 2,
            //                                         maximumFractionDigits: 2,
            //                                     }
            //                                 ) || "0.00"
            //                             }</th>
            //                         </tr>
            //                     </tfoot>
            //                 </table>
            //                 <p style="font-style: italic;">As the submitted documents are found in order, the claim file is hereby recommended for settlement of amount <span style="text-transform: capitalize;">${numberToWords(
            //                     totalAmount
            //                 ).toLowerCase()}.</span></p>
            //             </div>
            //             <div class="signatures">
            //                 <div class="signature-box">
            //                     <p class="signature-line"></p>
            //                     <p class="signature-text">Prepared By</p>
            //                 </div>
            //                 <div class="signature-box">
            //                     <p class="signature-line"></p>
            //                     <p class="signature-text">Checked & Recommended By</p>
            //                 </div>
            //                 <div class="signature-box">
            //                     <p class="signature-line"></p>
            //                     <p class="signature-text">Approved By</p>
            //                 </div>
            //             </div>`;
            //     },
            // },
        ],

        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "member_name" },
            { data: "dependent_name" },
            { data: "claim_amount" },
            { data: "bill_amount" },
            { data: "excess" },
            { data: "total_amount" },
            { data: "remarks" },
        ],
    });
});

// $(document).off("click", ".approveData", function () {});
// $(document).on("click", ".approveData", function (e) {
//     e.preventDefault();
//     swal({
//         title: "Are you sure?",
//         text: "Once approved, you will not be able to revert this data!",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     }).then((willDelete) => {
//         if (willDelete) {
//             let currbtn = $(this);
//             let dataurl = currbtn.attr("data-url");
//             let token = $("input[name='_token']").val();
//             var request = ajaxRequest(dataurl, { _token: token }, "PATCH");
//             request.done(function (res) {
//                 if (res.status === true) {
//                     //   currbtn.closest("tr").remove();
//                     showNotification(res.message, "success");
//                     $("#datatables-reponsive").dataTable().fnClearTable();
//                     $("#datatables-reponsive").dataTable().fnDestroy();
//                     getData();
//                 } else {
//                     showNotification(res.message, "error");
//                 }
//             });
//         } else {
//             swal("Your Data Is Safe!");
//         }
//     });
// });

//number to words
function number2textEnglish(num) {
    if (num === 0) return "zero";

    const belowTwenty = [
        "one",
        "two",
        "three",
        "four",
        "five",
        "six",
        "seven",
        "eight",
        "nine",
        "ten",
        "eleven",
        "twelve",
        "thirteen",
        "fourteen",
        "fifteen",
        "sixteen",
        "seventeen",
        "eighteen",
        "nineteen",
    ];
    const tens = [
        "twenty",
        "thirty",
        "forty",
        "fifty",
        "sixty",
        "seventy",
        "eighty",
        "ninety",
    ];
    const thousands = ["", "thousand", "million", "billion"];

    function helper(n) {
        if (n === 0) return "";
        else if (n < 20) return belowTwenty[n - 1] + " ";
        else if (n < 100)
            return tens[Math.floor(n / 10) - 2] + " " + helper(n % 10);
        else
            return (
                belowTwenty[Math.floor(n / 100) - 1] +
                " hundred " +
                helper(n % 100)
            );
    }

    let word = "";
    let thousandIndex = 0;

    while (num > 0) {
        if (num % 1000 !== 0) {
            word = helper(num % 1000) + thousands[thousandIndex] + " " + word;
        }
        num = Math.floor(num / 1000);
        thousandIndex++;
    }

    return word.trim();
}
function numberToWords(value) {
    var fraction = Math.round(frac(value) * 100);
    var f_text = "";

    if (fraction > 0) {
        f_text = "AND " + convert_number(fraction) + " PAISE";
    }

    return convert_number(value) + " RUPEE " + f_text + " ONLY";
}

function frac(f) {
    return f % 1;
}

function convert_number(number) {
    if (number < 0 || number > 999999999) {
        return "NUMBER OUT OF RANGE!";
    }
    var Gn = Math.floor(number / 10000000); /* Crore */
    number -= Gn * 10000000;
    var kn = Math.floor(number / 100000); /* lakhs */
    number -= kn * 100000;
    var Hn = Math.floor(number / 1000); /* thousand */
    number -= Hn * 1000;
    var Dn = Math.floor(number / 100); /* Tens (deca) */
    number = number % 100; /* Ones */
    var tn = Math.floor(number / 10);
    var one = Math.floor(number % 10);
    var res = "";

    if (Gn > 0) {
        res += convert_number(Gn) + " CRORE";
    }
    if (kn > 0) {
        res += (res == "" ? "" : " ") + convert_number(kn) + " LAKH";
    }
    if (Hn > 0) {
        res += (res == "" ? "" : " ") + convert_number(Hn) + " THOUSAND";
    }

    if (Dn) {
        res += (res == "" ? "" : " ") + convert_number(Dn) + " HUNDRED";
    }

    var ones = Array(
        "",
        "ONE",
        "TWO",
        "THREE",
        "FOUR",
        "FIVE",
        "SIX",
        "SEVEN",
        "EIGHT",
        "NINE",
        "TEN",
        "ELEVEN",
        "TWELVE",
        "THIRTEEN",
        "FOURTEEN",
        "FIFTEEN",
        "SIXTEEN",
        "SEVENTEEN",
        "EIGHTEEN",
        "NINETEEN"
    );
    var tens = Array(
        "",
        "",
        "TWENTY",
        "THIRTY",
        "FOURTY",
        "FIFTY",
        "SIXTY",
        "SEVENTY",
        "EIGHTY",
        "NINETY"
    );

    if (tn > 0 || one > 0) {
        if (!(res == "")) {
            res += " AND ";
        }
        if (tn < 2) {
            res += ones[tn * 10 + one];
        } else {
            res += tens[tn];
            if (one > 0) {
                res += "-" + ones[one];
            }
        }
    }

    if (res == "") {
        res = "zero";
    }
    return res;
}
// Define getBase64ImageFromURL function
function getBase64ImageFromURL(url) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            const reader = new FileReader();
            reader.onloadend = function () {
                resolve(reader.result);
            };
            reader.readAsDataURL(xhr.response);
        };
        xhr.onerror = function () {
            reject(new Error("Failed to load image from URL"));
        };
        xhr.open("GET", url);
        xhr.responseType = "blob";
        xhr.send();
    });
}

// Preload the Base64 Image

function preloadBase64Image(url) {
    return new Promise((resolve, reject) => {
        getBase64ImageFromURL(url)
            .then((base64) => {
                resolve(base64);
            })
            .catch((error) => {
                console.error("Error fetching image:", error);
                reject(error);
            });
    });
}
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
        url: "get-member-claims?hideRows=1",
        type: "get",
        data: {
            member_id,
            relative_id,
            from_date,
            to_date,
            claim_id,
            type: "approval",
        },
        success: function (res) {
            if (res.status === true) {
                $("#scrutinyModal").modal("show");
                $(".toBeAdeedDynamically").empty();
                $(".toBeAdeedDynamically").html(res.response.html);
                $(".add-amount-container, .btnsendData").addClass("d-none");
                getScrutinyDetails(member_id, claim_id, relative_id);
            }
        },
        error: function (res) {
            showNotification(res.message, "error");
        },
    });
}
function getScrutinyDetails(member_id, claim_id, relative_id = null) {
    $.ajax({
        url: "/admin/claimverification/scrutiny",
        type: "get",
        data: { member_id, relative_id, claim_id },
        success: function (res) {
            if (res.status === true) {
                $(res.response.html).insertBefore("#total_row");
                serialNumber = parseInt(res.response.serial_no);
            }
        },
        error: function (res) {
            showNotification(res.message, "error");
        },
    });
}
$(document).on("click", ".scrutinyEditRow, .scrutinyViewRow", function (e) {
    $("#scrutinyEditModalButtons").addClass("d-none");
    // $("#scrutinyEditRowForm").prop("inert", true);
    $("#scrutinyEditRowForm")
        .find("input, select, textarea, button")
        .prop("disabled", true);
    let row_no = $(this).data("row_no");
    if (this.classList.contains("scrutinyEditRow")) {
        $("#btnRecordUpdate").show();
        $("#scrutinyEditRowForm").data("is_disabled", false);
    } else {
        $("#btnRecordUpdate").hide();
        $("#scrutinyEditRowForm").data("is_disabled", true);
    }

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
    $("#scrutiny_edit_deduction").val(
        $(`#scrutiny_deduction${row_no} input`).val()
    );
    $("#scrutiny_edit_remarks").val(
        $(`#scrutiny_remarks${row_no} input`).val()
    );
    $("#scrutiny_file_section").html("");
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
    }
    $("#scrutinyModal").addClass("modal-backdrop");
    $("#scrutinyModal").css("opacity", "1");
    $("#scrutinyRowEditModal").modal("show");
});
$("#scrutinyRowEditModal").on("hidden.bs.modal", function () {
    $("#scrutinyModal").removeClass("modal-backdrop");
    $("#scrutinyModal").css("opacity", "");
});
$(document).on("click", ".requestBtn", function () {
    var request_data = {
        type: $(this).data("type"),
    };

    // Push all data attributes from $(this)
    $.each($(this).data("request_data"), function (key, value) {
        request_data[key] = value;
    });
    if (request_data.length == 0) {
        showNotification(
            "Please select the items that you want to request.",
            "error"
        );
        return;
    }
    if (request_data.type == "reject_request") {
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
                request_data.remarks = reason;
                var request = ajaxRequest(
                    "/admin/claimverification/individual",
                    request_data,
                    "POST",
                    false
                );
                request.done(function (res) {
                    if (res.status === true) {
                        $("#scrutinyModal").modal("hide");
                        getData();
                        showNotification(res.message, "success");
                    } else {
                        showNotification(res.message, "error");
                    }
                });
                request.fail(function (jqXHR, textStatus, errorThrown) {
                    $("#registerBtn").prop("disabled", false);
                });
            } else {
                swal("Your Data Is Safe!");
            }
        });
    } else {
        swal({
            title: "Are you sure?",
            text: "Once approved, you will not be able to revert this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                let currbtn = $(this);
                let dataurl = currbtn.attr("data-url");
                let token = $("input[name='_token']").val();
                var request = ajaxRequest(dataurl, { _token: token }, "PATCH");
                request.done(function (res) {
                    if (res.status === true) {
                        //   currbtn.closest("tr").remove();
                        showNotification(res.message, "success");
                        $("#datatables-reponsive").dataTable().fnClearTable();
                        $("#datatables-reponsive").dataTable().fnDestroy();
                        getData();
                        $("#scrutinyModal").modal("hide");
                    } else {
                        showNotification(res.message, "error");
                    }
                });
            } else {
                swal("Your Data Is Safe!");
            }
        });
    }
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
