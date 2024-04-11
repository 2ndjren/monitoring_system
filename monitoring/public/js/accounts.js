function AccountsEvents() {
    $("#create-user-btn").click(function (e) {
        e.preventDefault();
        $("#create-user-modal").modal("show");
    });
}
