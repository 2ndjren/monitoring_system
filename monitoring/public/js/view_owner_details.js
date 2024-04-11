function View_Owners_Events() {
    $("#back-unit-owners").click(function (e) {
        e.preventDefault();
        localStorage.removeItem("owner_data");
        window.location.href = "/unit-owners";
    });

    $("#create-unit-btn").click(function (e) {
        e.preventDefault();
        $("#create-owner-units").modal("show");
    });

    $(".clearModal").click(function (e) {
        e.preventDefault();
        $("#create-owner-units span").remove();
        $("#create-unit-form")[0].reset();
    });
    $(document).on("click", ".property-units", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        localStorage.setItem("u_no", id);
        var dataid = $(this).attr("id");
        Display_Current_Rental();
        $("input[name=u_no]").val(id);
        $(".property-units").removeClass("active-units");
        $("#" + dataid + "").addClass("active-units");
        $("#unit-details-data").removeClass("d-none");
        $("#units-data-container").addClass("d-none");
        $("#units-menu-btn").addClass("d-none");
        $("#units-data-menu-btn").removeClass("d-none");
    });
    $("#exit-unit-details").click(function (e) {
        e.preventDefault();
        $("#unit-details-data").addClass("d-none");
        $("#units-data-container").removeClass("d-none");
        $("#units-menu-btn").removeClass("d-none");
        $("#units-data-menu-btn").addClass("d-none");
    });

    $("#create-rental-details-btn").click(function (e) {
        e.preventDefault();
        $("#create-rental-details-modal").modal("show");
    });

    $("#create-monthly-dues-btn").click(function (e) {
        e.preventDefault();
        $("#create-monthly-dues-modal").modal("show");
    });

    $(document).on("click", "#edit-rental-details-btn", function (e) {
        e.preventDefault();
        $("#edit-rental-details-modal").modal("show")

        var id = $(this).data('id')
        Edit_Rental_Details(id)
    })

    $("#edit-unit-rental-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/edit-rental-details/",
            data: $(this).serialize(),
            success: function (res) {
                showToast(res.message, res.status)
                $(`#edit-unit-rental-form`).trigger('reset')
                $(`#edit-rental-details-modal`).modal('hide')
                Display_Current_Rental()
            },
            error: function (res) {
                console.log(res)
            }
        });
    });

    $(document).on("click", "#delete-rental-details-btn", function (e) {
        e.preventDefault();
        $("#delete-rental-details-modal").modal("show")
        $("#delete-rental-details-modal").data("id", $(this).data('id'))
    })

    $("#confirm-delete-unit-rental").click(function (e) {
        e.preventDefault();
        var id = $('#delete-rental-details-modal').data('id')
        $.ajax({
            type: "GET",
            url: `/delete-rental-details/${id}`,
            success: function (res) {
                showToast(res.message, res.status)
                $(`#delete-rental-details-modal`).modal('hide')
                Display_Current_Rental()
            },
            error: function (res) {
                console.log(res)
            }
        });
    });

    $(document).on("click", "#end-transaction-rental-details-btn", function (e) {
        e.preventDefault();
        var id = $(this).data('id')
        $.ajax({
            type: "GET",
            url: `/end-transaction-rental-details/${id}`,
            success: function (res) {
                showToast(res.message, res.status)
                Display_Current_Rental()
            },
            error: function (res) {
                console.log(res)
            }
        });
    })
}

function Display_Info() {
    var owner = JSON.parse(localStorage.getItem("owner_data"));
    $("#owner-name").text(owner.name);
}

function TableData() {
    var datatable = $("#owner-properties-container");
    datatable.empty();
    var table =
        "<table id='unit-owner-data-table' class='table table-striped border border-bordered'>";
    table += " <thead>";
    table += " <tr>";
    table += "   <th>Logo</th>";
    table += " </tr>";
    table += "   </thead >";
    table += "   <tbody>";
    table += "</tbody > ";
    table += " </table >";
    datatable.append(table);

    let property = new DataTable("#unit-owner-data-table", {
        ajax: {
            url: "/admin/property/data",
            type: "GET",
            dataSrc: "properties",
        },
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return '<p class="">' + row.city + "</p>";
                },
            },
        ],
    });
}

function Create_Unit() {
    $("#create-unit-form").submit(function (e) {
        e.preventDefault();
        $("#create-owner-units button[type=submit],[type=button]").prop(
            "disabled",
            true
        );
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/add-unit",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#create-owner-units span").remove();
                if (res.status == 200) {
                    $(
                        "#create-owner-units button[type=submit],[type=button]"
                    ).prop("disabled", false);
                    $("#create-unit-form")[0].reset();
                    showToast(res.message, res.status);
                    ViewUnitsOnly();
                } else if (res.status == 400) {
                    // showToast(res.message, res.status);
                    $(
                        "#create-owner-units button[type=submit],[type=button]"
                    ).prop("disabled", false);

                    var errors = res.errors;
                    $.each(res.errors, function (errorsIndex, error) {
                        var error =
                            "<span class='text-danger mx-2'>" +
                            error +
                            "</span>";
                        $(error).insertAfter(
                            $(
                                "input[name=" +
                                    errorsIndex +
                                    "],select[name=" +
                                    errorsIndex +
                                    "]"
                            )
                        );
                    });
                }
            },
            error: function (xhr, status, error) {
                $("button[type=submit],[type=button]").prop("disabled", false);

                console.error(xhr.responseText);
            },
        });
    });
}
function Create_Unit_Rentals() {
    $("#create-unit-rental-form").submit(function (e) {
        e.preventDefault();

        $(
            "#create-rental-details-modal button[type=submit],[type=button]"
        ).prop("disabled", true);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/add-unit-rentals",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#create-rental-details-modal span").remove();
                if (res.status == 200) {
                    showToast(res.message, res.status);
                    $(
                        "#create-rental-details-modal button[type=submit],[type=button]"
                    ).prop("disabled", false);
                    $("#create-unit-rental-form")[0].reset();
                    ViewUnitsOnly();
                    Display_Current_Rental();
                } else if (res.status == 400) {
                    showToast(res.message, res.status);

                    $(
                        "#create-rental-details-modal button[type=submit],[type=button]"
                    ).prop("disabled", false);

                    var errors = res.errors;
                    $.each(res.errors, function (errorsIndex, error) {
                        $(
                            "#create-rental-details-modal button[type=submit],[type=button]"
                        ).prop("disabled", false);
                        var error =
                            "<span class='text-danger mx-2'>" +
                            error +
                            "</span>";
                        $(error).insertAfter(
                            $(
                                "input[name=" +
                                    errorsIndex +
                                    "],select[name=" +
                                    errorsIndex +
                                    "]"
                            )
                        );
                    });
                }
            },
            error: function (xhr, status, error) {
                $("button[type=submit],[type=button]").prop("disabled", false);

                console.error(xhr.responseText);
            },
        });
    });
}

function ViewUnitsOnly() {
    $("#units-data-container").empty();
    var owner = JSON.parse(localStorage.getItem("owner_data"));
    $.ajax({
        type: "GET",
        url: "/view-units-results/" + owner.id,
        data: "data",
        dataType: "json",
        success: function (res) {
            if (res.status == 200) {
                $.each(res.unit_only, function (unitIndex, unitData) {
                    var color = "";
                    if (unitData.status == "Available") {
                        color = "success";
                    } else {
                        color = "danger";
                    }
                    var unit = `   <div data-id="${unitData.unit_no}" id="${unitData.unit_id}"
                        class="property-units col-sm-12 col-lg-3  border-end border-${color} shadow-sm mt-2 p-4 lh-1  border-5">\
                        <p class="text-start h5 fw-bold text-${color}">\
                            ${unitData.project}</p>\
                        <div class="row">\
                            <div class="col-3 justify-content-center d-flex align-items-center">\
                                <span class="text-${color} h1"><i class="fa-solid fa-building"></i></span>\
                            </div>\
                            <div class="col-9">\
                                <p id="unit-no-info" class="text-start fw-bold h3">${unitData.unit_no}</p>\
                                <p class="text-end">${unitData.status} <span class="text-${color}"><i
                                            class="fa-solid fa-circle-check"></i></span></p>\
                            </div>\
                        </div>\
                    </div>`;
                    $("#units-data-container").append(unit);
                });
            } else if (res.status == 400) {
                NoResults(res.message);
            }
        },
        error: function (xhr, status, error) {
            $("button[type=submit],[type=button]").prop("disabled", false);

            console.error(xhr.responseText);
        },
    });
}

function Display_Current_Rental() {
    var id = localStorage.getItem("u_no");
    $.ajax({
        type: "GET",
        url: "/display-current-rental/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {
            if (res.status == 200) {
                let money = new Intl.NumberFormat("fil-PH", {
                    style: "currency",
                    currency: "PHP",
                });

                var rental_id = res.ongoing.rental_id

                var rent = money.format(res.ongoing.rental);
                var deposit = money.format(res.ongoing.deposit);
                var markup = money.format(res.ongoing.markup);

                var options = {year: 'numeric', month: 'long', day: 'numeric'}

                var contract_start = new Date(res.ongoing.contract_start)
                var contract_end = new Date(res.ongoing.contract_end)

                contract_start = contract_start.toLocaleDateString("en-US", options)
                contract_end = contract_end.toLocaleDateString("en-US", options)

                $("#current-transaction").empty();
                var row = ` <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Rental
                                </p>
                                <p class="-center">${rent}</p>
                            </div>
                            <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Markup
                                </p>
                                <p class="-center">${markup}</p>
                            </div>
                            <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Deposit
                                </p>
                                <p class="-center">${deposit}</p>
                            </div>
                            <div class="col-lg-3 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-calendar-days"></i></span>Contract Period
                                </p>
                                <p class="-center">${contract_start} - ${contract_end}</p>
                            </div>
                            <div class="col-lg-3 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3">
                                    <i class="fa-solid fa-gear"></i></span>Action
                                </p>
                                <p class="-center">
                                    <i class="fa-solid fa-pen-to-square mr-3" id='edit-rental-details-btn' data-id='${rental_id}'></i>
                                    <i class="fa-solid fa-trash mr-3" id='delete-rental-details-btn' data-id='${rental_id}'></i> 
                                    <i class="fa-solid fa-thumbs-up" id='end-transaction-rental-details-btn' data-id='${rental_id}'></i>
                                </p>
                            </div>
                            `;
                $("#current-transaction").append(row);
            } else if (res.status == 400) {
                $("#current-transaction").empty();
                var row = ` <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Rental
                                </p>
                                <p class="-center">---</p>
                            </div>
                            <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Markup
                                </p>
                                <p class="-center">---</p>
                            </div>
                            <div class="col-lg-2 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-money-bill"></i></span>Deposit
                                </p>
                                <p class="-center">---</p>
                            </div>
                            <div class="col-lg-3 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3"><i
                                            class="fa-solid fa-calendar-days"></i></span>Contract Period
                                </p>
                                <p class="-center">---</p>
                            </div>
                            <div class="col-lg-3 col-sm-12 shadow-sm mt-2 bg-white border-end border-success border-2">
                                <p class="fw-semibold "> <span class="me-3">
                                    <i class="fa-solid fa-gear"></i></span>Action
                                </p>
                                <p class="-center">
                                    ---
                                </p>
                            </div>
                            `;
                $("#current-transaction").append(row);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

function Edit_Rental_Details(id) {
    $.ajax({
        type: "GET",
        url: "/edit-rental-details/" + id,
        success: function (res) {
            var modal = '#edit-rental-details-modal'
            $(`${modal} input[name=rental_id]`).val(res.ongoing.rental_id)
            $(`${modal} input[name=rental]`).val(res.ongoing.rental)
            $(`${modal} input[name=markup]`).val(res.ongoing.markup)
            $(`${modal} input[name=deposit]`).val(res.ongoing.deposit)
            $(`${modal} input[name=contract_start]`).val(res.ongoing.contract_start)
            $(`${modal} input[name=contract_end]`).val(res.ongoing.contract_end)
        },
        error: function (res) {

        },
    })
}

function Generate_Report_Rental_Details(rental_details) {
    var tbl = $('<table>').addClass('d-none')
    tbl.attr('id', 'rental-details-tbl')

    var thr = $('<tr>')
    thr.append($('<th>').text('Rental'))
    thr.append($('<th>').text('Markup'))
    thr.append($('<th>').text('Deposit'))
    thr.append($('<th>').text('Contract Period'))
    thr.append($('<th>').text('Status'))
    tbl.append(thr)

    $.each(rental_details, function(row, field) {
        var tr = $('<tr>')
        tr.append($('<td>').text(field.rental))
        tr.append($('<td>').text(field.markup))
        tr.append($('<td>').text(field.deposit))
        tr.append($('<td>').text(`${field.contract_start}-${field.contract_end}`))
        tr.append($('<td>').text(field.status))
        tbl.append(tr)
    })

    $('#transactions').append(tbl)

    var wb = XLSX.utils.table_to_book(document.getElementById("rental-details-tbl"));
    XLSX.writeFile(wb, "report.xlsx");
}

function NoResults(message) {
    var results = `<div class="col-12 text-center pt-5">\
                <span><i class="fa-regular fa-face-sad-tear"></i> <span>${message}</span></span>\
            </div>`;

    $("#units-data-container").append(results);
}
