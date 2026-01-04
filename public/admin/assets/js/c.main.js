function ajaxRequest(
    dataurl,
    postdata,
    type = "POST",
    isformupload = false,
    dataType = "json"
) {
    $("#loader").show();
    let config = {
        type: type,
        url: dataurl,
        dataType: dataType,
        data: postdata,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    };
    if (isformupload === true) {
        config.processData = false;
        config.contentType = false;
        config.cache = false;
    }
    return $.ajax(config);
}

function getRequest(dataurl) {
    return $.ajax({
        type: "GET",
        url: dataurl,
        dataType: "json",
    });
}

function showNotification(message, type) {
    // if (type == 'error') {
    //     type = 'danger';
    // }
    // var duration = '6000';
    // var ripple = true;
    // var dismissible = true;
    // var positionX = 'right';
    // var positionY = 'top';
    // window.notyf.open({
    //     type,
    //     message,
    //     duration,
    //     ripple,
    //     dismissible,
    //     position: {
    //         x: positionX,
    //         y: positionY
    //     }
    // });
    if (type == "error") {
        Lobibox.notify("error", {
            pauseDelayOnHover: true,
            size: "mini",
            rounded: true,
            delayIndicator: false,
            icon: "fa fa-times",
            continueDelayOnInactiveTab: false,
            position: "top right",
            msg: message,
        });
    } else {
        Lobibox.notify("success", {
            pauseDelayOnHover: true,
            size: "mini",
            rounded: true,
            icon: "fa fa-check-circle",
            delayIndicator: false,
            continueDelayOnInactiveTab: false,
            position: "top right",
            msg: message,
        });
    }
}
$(".toggle-password").click(function () {
    $(this).toggleClass("active");
    var input = $(this).closest(".password-container").find(".passwordInput");
    if (input.attr("type") === "password") {
        input.attr("type", "text");
        $(this)
            .closest(".password-container")
            .find(".toggle-password i")
            .removeClass("fa-eye")
            .addClass("fa-eye-slash");
    } else {
        input.attr("type", "password");
        $(this)
            .closest(".password-container")
            .find(".toggle-password i")
            .removeClass("fa-eye-slash")
            .addClass("fa-eye");
    }
});
$(document).ajaxError(function (event, jqXHR, ajaxSettings, thrownError) {
    failGlobalData(jqXHR, ajaxSettings.textStatus, thrownError);
});
function failGlobalData(jqXHR, textStatus, errorThrown) {
    if (jqXHR.status === 401) {
        var jsonResponse = jqXHR.responseJSON;
        var errorMessage =
            jsonResponse && jsonResponse.error
                ? jsonResponse.error
                : "Unauthenticated User";

        showNotification("Authentication Error: " + errorMessage, "error");
        // Delay the redirection by 0.5 seconds (500 milliseconds)
        setTimeout(function () {
            // Redirect to login page
            window.location.href = "/login";
        }, 500); // 500 milliseconds (0.5 seconds)
    } else {
        // Handle the error here
        // console.error("AJAX request failed:", textStatus, errorThrown);
        if (textStatus !== "abort" && errorThrown !== "abort") {
            showNotification("Something went wrong!.", "error");
        }
    }
}
$(document).on("submit", "form", function (event) {
    var form = $(this);
    var submitButton = form.find(
        'button[type=submit]:not([style*="display: none"]), input[type=submit]:not([style*="display: none"])'
    );
    var continuousText;
    // Store original button text in a data attribute on the button itself
    submitButton.each(function () {
        $(this).data("original-text", $(this).html());
        continuousText = toContinuousTense($(this).text()); // Basic replacement to handle common cases like "Submit" -> "Submitting..."
    });

    // Disable the button and change its text
    submitButton.prop("disabled", true);
    if (!continuousText) {
        continuousText =
            'Submitting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
    }
    submitButton.html(continuousText); // Optional: Change button text to indicate submission

    // Global AJAX complete handler (both success and error)
    $(document).ajaxComplete(function (event, jqXHR, ajaxSettings) {
        // Restore original button text and enable the button
        if (submitButton) {
            submitButton.each(function () {
                $(this).prop("disabled", false);
                $(this).html($(this).data("original-text"));
            });
        }
    });
});
function toContinuousTense(text) {
    var cleanedText = text.replace(/\s+/g, " ").trim();
    var words = cleanedText.split(" ");
    if (words.length > 1) {
        if (words[0].toLowerCase() === "report") {
            words[0] = "Reporting";
        } else {
            words[0] = words[0].replace(/e?$/, "ing");
        }
        return (
            words.join(" ") +
            ' <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>'
        );
    } else {
        return (
            text.replace(/e?$/, "ing") +
            ' <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>'
        );
    }
}
$(document).ready(function () {
    if ($.fn.dataTable) {
        if (typeof $.fn.dataTable !== "undefined") {
            $.fn.dataTable.ext.errMode = function (
                settings,
                techNote,
                message
            ) {
                console.error("DataTables error:", message);
            };
        }
        // Set global DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> Loading...',
            },
        });
    }
    // Prevent dropdown from closing when clicking inside alertsDropdown
    $("#alertsDropdown .dropdown-menu").on("click", function (event) {
        event.stopPropagation(); // Stop event propagation
    });

    // Handle click event on document to close dropdown when clicking outside
    $(document).on("click", function (event) {
        // Close the dropdown when clicking outside, unless the click is inside alertsDropdown or on markAsSeen/markAllAsSeen
        if (
            !$(event.target).closest("#alertsDropdown").length &&
            !$(event.target).hasClass("markAsSeen") &&
            !$(event.target).hasClass("markAllAsSeen")
        ) {
            $("#alertsDropdown").removeClass("show");
        }
    });

    // Prevent the default behavior of the click event for elements with the markAsSeen class
    $(document).on("click", ".markAsSeen", function (event) {
        event.preventDefault();
    });

    // Prevent the default behavior of the click event for elements with the markAllAsSeen class
    $(document).on("click", ".markAllAsSeen", function (event) {
        event.preventDefault();
    });
});
$(document).on(
    "click",
    ".markAsSeen,.markAllAsSeen,.notificationAnkor",
    function (e) {
        e.preventDefault();
        e.stopPropagation();
        let id = $(this).data("id");
        let curr = $(this);
        let dataurl = "/admin/mark-as-seen";
        var postdata = {
            id: id,
        };
        curr.prop("disabled", true);
        var request = ajaxRequest(dataurl, postdata);
        request.done(function (res) {
            curr.prop("disabled", false);
            if (res.status === true) {
                showNotification(res.message, "success");
                if (
                    (curr.hasClass("notificationAnkor") && res.response) ||
                    (curr.hasClass("notificationAnkor") && res.response == 0)
                ) {
                    curr.find(".markAsSeen").remove();
                    curr.removeClass("notificationAnkor bg-light");
                    $("#spannotificationCounter").html(res.response);
                    if (res.response < 1) {
                        $("#notificationCounter").remove();
                    } else {
                        $("#notificationCounter").html(res.response);
                    }
                    window.location.href = curr.attr("href");
                } else if (id == "all" && res.response < 1) {
                    $("#spannotificationCounter").html(res.response);
                    $(".list-group-item").removeClass("bg-light");
                    $(".markAsSeen").remove();
                    $("#notificationCounter").remove();
                } else {
                    curr.closest(".list-group-item").removeClass("bg-light");
                    let val = $("#notificationCounter").data("output");
                    if (res.response) {
                        $("#spannotificationCounter").html(res.response);
                        val = val - 1;
                        if (res.response < 1) {
                            $("#notificationCounter").remove();
                        } else {
                            $("#notificationCounter").data(
                                "output",
                                res.response
                            );
                            $("#notificationCounter").html(res.response);
                        }
                    }
                    curr.remove();
                }
            } else {
                showNotification(res.message, "error");
            }
        });
        request.fail(function (jqXHR, textStatus, errorThrown) {
            curr.prop("disabled", false);
            showNotification("Something went wrong!", "error");
        });
    }
);
// remove id attributes
function removeURLParameter(url, parameter) {
    return url
        .replace(
            new RegExp("([?&])" + parameter + "=[^&#]*(#|&|$)", "i"),
            function (match, separator) {
                // Check if the parameter is at the beginning or in the middle of the URL
                return separator === "?" ? "?" : "";
            }
        )
        .replace(/[?&]$/, "");
    return url
        .replace(new RegExp("([?&])" + parameter + "=[^&#]*(#|&|$)", "i"), "$1")
        .replace(/&$/, "");
}

function checkURL() {
    if (window.location.search.includes("?claim_id=")) {
        let newURL = removeURLParameter(window.location.href, "claim_id");
        history.replaceState(null, null, newURL);
    }
    if (window.location.search.includes("?member_id=")) {
        let newURL = removeURLParameter(window.location.href, "member_id");
        history.replaceState(null, null, newURL);
    }
}

$(".modal").on("hidden.bs.modal", function () {
    checkURL();
});
