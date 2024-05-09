$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#imageInput").on("change", function () {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            $("#previewImage").attr("src", e.target.result).show();
            $("#removeImage").show();
        };

        reader.readAsDataURL(file);
    });

    $("#removeImage").on("click", function () {
        $("#previewImage").attr("src", "").hide();
        $("#removeImage").hide();
        $("#imageInput").val(""); // Clear the input field
    });
    $("#upimageInput").on("change", function () {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            $("#uppreviewImage").attr("src", e.target.result).show();
            $("#removeImage").show();
        };

        reader.readAsDataURL(file);
    });

    $("#removeImage").on("click", function () {
        $("#previewImage").attr("src", "").hide();
        $("#removeImage").hide();
        $("#imageInput").val(""); // Clear the input field
    });

    get_all();

    $("#addForm").submit(function (e) {
        e.preventDefault();
        $("#addForm span").remove();

        $.ajax({
            type: "POST",
            url: `/account/add`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Update Successful", res.msg);

                get_all();
                $(`#addForm`).trigger("reset");
                $(`#updModal`).modal("hide");
            },
            error: function (res) {
                console.log(res);
                var errors = res.responseJSON.errors;
                // console.log(errors)

                var inputs = $(
                    "#addForm input, #addForm select, #addForm textarea"
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

    $("#updModal").on("show.bs.modal", function (e) {
        $("#updForm span").remove();
    });

    $("#updForm").submit(function (e) {
        e.preventDefault();
        $("#updForm span").remove();
        var formdata = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: `/account/upd`,
            data: formdata,
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Update Successful", res.msg);

                get_all();
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
            url: `/account/del`,
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
        var id = $(this).data("id");
        $("input[name=user_id]").val(id);
        $(`#updModal`).modal("show");

        $.ajax({
            method: "GET",
            url: `/account/edit/${id}`,
            success: function (res) {
                var record = res.record;

                var keys = [
                    "user_fname",
                    "user_lname",
                    "email",
                    "contact",
                    "username",
                    "password",
                ];
                $(`#uppreviewImage`).attr(
                    "src",
                    `/account/profile/${record.avatar}`
                );

                for (key of keys) {
                    $(`#updForm input[name=${key}]`).val(record[key]);
                }
            },
        });
    });

    $(document).on("click", ".i_del", function () {
        var target = $(this).data("id");

        $("#delForm input[name=target]").val(target);
        $(`#delModal`).modal("show");
    });
});

var ent = $(".ent").text().toLowerCase();

function get_all() {
    $("#tbl_div").empty();

    $.ajax({
        type: "POST",
        url: `/account/data`,
        success: function (res) {
            var records = res.records;

            var tbl = $("<table>")
                .addClass("w-100 overflow-auto")
                .attr("id", "tbl_records");

            var thead = $("<thead>");
            var thr = $("<tr>");
            var cols = ["#", "First Name", "Last Name", "Status", "Action"];
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
                    var vals = [
                        record.user_fname,
                        record.user_lname,
                        record.status,
                    ];

                    var tr = $("<tr>");
                    tr.append(
                        $("<td>")
                            .addClass("border border-dark border-5 text-center")
                            .html('<i class="fa-solid fa-user"></i>')
                    );

                    for (val of vals) {
                        tr.append($("<td>").addClass(td_class).html(val));
                    }

                    tr.append(
                        $("<td>").addClass(td_class).html(`
          <i data-id="${record.user_id}" class='fa fa-pen-to-square mr-2 i_edit' title='Edit' style='cursor:pointer;'></i>
          <i data-id="${record.user_id}" class='fa-solid fa-trash i_del' title='Delete' style='cursor:pointer;'></i>
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
