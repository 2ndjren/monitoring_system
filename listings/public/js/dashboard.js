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
                $(".dash-loader").removeClass("d-none")
                $(".loading-spinner").addClass("d-none")

                console.log(res)
                var counts = res.counts

                var keys = ['clients', 'coordinators', 'agents', 'projects', 'units']

                for (var key of keys) { $(`#counts-${key}`).text(counts[key]) }
            },
            error: function (res) {
    
            },
        })
    }, 1000)


}