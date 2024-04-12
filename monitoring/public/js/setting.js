function Setting_Events() {
    $("#logout-btn").click(function (e) {
        e.preventDefault();
        var label = "Confirm logout";
        var message = "Are you sure?";
        showConfirmAction(label, message);
    });
    $(".confirmActionBtn").click(function (e) {
        e.preventDefault();
        var check = $(this).data("value");
        if (check == "yes") {
            window.location.href = "/logout";
        } else {
            hideConfirmAction();
        }
    });

    $(document).on("click", "#edit-account-btn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "/edit-user-account/" + id,
            data: "data",
            dataType: "json",
            success: function (res) {
                if (res.status == 200) {
                    $("input[name=fname]").val(res.user.fname);
                    $("input[name=lname]").val(res.user.lname);
                    $("input[name=email]").val(res.user.email);
                    $("input[name=user_id]").val(res.user.user_id);
                } else if (res.status == 400) {
                    showToast(res.message, res.status);
                }
            },
        });
        $("#edit-account-modal").modal("show");
    });
}

function AccountInformation() {
    var data = localStorage.getItem("user_data");
    var account = JSON.parse(data);
    $("#account-content-data").empty();
    $.ajax({
        type: "GET",
        url: "/edit-user-account/" + account.user_id,
        data: "data",
        dataType: "json",
        success: function (res) {
            if (res.status == 200) {
                $("input[name=fname]").val(res.user.fname);
                $("input[name=lname]").val(res.user.lname);
                $("input[name=email]").val(res.user.email);
                $("input[name=user_id]").val(res.user.user_id);
                var account_content = `  <div class="rounded-2 lh-1 shadow-sm p-1">\
                        <div class="dropdown  float-end">\
                            <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">\
                                <i class="fa-solid fa-ellipsis-vertical"></i>\
                            </a>\

                            <ul class="dropdown-menu">\
                                <li><a id="edit-account-btn" class="dropdown-item" data-id="${res.user.user_id}" href="#">Edit Account</a></li>\
                                <li><a id="change-pass-btn" class="dropdown-item" href="#">Change Password</a></li>\
                            </ul>\
                        </div>\
                        <h3 class="text-primary ps-4">Account</h3>\


                        <div class=" px-4 pt-3">\
                            <p class="p-2  rounded-1" style="background: white">Name: <strong>${res.user.fname} ${res.user.lname}</strong></p>\
                            <p class="p-2  rounded-1" style="background: white">Email: <strong>${res.user.email}</strong></p>\
                        </div>\

                    </div>`;

                $("#account-content-data").append(account_content);
            } else if (res.status == 400) {
                showToast(res.message, res.status);
            }
        },
    });
}

function UpdateProfile() {
    $("#update-user-profile-form").submit(function (e) {
        e.preventDefault();
        $("#update-user-profile-form button[type=submit],[type=button]").prop(
            "disabled",
            true
        );
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/update-user-account",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#update-user-profile-form span").remove();
                if (res.status == 200) {
                    AccountInformation();
                    showToast(res.message, res.status);
                    $("#update-user-profile-form")[0].reset();
                    localStorage.setItem(
                        "user_data",
                        JSON.stringify(res.user_account)
                    );
                    var data = localStorage.getItem("user_data");
                    var account = JSON.parse(data);
                    $("input[name=fname]").val(account.fname);
                    $("input[name=lname]").val(account.lname);
                    $("input[name=email]").val(account.email);
                    $(
                        "#update-user-profile-form button[type=submit],[type=button]"
                    ).prop("disabled", false);
                } else if (res.status == 400) {
                    showToast(res.message, res.status);

                    $(
                        "#update-user-profile-form button[type=submit],[type=button]"
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
