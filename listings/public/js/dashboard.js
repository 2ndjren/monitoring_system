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

    $.ajax({
        url: `/dashboard/get-data/`,
        method: "GET",
        success: function (res) {
            // console.log(res)
            $(".dash-loader").removeClass("d-none")
            $(".loading-spinner").addClass("d-none")

            var counts = res.counts
            for (var key in counts) { $(`#counts-${key}`).text(counts[key]) }
        },
        error: function (res) {

        },
    })
}