function Live() {
    $(".dash-loader").addClass("d-none");
    var loader = `<div  class="loading-spinner spinner-border text-primary" role="status">
  <span class="visually-hidden">Loading...</span>
</div>`;
    $(loader).insertAfter(".dash-loader");

    setInterval(() => {
        Units_Per_Projects();
        Ownership();
        $.ajax({
            type: "GET",
            url: "/dashboard/unit-owners",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#unit-owners-count").text(res.unit_owners);
                } else {
                    $("#unit-owners-count").text(res.unit_owners);
                }
            },
        });
        $.ajax({
            type: "GET",
            url: "/dashboard/projects",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#projects-count").text(res.projects);
                } else {
                    $("#projects-count").text(res.projects);
                }
            },
        });
        $.ajax({
            type: "GET",
            url: "/dashboard/units",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#units-count").text(res.units);
                } else {
                    $("#units-count").text(res.units);
                }
            },
        });
        $.ajax({
            type: "GET",
            url: "/dashboard/available-units",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#available-units-count").text(res.available);
                } else {
                    $("#available-units-count").text(res.available);
                }
            },
        });
        $.ajax({
            type: "GET",
            url: "/dashboard/unpaid-monthly-dues",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#unpaid-monthly-dues-count").text(res.dues);
                } else {
                    $("#unpaid-monthly-dues-count").text(res.dues);
                }
            },
        });
        $.ajax({
            type: "GET",
            url: "/dashboard/occupied-units",
            dataType: "json",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                if (res.status == 200) {
                    $("#occupied-units-count").text(res.occupied);
                } else {
                    $("#occupied-units-count").text(res.occupied);
                }
            },
        });
    }, 3000);
}

google.charts.load("current", {
    packages: ["corechart"],
});
google.charts.setOnLoadCallback(Units_Per_Projects);

function Units_Per_Projects() {
    $.ajax({
        type: "GET",
        url: "/dashboard/units-per-projects",
        data: "data",
        dataType: "json",
        success: function (res) {
            $(".dash-loader").removeClass("d-none");
            $(".loading-spinner").addClass("d-none");
            var projects = [];
            $.each(res.units_per_projects, function (index, pro) {
                // Push project data into projects array
                projects.push([pro.project, pro.unit_count]);
            });

            // Create DataTable
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Project");
            data.addColumn("number", "Units");
            data.addRows(projects);

            // Set Options
            const options = {
                // title: "Units per Project",
            };

            // Draw
            const chart = new google.visualization.BarChart(
                document.getElementById("units_per_projects")
            );
            chart.draw(data, options);
        },
    });
}

google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(Ownership);

function Ownership() {
    // Set Data
    $.ajax({
        type: "GET",
        url: "/dashboard/units-per-owners",
        dataType: "json",
        success: function (res) {
            console.log(res);
            var owners = [];
            $.each(res.units_per_owner, function (index, owner) {
                // Push owner data into owners array
                owners.push([owner.name, owner.unit_count]);
            });

            // Create DataTable
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Owners");
            data.addColumn("number", "Units");
            data.addRows(owners);

            // Set Options
            var options = {
                title: "",
            };

            // Draw
            var chart = new google.visualization.PieChart(
                document.getElementById("ownership")
            );
            chart.draw(data, options);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function Accounts() {
    $.ajax({
        type: "GET",
        url: "/dashboard/accounts",
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            $.each(res.accounts, function (index, data) {
                var color = "";
                if (data.status == "Online") {
                    color = "success";
                } else {
                    color = "secondary";
                }
                var account = `<div class="col-3 d-flex justify-content-center align-items-center ">\
                            <small class="text-${color}">${data.status}</small>\
                        </div>\
                        <div class="col-9">\
                            <small>${data.fname} ${data.lname}</small>\
                        </div>`;
                $("#accounts-data").append(account);
            });
        },
    });
}

async function Dashboard() {
    const res = await Live();
    const accounts = await Accounts();
}

Dashboard();
