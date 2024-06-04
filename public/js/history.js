$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    Import();
    get_locations();

    $("#addModal").on("show.bs.modal", function (e) {
        $("#addForm span").remove();
    });
    $("#exportFile").click(function (e) {
        e.preventDefault();
        window.location.href = "/file/export";
    });
    function get_locations() {
        $("#locations").empty();

        $.ajax({
            type: "POST",
            url: `/${ent}/get-locations`,
            success: function (res) {
                // console.log(res)
                var records = res.records;

                if (records.length > 0) {
                    for (var record of records) {
                        var btn = `
                                    <button class="btn btn-primary text-center mr-1 location">${record.location} (${record.contracts})</button>
                                `;
                        $("#locations").append(btn);
                    }

                    $(".location").first().click();
                } else {
                    $("#tbl_div").append(
                        `<p class="text-center">No results found</p>`
                    );
                }
            },
        });
    }
});

function format_date(date) {
    if (date != null) {
        date = new Date(date);
        date = date.toLocaleString("default", {
            month: "long",
            day: "numeric",
            year: "numeric",
        });
    }

    return date;
}
