$(document).ready(function () {
    $(document).on("click", ".toggle-btn", function () {
        var icon = $(this).find("i");
        if (icon.hasClass("fa-plus")) {
            icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            icon.removeClass("fa-minus").addClass("fa-plus");
        }
    });

    $(document).on("change", 'input[type="checkbox"]', function (e) {
        var checked = $(this).prop("checked"),
            container = $(this).closest("li");

        container.find('input[type="checkbox"]').prop({
            indeterminate: false,
            checked: checked,
        });

        function checkSiblings(el) {
            var parent = el.parent().parent().closest("li"),
                all = true;

            el.siblings().each(function () {
                return (all =
                    $(this).find('input[type="checkbox"]').prop("checked") ===
                    checked);
            });

            if (all && parent.length) {
                parent.find('input[type="checkbox"]').prop({
                    indeterminate: false,
                    checked: checked,
                });
                checkSiblings(parent);
            } else if (!all && parent.length) {
                el.parents("li")
                    .children(".checkbox-label")
                    .children('input[type="checkbox"]')
                    .prop({
                        indeterminate: true,
                        checked: false,
                    });
            }
        }

        checkSiblings(container);
    });
});
$(document).ready(function () {
    $("#group_id, #employee_id").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data("placeholder"),
    });
});
//Search Data
$(document).off("click", "#searchData", function () {});
$(document).on("click", "#searchData", function (e) {
    e.preventDefault();
    let is_all = $("#selectAll").is(":checked").toString();
    let group_id = $("#group_id").val();
    console.log(group_id=='',is_all=='false',is_all);
    if (group_id=='' && is_all=='false') {
        showNotification("Select Group First.", "error");
    } else {
        let dataurl = "claimreceived";
        let postdata = {
            group_id: $("#group_id").val(),
            employee_id: $("#employee_id").val(),
            from_date: $("#from_date").val(),
            to_date: $("#to_date").val(),
            is_all: $("#selectAll").is(":checked").toString(),
        };
        var request = ajaxRequest(dataurl, postdata, "GET", false, "html");
        request.done(function (res) {
            $("#replaceHtmlAjax").html("");
            if (res) {
                // showNotification(res.message, "success");
                // Inject the view content into the container
                $("#replaceHtmlAjax").html(res);
            } else {
                showNotification(res.message, "error");
            }
        });
    }
});

//Intimate Claim
$(document).off("submit", "#intimateClaimForm", function () {});
$(document).on("submit", "#intimateClaimForm", function (e) {
    e.preventDefault();
    let checkedCount = $('input[type="checkbox"].employee_id:checked').length;
    if (checkedCount <= 0) {
        $("#claimReceived").prop("disabled", false);
        $("#claimReceived").html($("#claimReceived").data("original-text"));
        showNotification(
            "Please select the items that you want to submit.",
            "error"
        );
        return;
    }
    // Create a FormData object to store data
    let postdata = new FormData();
    // Iterate over each checkbox that is checked
    $("#intimateClaimForm")
        .find('input[type="checkbox"][name="employee_id[]"]:checked')
        .each(function () {
            // Append all other input elements' name and value to FormData
            postdata.append($(this).attr("name"), $(this).val());
        });
    let dataurl = $("#intimateClaimForm").attr("action");
    var request = ajaxRequest(dataurl, postdata, "POST", true);
    request.done(function (res) {
        $(".btnsendData").prop("disabled", false);
        if (res.status === true) {
            $("#searchData").trigger("click");
            showNotification(res.message, "success");
        } else {
            showNotification(res.message, "error");
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        $(".btnsendData").prop("disabled", false);
    });
});
