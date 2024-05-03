$(document).ready(function () {
    var msg = localStorage.getItem("msg");
    if (msg) {
        showtoastMessage("text-success", "Access Granted", msg);
        localStorage.removeItem("msg");
    }
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
