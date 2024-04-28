$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_all();
    Selection();

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
                get_all();
                $(`#addForm`).trigger("reset");
                $(`#addModal`).modal("hide");
            },
            error: function (res) {
                console.log(res)
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
                    "client",
                    "property_details",
                    "coordinator",
                    "agent",
                    "contract_start",
                    "contract_end",
                    "payment_term",
                    "tenent_price",
                    "client_income",
                    "company_income",
                    "payment_date",
                    "due_date",
                    "status",
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
});

var ent = $(".ent").text().toLowerCase();

function get_all() {
    $("#tbl_div").empty();

    $.ajax({
        type: "POST",
        url: `/${ent}`,
        success: function (res) {
            var records = res.records;

            var tbl = $("<table class='bg-light'>")
                .addClass("overflow-auto")
                .attr("id", "tbl_records");

            var thead = $("<thead>");
            var thr = $("<tr text-nowrap>");
            var cols = [
                "#",
                "Client Name",
                "Property Details",
                "Coordinator",
                "Contact Number",
                "Agent",
                "Contract Start",
                "Contract End",
                "Payment Term",
                "Tenant Price",
                "Owner Income",
                "Company Income",
                "Payment Date",
                "Due Date",
                "Status",
                "Update",
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
                    var vals = [
                        record.client,
                        record.property_details,
                        record.coordinator,
                        record.contact,
                        record.agent,
                        record.contract_start,
                        record.contract_end,
                        record.payment_term,
                        record.tenant_price,
                        record.client_income,
                        record.company_income,
                        record.payment_date,
                        record.due_date,
                        record.status,
                    ];

                    var tr = $("<tr class='text-nowrap'>").data(
                        "id",
                        record.con_id
                    );
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
            console.log(res)
        },
    });
}

function Selection() {
    var clients = "#addForm select[name=clients_c_id]";
    var agents = "#addForm select[name=agents_a_id]";
    var coordinators = "#addForm select[name=coordinators_co_id]";
    var projects = "#addForm select[name=projects_id]";
    var buildings = "#addForm select[name=buildings_b_id]";
    var units = "#addForm select[name=units_u_id]";
    var selectProject = `<option  selected>Choose Projects</option>`;
    // var selectBuild = `<option  value=''>Choose Building</option>`;
    // var selectUnit = `<option  selected>Choose Units</option>`;
    var selectClients = `<option  selected>Choose Clients </option>`;
    var selectAgents = `<option  selected>Choose Agents </option>`;
    var selectCoordinators = `<option  selected>Choose Coordinators </option>`;
    // clients.append(selectClients);
    $(agents).append(selectAgents);
    $(coordinators).append(selectCoordinators);
    $(projects).append(selectProject);

    $.ajax({
        type: "GET",
        url: `/${ent}/selections`,
        success: function (res) {
            console.log(res);
            for (client of res.clients) {
                var opt = $("<option>");
                opt.val(client.c_id);
                opt.text(`${client.fname} ${client.lname}`);
                $(clients).append(opt);
            }
            for (agent of res.agents) {
                var opt = $("<option>");
                opt.val(agent.a_id);
                opt.text(`${agent.agent_fname} ${agent.agent_lname}`);
                $(agents).append(opt);
            }
            for (coor of res.coordinators) {
                var opt = $("<option>");
                opt.val(coor.co_id);
                opt.text(`${coor.co_fname} ${coor.co_lname}`);
                $(coordinators).append(opt);
            }
        },
        error: function (xhr, status, error) {},
    });
    $.ajax({
        type: "GET",
        url: `/${ent}/select-projects`,
        success: function (res) {
            var opt = $("<option>");
            for (project of res.projects) {
                opt.val(project.id);
                opt.text(project.project_name);
                $(projects).append(opt);
            }
        },
        error: function (xhr, status, error) {},
    });

    $(document).on("change", projects, function (e) {
        e.preventDefault();
        $(buildings).empty()

        $.ajax({
            type: "GET",
            url: `/${ent}/select-buildings/${$(projects).val()}`,
            success: function (res) {
                // buildings.append(selectBuild);
                var opt = $("<option>");

                for (building of res.buildings) {
                    opt.val(building.b_id);
                    opt.text(building.building_name);
                    $(buildings).append(opt);
                }
                $(buildings).val('')
            },
        });
    });
    $(document).on("change", buildings, function (e) {
        e.preventDefault()
        $(units).empty()

        $.ajax({
            type: "GET",
            url: `/${ent}/units/${$(buildings).val()}`,
            success: function (res) {
                console.log(res);
                var opt = $("<option>");
                for (unit of res.units) {
                    opt.val(unit.u_id);
                    opt.text(unit.unit_no);
                    $(units).append(opt);
                }
                $(units).val('')
            },
        });
    });
}
