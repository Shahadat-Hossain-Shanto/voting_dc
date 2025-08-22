function permissionAddToTable() {

    this.event.preventDefault();

    var permission_name =   $("#permission_name").val();
    var permission_group =   $("#permission_group").find("option:selected").val();
    var route_name      =   $("#route_name").val()
    var permission_type =   $("#permission_type").find("option:selected").val();


    // console.log('permission  name : '+permission_name);
    // console.log('permission group name : '+permission_group);
    // console.log('route name : '+route_name);
    // console.log('permission type : '+permission_type);

    // var fromStoreId     =   $("#fromstore").val()
   
    // var productId       =   $("#product").val()
    // var quantity        =   $("#qty").val();

   
            $('#errorMsg').empty()
            $('#errorMsg1').empty()
            if(permission_name.length != 0 && permission_group.length != 0 && route_name.length != 0 && permission_type.length != 0){
                $('#permission_transfer_table_body').append('<tr>\
                    <td>'+route_name+'</td>\
                    <td ">'+permission_name+'</td>\
                    <td>'+permission_group+'</td>\
                    <td ">'+permission_type+'</td>\
                    <td><button class="btn-remove" style="background: transparent;" value=""><i class="fas fa-minus-circle" style="color: red;"></i></button></td>\
                </tr>');
            }else{
                $('#add_btn').notify('Required all fields to add.', {className: 'error', position: 'bottom left'})
            }
            
      
        
   
    
    

}

$("#permission_transfer_table").on('click', '.btn-remove', function () {
    $(this).closest('tr').remove();
})

function permissionAddToServer() {
    this.event.preventDefault();

    let permissions = {};
    let permissionList = []     

    if( $('#permission_transfer_table tr').length > 1){
        // alert('rowCount')
        $('#errorMsg').empty()
        $('#errorMsg1').empty()
        var permissionTable = $('#permission_transfer_table');
        $(permissionTable).find('> tbody > tr').each(function () {
            let permission = {}

            permission["route_name"]       = $(this).find("td:eq(0)").text();
            permission["permission_name"]  = $(this).find("td:eq(1)").text();
            permission["permission_group"] = $(this).find("td:eq(2)").text();
            permission["permission_type"]  = $(this).find("td:eq(3)").text();
            

            permissionList.push(permission);

        })

        permissions["permissionList"] = permissionList
 

       // console.log(permissions)
        productTransfer(permissions)

        // if(products.length>0){
        //     console.log(products);
        //     productTransfer(products)
        // }

    }else{
        $('#errorMsg1').text('Please add atleast one permission to submit.')
    }    
}

function productTransfer(jsonData){

    // alert("Requesting Transfer")
    // var data = JSON.stringify(jsonData)

    // console.log(data)
    
    $.ajax({
        type: "POST",
        url: "/permission-create",
        data: JSON.stringify(jsonData),
        dataType : "json",
        contentType: "application/json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // console.log(response.request)
            // invoice(response.orderId)
            // alert(response.message);
            $.notify(response.message, {className: 'success', position: 'bottom right'});
            $(location).attr("href", "/permission-list");
            
            resetButton()                  
        }
    });

}

function resetButton(){
    $('#errorMsg').empty()
    $('#errorMsg1').empty()
    $('#form_div').find('form')[0].reset();
    $("#permission_transfer_table").find("tr:gt(0)").remove();
    $('form').on('reset', function() {
        setTimeout(function() {
            $('.selectpicker').selectpicker('refresh');
        });
    });
}