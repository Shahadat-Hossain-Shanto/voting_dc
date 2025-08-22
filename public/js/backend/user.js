$(document).ready(function () {
	//CREATE UNIT
	$(document).on('submit', '#AddUserForm', function (e) {
		e.preventDefault();

		let formData = new FormData($('#AddUserForm')[0]);

		$.ajax({
			type: "POST",
			url: "/create-user",
			data: formData,
			contentType: false,
			processData: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response){
				// alert(response.message);
				if($.isEmptyObject(response.error)){
                    // alert('Success')
             		$(location).attr('href','/users-list');

                }else{
                	// console.log(response.error)
                    printErrorMsg(response.error);
                }
			}
		});
	});

	function printErrorMsg (message) {
            $('#wrongname').empty();
            $('#wrongemail').empty();
            $('#wrongmobile').empty();
            $('#wrongdepartment').empty();
            $('#wrongpassword').empty();
            $('#wrongpassword_confirmation').empty();
            $('#wrongroles').empty();

			if(message.name == null){
				name = ""
			}else{
				name = message.name[0]
			}

			if(message.email == null){
				email = ""
			}else{
				email = message.email[0]
			}

			if(message.mobile == null){
				mobile = ""
			}else{
				mobile = message.mobile[0]
			}

			if(message.department == null){
				department = ""
			}else{
				department = message.department[0]
			}

			if(message.roles == null){
				roles = ""
			}else{
				roles = message.roles[0]
			}

			if(message.password == null){
				password = ""
			}else{
				password = message.password[0]
			}

			if(message.password_confirmation == null){
				password_confirmation = ""
			}else{
				password_confirmation = message.password_confirmation[0]
			}

            $('#wrongname').append('<span id="">'+name+'</span>');
            $('#wrongemail').append('<span id="">'+email+'</span>');
            $('#wrongmobile').append('<span id="">'+mobile+'</span>');
            $('#wrongdepartment').append('<span id="">'+department+'</span>');
            $('#wrongpassword').append('<span id="">'+password+'</span>');
            $('#wrongpassword_confirmation').append('<span id="">'+password_confirmation+'</span>');
            $('#wrongroles').append('<span id="">'+roles+'</span>');


        // });
    }



});
