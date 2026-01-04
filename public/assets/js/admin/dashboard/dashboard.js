var chart1;
$(document).ready(function () {
    "use strict";
    // if (currentUser=='HR'||currentUser=='MB') {
    getClaimStatusData();

    // }
    preminumSection();

    // Define chart options
    var options = {
        series: [],
        chart: {
            height: 105,
            type: "area",
            sparkline: {
                enabled: true,
            },
            zoom: {
                enabled: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 3,
            curve: "smooth",
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                gradientToColors: ["#0866ff"],
                shadeIntensity: 1,
                type: "vertical",
                opacityFrom: 0.5,
                opacityTo: 0.0,
            },
        },
        colors: ["#02c27a"],
        tooltip: {
            theme: "dark",
            fixed: {
                enabled: false,
            },
            x: {
                show: false,
            },
            y: {
                title: {
                    formatter: function () {
                        return "";
                    },
                },
            },
            marker: {
                show: false,
            },
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
            ],
        },
    };

    // Initialize chart1
    chart1 = new ApexCharts(document.querySelector("#chart2"), options);
    chart1
        .render()
        .then(function () {
            // Trigger the change event after chart is rendered
            $("#client_type").trigger("change");
        })
        .catch(function (error) {
            console.error("Error rendering chart:", error);
        });
    $(document).on("change", "#client_type", function () {
        let type = $(this).find(":selected").val();
        // alert(type);
        if (type == "group") {
            $("#client_group").attr("hidden", false);
        } else {
            $("#client_group").attr("hidden", true);
        }
        totalClient(type);
    });
    // Client Chart
    var totalClients =
        parseInt(all_inactive_clients) + parseInt(all_active_clients);
    let all_inactive_clients_per = (all_inactive_clients / totalClients) * 100;
    let all_active_clients_per = (all_active_clients / totalClients) * 100;
    var clientChartOptions = {
        series: [all_inactive_clients_per, all_active_clients_per],
        actual_value_series: [all_inactive_clients, all_active_clients],
        labels: ["Inactive", "Active"], // Custom labels
        chart: {
            height: 175,
            type: "donut",
        },
        legend: {
            position: "bottom",
            show: !1,
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                gradientToColors: ["#ee0979", "#17ad37", "#ec6ead"],
                shadeIntensity: 1,
                type: "vertical",
                opacityFrom: 1,
                opacityTo: 1,
                //stops: [0, 100, 100, 100]
            },
        },
        colors: ["#ff6a00", "#98ec2d", "#3494e6"],
        dataLabels: {
            enabled: !1,
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "85%",
                },
            },
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: function (value, { seriesIndex }) {
                    const total = clientChartOptions.series.reduce(
                        (a, b) => a + b,
                        0
                    );
                    const actualValue =
                        clientChartOptions.actual_value_series[seriesIndex];
                    const percentage = value.toFixed(2);
                    return `${actualValue}(${percentage})%`;
                },
            },
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 270,
                    },
                    legend: {
                        position: "bottom",
                        show: !1,
                    },
                },
            },
        ],
    };

    var clientsChart = new ApexCharts(
        document.querySelector("#clientsChart"),
        clientChartOptions
    );
    clientsChart.render();
});

$(document).on("change", "#client_group", function () {
    let group = $(this).find(":selected").val();
    let type = $("#client_type").find(":selected").val();
    totalClient(type, group);
});
function totalClient(client_type, client_group = null) {
    // if (type !='group' && group_id) {
    $.ajax({
        url: "get-total-members",
        type: "GET",
        data: { client_type, client_group },
        success: function (res) {
            if (res.status === true) {
                $("#total_member").html(res.response.total);
                $(".member-increased-per").html(res.response.last_month_count);
                if (res.response.last_month_count < 0) {
                    $(".member-increased-per").removeClass("text-success");
                    $(".member-increased-per").addClass("text-danger");
                    $("#perMem").removeClass("text-success");
                    $("#perMem").addClass("text-danger");
                } else {
                    $(".member-increased-per").removeClass("text-danger");
                    $(".member-increased-per").addClass("text-success");
                    $("#perMem").removeClass("text-danger");
                    $("#perMem").addClass("text-success");
                }
                // updateMemberChart(chart1,res.response.data);
                if (chart1) {
                    updateMemberChart(chart1, res.response.data);
                    chart1.updateSeries([
                        {
                            name: "Total Members",
                            data: res.response.data,
                        },
                    ]);
                } else {
                    console.error("Chart is not initialized");
                }
            }
        },
        error: function (res) {
            showNotification(res.message, "error");
        },
    });
    // }
}

function updateMemberChart(chart, newData) {
    var newOptions = {
        series: [
            {
                name: "Total Members",
                data: newData,
            },
        ],
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
            ],
        },
    };
    chart.updateOptions(newOptions);
}

$(document).on("change", "#clientID", function () {
    preminumSection();
});
function preminumSection() {
    let client_id = $("#clientID").find(":selected").val();
    let client_name = $("#clientID").find(":selected").data("name");
    let dataurl = "get-preminum-amount";
    let postdata = { client_id: client_id };

    var request = ajaxRequest(dataurl, postdata);
    request.done(function (res) {
        if (res.status === true) {
            $("#total_member").html(res.response.total);
            let response = res.response;
            let clientTd = "";
            if ($("#clientID").length) {
                clientTd = `<td>${client_id ? client_name : "All"}</td>`;
            }

            $("#preminumSection tbody").html(
                `<tr>${clientTd}<td>Rs. ${Number(
                    parseFloat(response.preminum_amount).toFixed(2)
                ).toLocaleString("en-IN")}</td><td>Rs. ${Number(
                    parseFloat(response.approved_amount).toFixed(2)
                ).toLocaleString("en-IN")}</td></tr>`
            );
        } else {
            showNotification(res.message, "error");
        }
    });
}

function getClaimStatusData() {
    $("#claim-status-table-responsive").DataTable({
        processing: true,
        serverSide: true,
        ajax: "get-claim-status-detail",
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
            // { data: "DT_RowIndex", orderable: false, searchable: false },
            // { data: "claim_member_id" },
            { data: "claim_id" },
            { data: "claim_created_at" },
            { class: "p-0 m-0", data: "claim_status" },
        ],
        rowCallback: function (row, data) {
            if (data.status == 1) {
                $(row).addClass("bg-danger");
            }
        },
    });
}
