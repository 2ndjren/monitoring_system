$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    Dash1();
    Dash2();

    get_data();
});

function get_data() {
    $(".dash-loader").addClass("d-none");
    var loader = `
                    <div class="loading-spinner spinner-border text-primary" role="status"></div>
                `;
    $(loader).insertAfter(".dash-loader");

    $.ajax({
        url: `/dashboard/get-data`,
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
    $.ajax({
        type: "GET",
        url: "/dashboard/contracts-dues",
        success: function (res) {
            var ctx = document.getElementById("dash1").getContext("2d");

            // Create the pie chart
            var myPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ["Past Dues", "Remaining Dues"],
                    datasets: [
                        {
                            label: "Contract Dues",
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

function Dash2() {
    $.ajax({
        type: "GET",
        url: "/dashboard/contracts",
        success: function (res) {
            // Get the canvas element
            var ctx = document.getElementById("dash2").getContext("2d");

            // Create the donut chart
            var myPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ["Week", "Month", "Expired"],
                    datasets: [
                        {
                            label: "Contract Expiration",
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
                },
            });
        },
    });
}
