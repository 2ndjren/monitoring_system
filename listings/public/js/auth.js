$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#loginForm").submit(function (e) {
        e.preventDefault();
        $("#loginForm span").remove();

        $.ajax({
            type: "POST",
            url: `/loggingin`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.status == 200) {
                    localStorage.setItem("msg", res.msg);
                    $(`#loginForm`).trigger("reset");
                    window.location.href = "/dashboard";
                } else if (res.status == 400) {
                    showtoastMessage("text-danger", "Access Denied!", res.msg);
                }
            },
            error: function (res) {
                console.log(res);
                var errors = res.responseJSON.errors;
                // console.log(errors)

                var inputs = $(
                    "#loginForm input, #loginForm select, #loginForm textarea"
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
    function showtoastMessage(toastColor, toastHeader, toastContent) {
        $("#toast-header").removeClass(toastColor);
        $("#toast-header").addClass(toastColor);
        $("#toast-header").text(toastHeader);
        $("#toast-content").text(toastContent);
        const toastBootstrap = new bootstrap.Toast("#toasMessage");
        toastBootstrap.show();
    }
});
