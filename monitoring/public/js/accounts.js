function AccountsEvents() {
    $("#create-user-btn").click(function (e) {
        e.preventDefault();
        $("#create-user-modal").modal("show");
    });

    $(document).on("click", ".user-account", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "/user-account/" + id,
            data: "data",
            dataType: "json",
            success: function (res) {
                console.log(res);
                if (res.status == 200) {
                    var color = "";
                    var eye = "";
                    if (res.user.status == "Online") {
                        color = "success";
                    } else if (res.user.status == "Offline") {
                        color = "secondary";
                    }
                    $("#user-status").removeClass("text-" + color + "");
                    $("#user-status").addClass("text-" + color + "");
                    $("#user-name").text(res.user.fname + " " + res.user.lname);
                    $("#user-email").text(res.user.email);
                    $("#user-status").text(res.user.status);
                    $("#show-user-modal").modal("show");
                } else if (res.status == 400) {
                    showToast(res.message, res.status);
                }
            },
        });
    });
}

function Create_User() {
    $("#create-user-form").submit(function (e) {
        e.preventDefault();
        $("#create-user-modal button[type=submit],[type=button]").prop(
            "disabled",
            true
        );
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/add-user",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#create-user-modal span").remove();
                console.log(res);
                if (res.status == 200) {
                    showToast(res.message, res.status);
                    Accounts();
                    $(
                        "#create-user-modal button[type=submit],[type=button]"
                    ).prop("disabled", false);

                    $("#create-user-form")[0].reset();
                } else if (res.status == 400) {
                    $(
                        "#create-user-modal button[type=submit],[type=button]"
                    ).prop("disabled", false);

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
                }
            },
            error: function (xhr, status, error) {
                $("button[type=submit],[type=button]").prop("disabled", false);

                console.error(xhr.responseText);
            },
        });
    });
}

function Accounts() {
    $.ajax({
        type: "GET",
        url: "/get-users",
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            if (res.status == 200) {
                $("#accounts-container").empty();

                $.each(res.accounts, function (accountIndex, user) {
                    var color = "";
                    if (user.status == "Online") {
                        color = "success";
                    } else if (user.status == "Offline") {
                        color = "secondary";
                    }
                    var account = `     <div  data-id="${user.user_id}" class="user-account col-sm-12 col-lg-3 p-3 mt-2 border-${color} border-end border-5 shadow-sm">\
                    <div class="row">\
                        <div class="col-3 d-flex justify-content-center align-items-center">\
                            <h1 class=""><i class="fa-solid fa-user"></i></h1>\
                        </div>\
                        <div class="col-9">\
                            <small class="text-${color}"> <span class="text-${color} me-2"><i
                                        class="fa-regular fa-circle-dot"></i></span>${user.status}</small>\
                            <div class="">\
                                <h4 class="">${user.fname} ${user.lname}</h4>\
                            </div>\
                        </div>\
                    </div>\
                </div>`;
                    $("#accounts-container").append(account);
                });
            } else if (res.status == 400) {
            }
        },
    });
}
