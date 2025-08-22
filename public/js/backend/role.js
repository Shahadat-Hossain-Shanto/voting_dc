$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	//CREATE ROLE
	$(document).on('submit', '#AddRoleForm', function (e) {
		e.preventDefault();

		let formData = new FormData($('#AddRoleForm')[0]);

		$.ajax({
			type: "POST",
			url: "/role-create",
			data: formData,
			contentType: false,
			processData: false,
			success: function(response){
				//console.log(response.message);	
				$(location).attr('href','/role-list');
			}
		});

	});

});

//ROLE LIST
fetchRole();
function fetchRole(){
	$.ajax({
		type: "GET",
		url: "/api/role-list",
		dataType:"json",
		success: function(response){
			$('tbody').html("");
			$.each(response.role, function(key, item) {
				$('tbody').append('<tr>\
				<td>'+item.id+'</td>\
				<td>'+item.roleName+'</td>\
				<td>'+item.description+'</td>\
				<td>\
					<button type="button" value="'+item.id+'" class="edit_btn btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i>\
                    </button>\
                	<a href="javascript:void(0)" class="delete_btn btn btn-outline-danger btn-sm" data-value="'+item.id+'"><i class="fas fa-trash"></i></a>\
    			</td>\
    		</tr>');
			})	
		}
	});
}

//EDIT ROLE
	$(document).on('click', '.edit_btn', function (e) {
		e.preventDefault();

		var roleId = $(this).val();
		// alert(roleId);
		$('#EDITRoleMODAL').modal('show');
			
			$.ajax({
			type: "GET",
			url: "/role-edit/"+roleId,
			success: function(response){
				if (response.status == 200) {
					$('#edit_rolename').val(response.role.roleName);
					$('#edit_description').val(response.role.description);
					$('#roleid').val(roleId);
				}
			}
		});
	});

	//UPDATE ROLE
	$(document).on('submit', '#UPDATERoleFORM', function (e)
	{
		e.preventDefault();

		var id = $('#roleid').val(); 

		let EditFormData = new FormData($('#UPDATERoleFORM')[0]);

		EditFormData.append('_method', 'PUT');

		$.ajax({
			type: "POST",
			url: "/role-edit/"+id,
			data: EditFormData,
			contentType: false,
			processData: false,
			success: function(response){
				if(response.status == 200){
					$('#EDITRoleMODAL').modal('hide');
					alert(response.message);
					fetchRole();
				}
			}
		});
	});

//DELETE ROLE
$(document).ready( function () {
	$('#role_table').on('click', '.delete_btn', function(){

		var roleId = $(this).data("value");

		$('#roleid').val(roleId);

		$('#DELETERoleFORM').attr('action', '/role-delete/'+roleId);

		$('#DELETERoleMODAL').modal('show');

	});
});


//DATA TABLE
$(document).ready( function () {
	$('#role_table').DataTable({
	    pageLength : 10,
	    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
	});
});