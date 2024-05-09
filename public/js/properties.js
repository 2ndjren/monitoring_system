$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_all();

    $("#updModal").on("show.bs.modal", function (e) {
        $("#updForm span").remove();
    });

    $("#updForm").submit(function (e) {
        e.preventDefault();
        $("#updForm span").remove();

        $.ajax({
            type: "POST",
            url: `/${ent}/upd`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Update Successful", res.msg);

                get_all();
                $(`#updForm`).trigger("reset");
                $(`#updModal`).modal("hide");
            },
            error: function (res) {
                var errors = res.responseJSON.errors;
                // console.log(errors)

                var inputs = $(
                    "#updForm input, #updForm select, #updForm textarea"
                );
                $.each(inputs, function (index, input) {
                    var name = $(input).attr("name");

                    if (name in errors) {
                        for (error of errors[name]) {
                            var error_msg = $(
                                `<span class='text-danger'>${error}</span>`
                            );
                            error_msg.insertAfter($(input));
                        }
                    }
                });
            },
        });
    });

    $("#delForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: `/${ent}/del`,
            data: $(this).serialize(),
            success: function (res) {
                showtoastMessage("text-success", "Delete Successful", res.msg);

                get_all();
                $(`#delModal`).modal("hide");
            },
            error: function (xhr, status, error) {},
        });
    });

    $(document).on("click", ".i_edit", function () {
        var target = $($(this).parent().prev()).text();

        $("#updForm input[name=target]").val(target);
        $(`#updModal`).modal("show");

        $.ajax({
            method: "POST",
            url: `/${ent}/edit`,
            data: { target: target },
            success: function (res) {
                var record = res.record;

                var keys = ["property"];

                for (key of keys) {
                    $(`#updForm input[name=${key}]`).val(record[key]);
                }
            },
        });
    });

    $(document).on("click", ".i_del", function () {
        var target = $($(this).parent().prev()).text();

        $("#delForm input[name=target]").val(target);
        $(`#delModal`).modal("show");
    });
});

var ent = $(".ent").text().toLowerCase();

function get_all() {
    $("#tbl_div").empty();

    $.ajax({
        type: "POST",
        url: `/${ent}`,
        success: function (res) {
            var records = res.records;

            var tbl = $("<table>")
                .addClass("w-100 overflow-auto")
                .attr("id", "tbl_records");

            var thead = $("<thead>");
            var thr = $("<tr>");
            var cols = ["#", "Name", "Action"];
            for (col of cols) {
                thr.append(
                    $("<th>")
                        .addClass(
                            "bg-success border border-dark border-5 m-1 text-center p-2"
                        )
                        .text(col)
                );
            }

            thead.append(thr);
            tbl.append(thead);

            var td_class = "py-1 border border-dark border-5 text-center";

            var tbody = $("<tbody>");
            if (records.length > 0) {
                for (record of records) {
                    var vals = [record.property];

                    var tr = $("<tr>");
                    tr.append(
                        $("<td>")
                            .addClass("border border-dark border-5 text-center")
                            .html('<i class="fa-solid fa-building"></i>')
                    );

                    for (val of vals) {
                        tr.append($("<td>").addClass(td_class).html(val));
                    }

                    tr.append(
                        $("<td>").addClass(td_class).html(`
          <i class='fa fa-pen-to-square mr-2 i_edit' title='Edit' style='cursor:pointer;'></i>
          <i class='fa-solid fa-trash i_del' title='Delete' style='cursor:pointer;'></i>
        `)
                    );
                    tbody.append(tr);
                }
            } else {
                var tr = $("<tr>");
                var td = $("<td>")
                    .addClass(td_class)
                    .attr({ colspan: cols.length })
                    .text("No results found.");

                tr.append(td);
                tbody.append(tr);
            }
            tbl.append(tbody);
            $("#tbl_div").append(tbl);
        },
        error: function (res) {
            console.log(res);
        },
    });
}
