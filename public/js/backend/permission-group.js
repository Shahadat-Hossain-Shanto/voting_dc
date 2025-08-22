$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //CREATE permission_groups
    $(document).on("submit", "#AddPermissionForm", function (e) {
        e.preventDefault();

        let formData = new FormData($("#AddPermissionForm")[0]);

        $.ajax({
            type: "POST",
            url: "/permission-group-add",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                //

                if ($.isEmptyObject(response.error)) {
                   $(location).attr("href", "/permission-group-list");

                }else{
                    printErrorMsg(response.error);
                    
                }

                
            },
        });
    });

    function printErrorMsg(message) {

        $("#wrong_group_name").empty();

        if (message.group_name == null) {
            group_name = "";
        } else {
            group_name = message.group_name[0];
        }
      

        $("#wrong_group_name").append('<span id="">' + group_name + "</span>");


        // });
    }
});

//permission_groups LIST
fetchVat();
function fetchVat() {
    $.ajax({
        type: "GET",
        url: "/permission-group-list-data",
        dataType: "json",
        success: function (response) {
            
            $("tbody").html("");
            $.each(response.permission_groups, function (key, item) {
                $("tbody").append(
                    "<tr>\
                        <td>" +item.group_name +'</td>\
                        <td>\
                            <button type="button" value="' +
                                item.id +
                                '" class="edit_btn btn btn-secondary btn-sm"><i class="fas fa-edit"></i>\
                            </button>\
                            <a href="javascript:void(0)" class="delete_btn btn btn-outline-danger btn-sm" data-value="' +
                                item.id +
                                '"><i class="fas fa-trash"></i></a>\
                        </td>\
                    </tr>'
                );
            });
        },
    });
}

//EDIT permission_groups
$(document).on("click", ".edit_btn", function (e) {
    e.preventDefault();

    var Id = $(this).val();
    // alert(vatId);
    $("#EDITPermissionGroupMODAL").modal("show");

    $.ajax({
        type: "GET",
        url: "/permission-group-edit/" + Id,
        success: function (response) {
            if (response.status == 200) {
                $("#edit_group_name").val(
                    response.permission_group.group_name
                );
                // $("#edit_permission_group").val(response.permission.group_name);
                // $("#edit_store").val(response.vat.store);
                $("#id").val(response.permission_group.id);
            }
        },
    });
});

//UPDATE VAT
$(document).on("submit", "#UPDATEPermissionGroupFORM", function (e) {
    e.preventDefault();

    var id = $("#id").val();

    let EditFormData = new FormData($("#UPDATEPermissionGroupFORM")[0]);

    EditFormData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: "/permission-group-edit/" + id,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                // alert(response.message);
                $("#EDITPermissionGroupMODAL").modal("hide");
                // $.notify(response.message, "success");
                $(location).attr("href", "/permission-group-list");
            } else {
                // 
                printErrorMsg(response.error);
                // $("#edit_wrong_permission_group_name").empty();
            }
        },
    });

    function printErrorMsg (message) {
        $('#edit_wrong_group_name').empty();
        

        if(message.group_name == null){
            group_name = ""
        }else{
            group_name = message.group_name[0]
        }

        $('#edit_wrong_group_name').append('<span id="">'+group_name+'</span>');

    }

});

//Delete Vat
$(document).ready(function () {
    $("#permission_group_table").on("click", ".delete_btn", function () {
        var Id = $(this).data("value");

        $("#id").val(Id);

        $("#DELETEPermissionGroupFORM").attr(
            "action",
            "permission-group-delete/" + Id
        );

        $("#DELETEPermissionGroupMODAL").modal("show");
    });
});

//DATA TABLE
$(document).ready(function () {
    $("#permission_group_table").DataTable({
        pageLength: 10,
        lengthMenu: [
            [5, 10, 20, -1],
            [5, 10, 20, "Todos"],
        ],
        // fnRowCallback: function (
        //     nRow,
        //     aData,
        //     iDisplayIndex,
        //     iDisplayIndexFull
        // ) {
        //     //debugger;
        //     var index = iDisplayIndexFull + 1;
        //     $("td:first", nRow).html(index);
        //     return nRow;
        // },
    });
});

function resetButton() {
    $("form").on("reset", function () {
        setTimeout(function () {
            $(".selectpicker").selectpicker("refresh");
        });
    });
}
