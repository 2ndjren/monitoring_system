$(document).ready(function () {
    var msg = localStorage.getItem("msg");
    if (msg) {
        showtoastMessage("text-success", "Access Granted", msg);
        localStorage.removeItem("msg");
    }
    NotifIcon();

    $.ajax({
        type: "GET",
        url: "/notification/badge",
        success: function (res) {
            if (res.length > 0) {
                $("#badge-number").removeClass("d-none");
                $("#badge-number").text(res.length);
            } else {
                $("#badge-number").addClass("d-none");
            }
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

function storeId(id_name, id) {
    localStorage.setItem(id_name, id);
}
function getId(id_name) {
    if (localStorage.hasOwnProperty(id_name)) {
        var key = localStorage.getItem(id_name);
        return key;
    } else {
        return null;
    }
}

(async () => {
    try {
        // const res = await $.ajax({
        //     type: "GET",
        //     url: "/notification/push",
        // });
        setInterval(() => {
            $.ajax({
                type: "GET",
                url: "/notification/push",
                success: function (res) {
                    for (const notify of res) {
                        const notification = new Notification(notify.heading, {
                            body: notify.content,
                            icon: "/static/abic.png",
                        });

                        notification.addEventListener("click", () => {
                            window.open("/contract", "_blank");
                        });

                        Update_Notif(notify.notif_id);
                    }
                },
            });
        }, 5000);
        if (Notification.permission !== "granted") {
            const permission = await Notification.requestPermission();
            if (permission !== "granted") {
                throw new Error("Notification permission denied");
            }
        }
    } catch (error) {
        console.error("Error fetching or displaying notification:", error);
        showError();
    }

    function Update_Notif(id) {
        $.ajax({
            type: "GET",
            url: `/notification/delivered/${id}`,
            success: function (res) {
                console.log("Notification marked as delivered:", id);
            },
            error: function (err) {
                console.error("Error marking notification as delivered:", err);
            },
        });
    }

    function showError() {
        const error = document.querySelector(".error");
        error.style.display = "block";
        error.textContent = "Failed to fetch or display notification";
    }
})();

function NotifIcon() {
    setInterval(() => {
        $.ajax({
            type: "GET",
            url: "/notification/badge",
            success: function (res) {
                if (res.length > 0) {
                    $("#badge-number").removeClass("d-none");
                    $("#badge-number").text(res.length);
                } else {
                    $("#badge-number").addClass("d-none");
                }
            },
        });
    }, 5000);
}
