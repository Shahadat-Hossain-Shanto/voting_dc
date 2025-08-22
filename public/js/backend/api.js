$(document).ready(function () {
    $.ajax({
        type: "get",
        url: "api-data",
        success: function (response) {
            $('#hit_api_after_minutes').val(response.hit_api_after_minutes);
        }
    });
});

$("#done").click(function (event) {
    event.preventDefault();

    let data= {};
	data["hit_api_after_minutes"] 		= $('#hit_api_after_minutes').val();

    $.ajax({
        type: "post",
        url: "api-data",
        data: JSON.stringify(data),
        dataType : "json",
        contentType: "application/json",
        headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        success: function (response) {
            $(location).attr("href", "api-view");
        }
    });
});
