// function showNotification() {
//     // Create a notification element
//     var notification = document.getElementById("notification");
//     notification.innerHTML = "This is a notification!";

//     // Show the notification
//     notification.style.top = "0";

//     // Hide the notification after 3 seconds
//     setTimeout(function () {
//         notification.style.top = "-50px"; // Move the notification off-screen
//     }, 3000);
// }

// function notifyMe() {
//     if (!("Notification" in window)) {
//         alert("This browser does not support desktop notification");
//     } else if (Notification.permission === "granted") {
//         const notification = new Notification("Hi there!");
//         // …
//     } else if (Notification.permission !== "denied") {
//         Notification.requestPermission().then((permission) => {
//             if (permission === "granted") {
//                 const notification = new Notification("Hi there!");
//             }
//         });
//     }
// }

let baseUrl = "http://127.0.0.1:8000";
function Login() {
    $("#login-account-form").submit(function (e) {
        e.preventDefault();
        $("#login-account-form button[type=submit],[type=button]").prop(
            "disabled",
            true
        );
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "/signin",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#login-account-form span").remove();
                if (res.status == 200) {
                    localStorage.setItem(
                        "user_data",
                        JSON.stringify(res.user_account)
                    );

                    $(
                        "#login-account-form button[type=submit],[type=button]"
                    ).prop("disabled", false);
                    window.location.href = baseUrl + "/dashboard";
                } else if (res.status == 400) {
                    $(
                        "#login-account-form button[type=submit],[type=button]"
                    ).prop("disabled", false);

                    var errors = res.errors;
                    $.each(res.errors, function (errorsIndex, error) {
                        var error =
                            "<small class='text-danger mx-2'>" +
                            error +
                            "</small>";
                        $(error).insertAfter(
                            $("input[name=" + errorsIndex + "]")
                        );
                    });
                }
            },
            error: function (xhr, status, error) {
                showToast("Please refresh your page", 400);
                $("button[type=submit],[type=button]").prop("disabled", false);

                console.error(xhr.responseText);
            },
        });
    });
}

function showToast(message, status) {
    if (status == 200) {
        $("#toast-header-text").text("Success");
        $("#toast-header-text").removeClass("text-danger");
        $("#toast-text-color").removeClass("text-danger");
        $("#toast-text-color").addClass("text-success");
        $("#toast-header-text").addClass("text-success");
        $("#toast-icon-failed").addClass("d-none");
        $("#toast-icon-success").removeClass("d-none");
    } else if (status == 400) {
        $("#toast-header-text").text("Failed");
        $("#toast-text-color").addClass("text-danger");
        $("#toast-text-color").removeClass("text-success");
        $("#toast-header-text").removeClass("text-success");
        $("#toast-header-text").addClass("text-danger");
        $("#toast-icon-failed").removeClass("d-none");
        $("#toast-icon-success").addClass("d-none");
    }
    $("#toast-message .toast-body").text(message);
    var success = new bootstrap.Toast($("#toast-message"));
    success.show();
}
