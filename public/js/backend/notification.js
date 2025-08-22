$(document).ready(function () {
    $.ajax({
        type: "get",
        url: "notification-data",
        success: function (response) {
            $('#notification_par_day').val(response.notification_par_day);
            $('#notification_before_dates').val(response.notification_before_dates);
            $('#lock_after_days').val(response.lock_after_days);
        }
    });
});

$("#done").click(function (event) {
    event.preventDefault();

    let data= {};
	data["notification_par_day"] 		= $('#notification_par_day').val();
	data["notification_before_dates"] 	= $('#notification_before_dates').val();
	data["lock_after_days"] 	        = $('#lock_after_days').val();

    $.ajax({
        type: "post",
        url: "notification-data",
        data: JSON.stringify(data),
        dataType : "json",
        contentType: "application/json",
        headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        success: function (response) {
            $(location).attr("href", "notification");
        }
    });
});
