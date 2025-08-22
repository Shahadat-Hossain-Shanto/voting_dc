function resetButton(){
    $(location).attr('href','/dashboard');
}

$(document).on('submit', '#EditUserForm', function (e){
    e.preventDefault();
    var id = $('#user_id').val();

    // alert(productId)
    let EditFormData = new FormData($('#EditUserForm')[0]);
    EditFormData.append('_method', 'PUT');
    $.ajax({
        ajaxStart: $('body').loadingModal({
              position: 'auto',
              text: 'Please Wait',
              color: '#fff',
              opacity: '0.7',
              backgroundColor: 'rgb(0,0,0)',
              animation: 'foldingCube'
            }),
        type: "POST",
        url: "/reset-password/"+id,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {

            if($.isEmptyObject(response.error)){
                $(location).attr('href','/dashboard');
            }else{
                $('body').loadingModal('destroy');
                printErrorEditMsg(response.error);
            }
        }
    });
});

function printErrorEditMsg (message) {
    $('#edit_wrongoldpassword').empty();
    $('#edit_wrongpassword').empty();
    $('#edit_wrongpassword_confirmation').empty();

    if(message.old_password == null){
        old_password = ""
    }else{
        old_password = message.old_password[0]
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

    $('#edit_wrongoldpassword').append('<span id="">'+old_password+'</span>');
    $('#edit_wrongpassword').append('<span id="">'+password+'</span>');
    $('#edit_wrongpassword_confirmation').append('<span id="">'+password_confirmation+'</span>');
}
