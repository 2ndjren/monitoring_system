$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_data()
})

function get_data() {
    $.ajax({
        url: `/dashboard/get-data/`,
        method: "GET",
        success: function (res) {
            console.log(res)
        },
        error: function (res) {

        },
    })
}