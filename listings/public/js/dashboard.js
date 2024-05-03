$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    Dash1();
    Dash2();
    Dash3();

    get_data();
});

function get_data() {
    $(".dash-loader").addClass("d-none");
    var loader = `
                    <div class="loading-spinner spinner-border text-primary" role="status"></div>
                `;
    $(loader).insertAfter(".dash-loader");

    $.ajax({
        url: `/dashboard/get-data/`,
        method: "GET",
        success: function (res) {
            $(".dash-loader").removeClass("d-none");
            $(".loading-spinner").addClass("d-none");

            var counts = res.counts;
            for (var key in counts) {
                $(`#counts-${key}`).text(counts[key]);
            }
        },
        error: function (res) {
            console.log(res);
        },
    });
}

function Dash1() {
    // Get the canvas element
    var ctx = document.getElementById("dash1").getContext("2d");

    // Create the chart
    $.ajax({
        type: "GET",
        url: `/dashboard/client-units`,
        success: function (res) {
            // console.log(res);
            var title = [];
            var count = [];
            for (c of res) {
                title.push(c.client);
                count.push(c.unit_count);
            }
            var myChart = new Chart(ctx, {
                type: "bar", // Type of chart (e.g., bar, line, pie, etc.)
                data: {
                    labels: title, // Labels for the data
                    datasets: [
                        {
                            label: "",
                            data: count, // Data values
                            backgroundColor: [
                                "rgb(255, 99, 132, )",
                                "rgb(54, 162, 235, )",
                                "rgb(255, 206, 86, )",
                                "rgb(75, 192, 192, )",
                                "rgb(153, 102, 255, )",
                                "rgb(255, 159, 64, )",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true, // Start y-axis at 0
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                            labels: {
                                color: "rgb(255, 99, 132)",
                            },
                        },
                    },
                },
            });
        },
    });
}

function Dash2() {
    $.ajax({
        type: "GET",
        url: "/dashboard/contracts-dues",
        success: function (res) {
            var ctx = document.getElementById("dash2").getContext("2d");

            // Create the pie chart
            var myPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ["Passed Due", "Remaining Dues"],
                    datasets: [
                        {
                            label: "My Pie Chart",
                            data: [res.passdue.length, res.remaining.length],
                            backgroundColor: [
                                "rgb(255, 99, 132)",
                                "rgb(54, 162, 235)",
                                "rgb(255, 206, 86)",
                                "rgb(75, 192, 192)",
                                "rgb(153, 102, 255)",
                                "rgb(255, 159, 64)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            });
        },
    });
    // Get the canvas element
}

function Dash3() {
    $.ajax({
        type: "GET",
        url: "/dashboard/contracts",
        success: function (res) {
            // Get the canvas element
            var ctx = document.getElementById("dash3").getContext("2d");

            // Create the donut chart
            var myDonutChart = new Chart(ctx, {
                type: "doughnut", // Use 'doughnut' type for a donut chart
                data: {
                    labels: ["Week", "Lessthan a month", "Expired"],
                    datasets: [
                        {
                            label: "My Donut Chart",
                            data: [
                                res.expiring.length,
                                res.near.length,
                                res.expired.length,
                            ],
                            backgroundColor: [
                                "rgb(255, 99, 132)",
                                "rgb(54, 162, 235)",
                                "rgb(255, 206, 86)",
                                "rgb(75, 192, 192)",
                                "rgb(153, 102, 255)",
                                "rgb(255, 159, 64)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: "70%", // Adjust the cutout percentage for the donut hole
                },
            });
        },
    });
}
