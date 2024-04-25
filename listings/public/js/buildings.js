$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_all_data();

    $("#addModal").on("show.bs.modal", function (e) {
        $("#addForm span").remove();
    });

    $("#addForm").submit(function (e) {
        e.preventDefault();
        $("#addForm span").remove();

        $.ajax({
            url: `/${ent}/add/`,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Added Successful", res.msg);

                get_all_data();
                $(`#addForm`).trigger("reset");
                $(`#addModal`).modal("hide");
            },
            error: function (res) {
                var errors = res.responseJSON.errors;
                // console.log(errors)

                var inputs = $(
                    "#addForm input, #addForm select, #addForm textarea"
                );
                for (input of inputs) {
                    var name = $(input).attr("name");

                    if (name in errors) {
                        for (error of errors[name]) {
                            var error_msg = $(
                                `<span class='text-danger'>${error}</span>`
                            );
                            error_msg.insertAfter($(input));
                        }
                    }
                }
            },
        });
    });

    $("#updModal").on("show.bs.modal", function (e) {
        $("#updForm span").remove();
    });

    $("#updForm").submit(function (e) {
        e.preventDefault();
        $("#updForm span").remove();

        $.ajax({
            type: "POST",
            url: `/${ent}/upd/`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Update Successful", res.msg);

                get_all_data();
                $(`#updForm`).trigger("reset");
                $(`#updModal`).modal("hide");
            },
            error: function (res) {
                console.log(res);
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
            url: `/${ent}/del/`,
            data: $(this).serialize(),
            success: function (res) {
                showtoastMessage("text-success", "Delete Successful", res.msg);

                get_all_data();
                $(`#delModal`).modal("hide");
            },
            error: function (xhr, status, error) {},
        });
    });

    $(document).on("click", ".i_edit", function () {
        var id = $($(this).parents()[1]).data("id");

        $("#updForm input[name=id]").val(id);
        $(`#updModal`).modal("show");

        $.ajax({
            method: "POST",
            url: `/${ent}/edit/`,
            data: { id: id },
            success: function (res) {
                var record = res.record;

                var keys = [
                    "projects_id",
                    "building_name",
                    "city",
                    "barangay",
                    "street",
                ];

                for (key of keys) {
                    $(`#updForm input[name=${key}]`).val(record[key]);
                }
            },
        });
    });

    $(document).on("click", ".i_del", function () {
        var id = $($(this).parents()[1]).data("id");

        $("#delForm input[name=id]").val(id);
        $(`#delModal`).modal("show");
    });

    $(document).on("click", ".i_units", function () {
        var id = $($(this).parents()[1]).data("id");
        var name = $($(this).parents()[1]).data("value");
        storeId("buildings_b_id", id);
        storeId("buildings_name", name);
        window.location.href = "/units";
    });
});

var ent = $(".ent").text().toLowerCase();

const projects_name = getId("projects_name");
$("#buildings").text(projects_name + " " + ent);
$("#buildings").addClass("text-capitalize");

function get_all_data() {
    $("#tbl_div").empty();
    const project_id = getId("projects_id");
    $("input[name=projects_id]").val(project_id);
    $.ajax({
        type: "get",
        url: `/${ent}/` + project_id,
        success: function (res) {
            var records = res.records;

            var tbl = $("<table>")
                .addClass("w-100 overflow-auto")
                .attr("id", "tbl_records");

            var thead = $("<thead>");
            var thr = $("<tr>");
            var cols = [
                "#",
                "Name",
                "Street",
                "Barangay",
                "City",
                "Units",
                "Action",
            ];
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

            var td_class = "p-2 border border-dark border-5 text-center";

            var tbody = $("<tbody>");
            if (records.length > 0) {
                for (record of records) {
                    var vals = [
                        record.building_name,
                        record.street,
                        record.barangay,
                        record.city,
                    ];

                    var tr = $("<tr>").data("id", record.b_id).data('value', record.building_name);
                    tr.append(
                        $("<td>")
                            .addClass("border border-dark border-5 text-center")
                            .html('<i class="fa-solid fa-star"></i>')
                    );

                    for (val of vals) {
                        tr.append($("<td>").addClass(td_class).html(val));
                    }
                    tr.append(
                        $("<td>")
                            .addClass("border border-dark border-5 text-center")
                            .html(
                                '<i class="fa-solid fa-house-user i_units" title="Units" style="cursor:pointer;"></i>'
                            )
                    );

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
        error: function (res) {},
    });
}
