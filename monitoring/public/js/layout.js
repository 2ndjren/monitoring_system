function ActiveDash() {
    $("#dashboard-link").addClass("active");
}
function ActiveUnit_Owner() {
    $("#unit-owner-link").addClass("active");
}
function ActiveAccounts() {
    $("#accounts-link").addClass("active");
}
function ActiveASettings() {
    $("#settings-link").addClass("active");
}
// function Disable_Button(name) {
//     $("#" + name + "").prop("disabled", true);
// }
// function UnDisable_Button(name) {
//     $("#" + name + "").prop("disabled", false);
// }
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

function showConfirmAction(actionLabel, actionMessage) {
    $("#confirmActionLabel").text(actionLabel); //Action Label
    $("#confirmActionMessage").text(actionMessage); //Action Message
    $("#confirmActionModal").modal("show"); //Modal
}
function hideConfirmAction() {
    $("#confirmActionLabel").text(""); //Action Label
    $("#confirmActionMessage").text(""); //Action Message
    $("#confirmActionModal").modal("hide"); //Modal
}
