(async () => {
    try {
        const res = await $.ajax({
            type: "GET",
            url: "/notification/push",
        });

        if (Notification.permission !== "granted") {
            const permission = await Notification.requestPermission();
            if (permission !== "granted") {
                throw new Error("Notification permission denied");
            }
        }

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
