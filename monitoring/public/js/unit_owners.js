function UnitOwnersEvent() {
    $("#unit-owners-menu-btn").click(function (e) {});
    $("#create-unit-owner-btn").click(function (e) {
        $("#unit-owner").modal("show");
    });
    $("#delete-unit-owner-btn").click(function (e) {
        e.preventDefault;
        $.ajax({
            type: "GET",
            url: "/unit-owners-display",
            data: "data",
            dataType: "json",
            success: function (res) {
                console.log(res);
                var selectElement = $(".todelete-owner");
                selectElement.empty(); // Clear existing options

                // Add a default option
                selectElement.append(
                    "<option selected disabled>Select</option>"
                );

                $.each(res.unit_owners, function (index, unitOwner) {
                    console.log(unitOwner);
                    $(".todelete-owner").append(
                        "<option value='" +
                            unitOwner.id +
                            "'>" +
                            unitOwner.name +
                            "</option>"
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });

        $("#delete-unit-owner-modal").modal("show");
    });

    $("#create-unit-owner-form").submit(function (e) {
        e.preventDefault();
        $("button[type=submit],[type=button]").prop("disabled", true);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/add-unit-owner",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#unit-owner span").remove();
                console.log(res);
                if (res.status == 200) {
                    $("button[type=submit],[type=button]").prop(
                        "disabled",
                        false
                    );

                    $("#create-unit-owner-form")[0].reset();
                    showToast(res.message, res.status);
                    Asc();
                } else if (res.status == 400) {
                    showToast(res.message, res.status);
                    $("button[type=submit],[type=button]").prop(
                        "disabled",
                        false
                    );

                    var errors = res.errors;
                    $.each(res.errors, function (errorsIndex, error) {
                        var error =
                            "<span class='text-danger mx-2'>" +
                            error +
                            "</span>";
                        $(error).insertAfter(
                            $("input[name=" + errorsIndex + "]")
                        );
                    });
                    Asc();
                }
            },
            error: function (xhr, status, error) {
                $("button[type=submit],[type=button]").prop("disabled", false);

                console.error(xhr.responseText);
            },
        });
    });

    $("#clearModal").click(function (e) {
        e.preventDefault();
        $("#unit-owner span").remove();
        $("#create-unit-owner-form")[0].reset();
    });

    $(".sort-unit-owners").click(function (e) {
        e.preventDefault();
        $("#unit-owner-list-data").empty();
        var id = $(this).attr("id");
        var sorting = $(this).data("value");
        if (sorting == "asc") {
            Asc();
        } else if (sorting == "desc") {
            Desc();
        } else {
            Asc();
        }
    });

    $(document).on("click", ".unit-owner-btn", function (e) {
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "/view-unit-owner/" + id,
            data: "data",
            dataType: "json",
            success: function (res) {
                console.log(res);
                if (res.status == 200) {
                    localStorage.setItem(
                        "owner_data",
                        JSON.stringify(res.owner_details)
                    );

                    window.location.href = "/view_owner_data";
                } else if (res.status == 400) {
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    });
}

function Asc() {
    $("#unit-owner-list-data").empty();
    $.ajax({
        type: "GET",
        url: "/unit-owners-list",
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            if (res.status == 200) {
                $.each(res.asc, function (ascIndex, ascData) {
                    var list = ` <div data-id="${ascData.id}" class="col-lg-3 col-sm-12 shadow-sm mt-2  text-center pt-3 px-4 unit-owner-btn">\
                            <span class="h4 float-start">${ascData.name}</span>\
                            <span class="h4 float-end">\
                                <i class="fa-solid fa-user"></i>\
                            </span>\
                        </div>`;
                    $("#unit-owner-list-data").append(list);
                });
            } else if (res.status == 400) {
                NoResults(res.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}
function Desc() {
    $("#unit-owner-list-data").empty();
    $.ajax({
        type: "GET",
        url: "/unit-owners-list",
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            if (res.status == 200) {
                $.each(res.desc, function (ascIndex, ascData) {
                    var list = ` <div data-id="${ascData.id}" class="col-lg-3 col-sm-12 shadow-sm mt-2  text-center pt-3 px-4 unit-owner-btn">\
                            <span class="h4 float-start">${ascData.name}</span>\
                            <span class="h4 float-end">\
                                <i class="fa-solid fa-user"></i>\
                            </span>\
                        </div>`;
                    $("#unit-owner-list-data").append(list);
                });
            } else if (res.status == 400) {
                NoResults(res.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

function Search() {
    $('input[name="name"]').on("change", function (e) {
        e.preventDefault();
        var search = $(this).val();
        if (search != "") {
            $.ajax({
                type: "GET",
                url: "/search/" + search,
                data: "data",
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    $("#unit-owner-list-data").empty();
                    if (res.status == 200) {
                        $.each(
                            res.searched,
                            function (searchIndex, searchData) {
                                var list = ` <div data-id="${searchData.id}" class="col-lg-3 col-sm-12 shadow-sm mt-2  text-center pt-3 px-4 unit-owner-btn">\
                            <span class="h4 float-start">${searchData.name}</span>\
                            <span class="h4 float-end">\
                                <i class="fa-solid fa-user"></i>\
                            </span>\
                        </div>`;
                                $("#unit-owner-list-data").append(list);
                            }
                        );
                    } else if (res.status == 400) {
                        NoResults(res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        } else {
            Asc();
        }
    });
}

function NoResults(message) {
    var results = `        <div id="unit-owner-list-data" class="row">\
            <div class="col-12 text-center pt-5">\
                <span><i class="fa-regular fa-face-sad-tear"></i> <span>${message}</span></span>\
            </div>\

        </div>`;

    $("#unit-owner-list-data").append(results);
}
