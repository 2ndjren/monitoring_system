$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_data()
})

function get_data() {
    $(".dash-loader").addClass("d-none");
    var loader = `
                    <div class="loading-spinner spinner-border text-primary" role="status"></div>
                `
    $(loader).insertAfter(".dash-loader");

    setInterval(() => {
        $.ajax({
            url: `/dashboard/get-data/`,
            method: "GET",
            success: function (res) {
                $(".dash-loader").removeClass("d-none");
                $(".loading-spinner").addClass("d-none");
                console.log(res)
                var counts = res.counts
    
                $('#counts-clients').text(counts.clients)
                $('#counts-coordinators').text(counts.coordinators)
                $('#counts-agents').text(counts.agents)
                $('#counts-projects').text(counts.projects)
                $('#counts-units').text(counts.units)
            },
            error: function (res) {
    
            },
        })
    }, 3000)


}