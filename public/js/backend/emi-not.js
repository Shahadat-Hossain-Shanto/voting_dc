//EDIT SYSTEM RSETRICTION
$(document).on("click", "#systemRestriction", function (e) {
    e.preventDefault();
    var imei = $(this).val();

    $("#EDITSystemRestrictionMODAL").modal("show");

    $("#imei").val(imei);

});

//UPDATE SYSTEM RSETRICTION
$(document).on("submit", "#UPDATESystemRestrictionFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATESystemRestrictionFORM")[0]);

    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/system-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITSystemRestrictionMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});
//EDIT APP RSETRICTION

$(document).on("click", "#appRestriction", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $("#EDITAppRestrictionMODAL").modal("show");

    $("#imei").val(imei);


});

//UPDATE APP RSETRICTION
$(document).on("submit", "#UPDATEAppRestrictionFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATEAppRestrictionFORM")[0]);



    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/app-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITPaymentForwardMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});
//OPEN MESSAGE NOTIFICATION MODAL
$(document).on("click", "#sendMessage", function (e) {
    e.preventDefault();
    var imei = $(this).val();
    $("#EDITSendMessageMODAL").modal("show");
    $("#imei").val(imei);

});
//CREATE MESSAGE NOTIFICATION
$(document).on("submit", "#ADDMessageNotificationFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#ADDMessageNotificationFORM")[0]);


    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/add-msg-notification",
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITSendMessageMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});
//PUSH REMINDER BUTTON

$(document).on("click", "#pushReminder", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $("#EDITPushReminderMODAL").modal("show");

    $("#imei").val(imei);

});
//DAY-7 BUTTON
$(document).on("click", "#day-7button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-7-notification/" + imei);

    // $.notify("Message Sent Succesfully");
});
//DAY-6 BUTTON
$(document).on("click", "#day-6button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-6-notification/" + imei);

});
//DAY-5 BUTTON
$(document).on("click", "#day-5button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-5-notification/" + imei);

});
//DAY-4 BUTTON
$(document).on("click", "#day-4button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-4-notification/" + imei);

});
//DAY-3 BUTTON
$(document).on("click", "#day-3button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-3-notification/" + imei);

});
//DAY-2 BUTTON
$(document).on("click", "#day-2button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-2-notification/" + imei);

});
//DAY-1 BUTTON
$(document).on("click", "#day-1button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-1-notification/" + imei);

});
//DAY-0 BUTTON
$(document).on("click", "#day-0button", function (e) {
    e.preventDefault();

    var imei = $(this).val();

    $(location).attr("href", "/day-0-notification/" + imei);

});

//LOCK DEVICE
$(document).on("submit", "#UPDATELockDeviceFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATELockDeviceFORM")[0]);

    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/lock-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});
//UNLOCK DEVICE
$(document).on("submit", "#UPDATEUnLockDeviceFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATEUnLockDeviceFORM")[0]);

    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/unlock-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});

//REMOVE RESTRICTION BUTTON
$(document).on("click", "#removeRestriction", function (e) {
    e.preventDefault();
    var imei = $(this).val();

    $("#EDITRemoveRestrictionMODAL").modal("show");

    $("#imei").val(imei);

});
//REMOVE SYSTEM RESTRICTION BUTTON
$(document).on("click", "#removeSystemRestriction", function (e) {
    e.preventDefault();
    var imei = $(this).val();

    $("#EDITRemoveRestrictionMODAL").modal("hide");

    $("#EDITRemoveSystemRestrictionMODAL").modal("show");

    $("#imei").val(imei);

});
//UPDATE REMOVE SYSTEM RSETRICTION
$(document).on("submit", "#UPDATERemoveSystemRestrictionFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATERemoveSystemRestrictionFORM")[0]);


    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/remove-system-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITSystemRestrictionMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});

//REMOVE APP RESTRICTION BUTTON
$(document).on("click", "#removeAppRestriction", function (e) {
    e.preventDefault();
    var imei = $(this).val();

    $("#EDITRemoveRestrictionMODAL").modal("hide");
    $("#EDITRemoveAppRestrictionMODAL").modal("show");

    $("#imei").val(imei);

});
//UPDATE REMOVE APP RSETRICTION
$(document).on("submit", "#UPDATERemoveAppRestrictionFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();
    let EditFormData = new FormData($("#UPDATERemoveAppRestrictionFORM")[0]);
    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/remove-app-restiction/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITPaymentForwardMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei);
            }

        },
    });
});


//EDIT PAYMENT FORWARD 

$(document).on("click", "#paymentForward", function (e) {
    e.preventDefault();

    var imei = $(this).val();
    $("#EDITPaymentForwardMODAL").modal("show");
    $("#imei").val(imei);

});
//UPDATE PAYMENT FORWARD 
$(document).on("submit", "#UPDATEPaymentForwardFORM", function (e) {
    e.preventDefault();

    var imei = $("#imei").val();

    let EditFormData = new FormData($("#UPDATEPaymentForwardFORM")[0]);

    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/emi-next-payment-date/" + imei,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                $("#EDITPaymentForwardMODAL").modal("hide");
                $(location).attr("href", "/notification/" + imei); 
            }

        },
    });
});