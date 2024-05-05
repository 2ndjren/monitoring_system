$(document).ready(function () {
    Notify();
    Notification_Events();
});

function Notify() {
    $("#notification-container").empty();
    $.ajax({
        type: "GET",
        url: "/notification/data",
        success: function (res) {
            console.log(res);
            if (res.length > 0) {
                for (data of res) {
                    var color = "";
                    if (data.status == "Delivered") {
                        color = "primary";
                    } else if (data.status == "Viewed") {
                        color = "secondary";
                    }
                    var notif = `  <div class="col-12  ps-3 pe-2 lh-1 my-1  " style="cursor: pointer;">
                <div class="row bg-${color} py-2 rounded-start">
                    <div data-value="${data.event}" class="col-8 notif-data-btn" data-id="${data.notif_id}">
                        <span><span><i class="fa-solid fa-bell me-2"></i></span class="fw-semibold  ">${data.heading}</span> <br>
                        <div class="w-100 text-truncate ">
                            <small class="">${data.content}.</small>
                        </div>
                    </div>
                    <div class="col-4 pe-4">
                        <div class="d-flex justify-content-end align-content-center">
                            <span class="btn btn-transparent text-light recycle-btn" data-id="${data.notif_id}"><i class="fa-solid fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>`;
                    $("#notification-container").append(notif);
                }
            } else {
                $("#notification-container").append(
                    `<p class="text-center">No results found</p>`
                );
            }
        },
    });
}
function Notification_Events() {
    $(document).on("click", ".notif-data-btn", function () {
        var id = $(this).data("id");
        var val = $(this).data("value");
        $.ajax({
            type: "GET",
            url: `/notification/viewed/${id}`,
            success: function (res) {
                console.log(res);
                if (val == "Contract Expired") {
                    window.location.href = "/history";
                } else if (val == "Paid") {
                }
            },
        });
    });
    $(document).on("click", ".recycle-btn", function () {
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `/notification/recycled/${id}`,
            success: function (res) {
                Notify();
            },
        });
    });
}
