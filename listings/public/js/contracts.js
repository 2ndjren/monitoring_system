$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    Import();
    get_all();

    $("#addModal").on("show.bs.modal", function (e) {
        $("#addForm span").remove();
    });
    $("#exportFile").click(function (e) {
        e.preventDefault();
        window.location.href = "/file/export";
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
                get_all();
                $(`#addForm`).trigger("reset");
                $(`#addModal`).modal("hide");
            },
            error: function (res) {
                console.log(res)
                var errors = res.responseJSON.errors;

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
            url: `/${ent}/del/`,
            data: $(this).serialize(),
            success: function (res) {
                showtoastMessage("text-success", "Delete Successful", res.msg);

                get_all();
                $(`#delModal`).modal("hide");
            },
            error: function (xhr, status, error) {},
        });
    });

    $(document).on("click", ".i_payment", function () {
        var id = $($(this).parents()[1]).data("id");

        $.ajax({
            method: "POST",
            url: `/${ent}/payment/`,
            data: { id: id },
            success: function (res) {
                console.log(res)
                showtoastMessage("text-success", "Payment Successful", res.msg);
                get_all();
            },
            error: function (res) {

            }
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
                    'location',
                    "client",
                    "property_details",
                    "coordinator",
                    "contact",
                    "agent",
                    "contract_start",
                    "contract_end",
                    "payment_term",
                    "tenant_price",
                    "owner_income",
                    "company_income",
                    "payment_date",
                    "due_date",
                ];

                for (key of keys) {
                    $(
                        `#updForm input[name=${key}], #updForm select[name=${key}]`
                    ).val(record[key]);
                }
            },
        });
    });

    $(document).on("click", ".i_del", function () {
        var id = $($(this).parents()[1]).data("id");

        $("#delForm input[name=id]").val(id);
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
            console.log(res)
            var records = res.records;

            var tbl = $("<table class='bg-light'>")
                .addClass("overflow-auto")
                .attr("id", "tbl_records");

            var thead = $("<thead>");
            var thr = $("<tr text-nowrap>");
            var cols = [
                "#",
                "Client",
                "Property Details",
                "Coordinator",
                "Contact Number",
                "Agent",
                "Contract Start",
                "Contract End",
                "Payment Term",
                "Tenant Price",
                "Owner Income",
                "ABIC Income",
                "Payment Date",
                "Due Date",
                "Status",
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'June',
                'July',
                'Aug',
                'Sept',
                'Oct',
                'Nov',
                'Dec',
                "Action",
            ];
            for (col of cols) {
                thr.append(
                    $("<th>")
                        .addClass(
                            "bg-success border border-dark border-5 m-1 text-center p-2 text-nowrap "
                        )
                        .text(col)
                );
            }

            thead.append(thr);
            tbl.append(thead);

            var td_class = "py-1 px-3 border border-dark border-5 text-center";

            var tbody = $("<tbody>");
            if (records.length > 0) {
                for (record of records) {

                    var contract_start = format_date(record.contract_start)
                    var contract_end = format_date(record.contract_end)
                    var due_date = format_date(record.due_date)

                    var vals = [
                        record.client,
                        record.property_details,
                        record.coordinator,
                        record.contact,
                        record.agent,
                        contract_start,
                        contract_end,
                        record.payment_term,
                        record.tenant_price,
                        record.owner_income,
                        record.company_income,
                        record.payment_date,
                        due_date,
                    ];

                    var tr = $("<tr class='text-nowrap'>").data(
                        "id",
                        record.con_id
                    );
                    tr.append(
                        $("<td>")
                            .addClass("border border-dark border-5 text-center")
                            .html('<i class="fa-solid fa-file-contract"></i>')
                    );

                    for (val of vals) {
                        tr.append($("<td>").addClass(td_class).html(val));
                    }

                    if (record.status != null) {
                        if (record.status.split(" ").length == 4) {
                            tr.append(
                                $("<td>")
                                    .addClass(`${td_class} text-danger`)
                                    .html(record.status)
                            );
                        } 
                        else if (record.status.split(" ").length == 3) {
                            tr.append(
                                $("<td>")
                                    .addClass(`${td_class} text-success`)
                                    .html(record.status)
                            );
                        }
                        else {
                            tr.append(
                                $("<td>")
                                    .addClass(`${td_class} text-primary`)
                                    .html(record.status)
                            );
                        }
                    }
                    else {
                        tr.append(
                            $("<td>")
                                .addClass(`${td_class}`)
                                .html(record.status)
                        );
                    }

                    var months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december']

                    for (var month of months) {
                        tr.append(
                            $("<td>")
                                .addClass(`${td_class}`)
                                .html(record[month])
                        );
                    }

                    tr.append(
                        $("<td>").addClass(td_class).html(`
                            <i class='fa fa-thumbs-up mr-2 i_payment' title='Accept Payment' style='cursor:pointer;'></i>
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

function format_date(date) {
    if (date != null) {
        date = new Date(date);
        date = date.toLocaleString("default", {
            month: "long",
            day: "numeric",
            year: "numeric",
        });
    }
    
    return date
}

function Import() {
    $("#file-import").submit(function (e) {
        e.preventDefault();
        $("#file-import span").remove();

        $.ajax({
            url: `/file/import`,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                showtoastMessage("text-success", "Added Successful", res.msg);
                get_all();
                $(`#file-import`).trigger("reset");
            },
            error: function (res) {
                console.log(res)
                var errors = res.responseJSON.errors;

                var inputs = $(
                    "#file-import input, #file-import select, #file-import textarea"
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
}
