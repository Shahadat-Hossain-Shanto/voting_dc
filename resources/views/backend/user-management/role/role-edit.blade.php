@extends('layouts.master')
@section('title', 'Bikroyik :: Edit Role')

@section('content')
<div class="content-wrapper" id="">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row">
				<!-- Header -->
			</div>
		</div>
	</div>

	<div class="content">
		<div class="container-fluid ">
			<div class="row">
				<div class="col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<h5 class="m-0"><strong><i class="fas fa-users-cog"></i> Edit Role</strong></h5>
						</div>

						<div class="card-body">
							<div class="container">

								<form name="AddMenuForm " action="{{ route('roles.edit', $role->id) }}"
									method="POST">
									@method('PUT')
									@csrf
									<div class="row">

										<div class="col-6">
											<div class="form-group">
												<label for="rolename" style="font-weight:normal; ">Role Name</label>
												<input type="text" class="form-control w-75" id="rolename"
													style="font-weight: ;" name="rolename"
													value="{{ $role->name }}">
											</div>
											<div class="form-check ml-1">
												<input type="checkbox" style="width: 16px;height: 16px;" class="form-check-input" id="checkPermissionAll"
													value="1">
												<label class="form-check-label" style="font-size:16px"  for="checkPermissionAll">All
														Permissions</label>
											</div>
										</div>

									</div>
									{{-- <hr> --}}

									@php $i = 1; @endphp

									@foreach($permissions as $permission)
									<div id="div{{ $i }}">
										<div class="form-group float-left pt-3" style="margin-left: 20px">
											<input type="checkbox" class="form-check-input"
												style="width: 16px;height: 16px;" id="checkPermissionAll_group{{ $i }}"
												onclick="checkCheckboxes(this.id, 'div{{ $i }}');" value="{{ $permission->name }}">
									  		<label class=" form-check-label" for="checkPermissionAll_group{{ $i }}" style="font-size:17px">
											<b>{{$permission->name}}</b></label>
										</div>

										@php $i++; @endphp

										@php
										$permissions_names=App\Models\User::getpermissionsByPermissionName($permission->name);
										$j = 1;
										@endphp

										<hr>

										<table class="table table-bordered" id="class_table" width="100%"
											cellspacing="0">

											<tr class="table-info">
												<th>Sl</th>
												<th>Permission Name</th>

												<th>Create</th>
												<th>Read</th>
												<th>Update</th>
												<th>Delete</th>
											</tr>
											@foreach($permissions_names as $permission_name)

											<tr>
												<td>
													@php
													echo $j
													@endphp
												</td>

												<td>

													<label class="form-check-label">{{
														$permission_name->permissions_name }}
													</label>

												</td>

												<td>
													@if($contains = Str::contains($permission_name->p_create, 'create'))
													{{-- @if($permission->permission_type == "create") --}}
													<label class="form-check-label" for="checkPermission"> {!! "&emsp;"
														;
														"&nbsp;" ; "&nbsp;"; "&nbsp;"; "&nbsp;"!!}</label>
													<input type="checkbox" class="form-check-input" name="permissions[]"
														id="checkPermission{{ $permission_name->p_create_id }}"
														value="{{ $permission_name->p_create }}">

													<input type="checkbox" class="form-check-input" name="permissions[]"
														{{ $role->hasPermissionTo($permission_name->p_create) ?
													'checked' : '' }} id="checkPermission{{
													$permission_name->p_create_id }}" value="{{
													$permission_name->p_create }}">
													{{-- <label class="form-check-label"
														for="checkPermission{{$permission_name->p_create_id}}">{{$permission_name->p_create
														}}</label> --}}
													@else
													{{-- {{"N/A"}} --}}
													@endif
												</td>

												<td>
													@if($contains = Str::contains($permission_name->p_view, 'view'))
													{{-- @if($permission->permission_type == "view") --}}
													<label class="form-check-label" for="checkPermission"> {!! "&emsp;"
														;
														"&nbsp;" ; "&nbsp;"; "&nbsp;"; "&nbsp;"!!}</label>

													<input type="checkbox" class="form-check-input" name="permissions[]"
														{{ $role->hasPermissionTo($permission_name->p_view) ? 'checked'
													: '' }} id="checkPermission{{ $permission_name->p_view_id }}"
													value="{{ $permission_name->p_view }}">

													@else
													{{-- {{"N/A"}} --}}
													@endif
												</td>

												<td>
													@if($contains = Str::contains($permission_name->p_edit, 'edit'))
													{{-- @if($permission->permission_type == "edit") --}}
													<label class="form-check-label" for="checkPermission"> {!! "&emsp;"
														;
														"&nbsp;" ; "&nbsp;"; "&nbsp;"; "&nbsp;"!!}</label>

													<input type="checkbox" class="form-check-input" name="permissions[]"
														{{ $role->hasPermissionTo($permission_name->p_edit) ? 'checked'
													: '' }} id="checkPermission{{ $permission_name->p_edit_id }}"
													value="{{ $permission_name->p_edit }}">
													@else
													{{-- {{"N/A"}} --}}
													@endif

												</td>



												<td>
													@if($contains = Str::contains($permission_name->p_destroy,
													'destroy'))
													{{-- @if($permission->permission_type == "destroy") --}}
													<label class="form-check-label" for="checkPermission"> {!! "&emsp;"
														;
														"&nbsp;" ; "&nbsp;"; "&nbsp;"; "&nbsp;"!!}</label>

													<input type="checkbox" class="form-check-input" name="permissions[]"
														{{ $role->hasPermissionTo($permission_name->p_destroy) ?
													'checked' : '' }} id="checkPermission{{
													$permission_name->p_destroy_id }}" value="{{
													$permission_name->p_destroy }}">
													@else
													{{-- {{"N/A"}} --}}
													@endif
												</td>
											</tr>

											@php $j++; @endphp

											@endforeach

										</table>

										<br>
									</div>

									@endforeach

									<button type="submit" class="btn btn-primary mt-4">Save Role</button>
								</form>

							</div> <!-- container -->
						</div> <!-- card-body -->
					</div> <!-- card card-primary card-outline -->
				</div> <!-- col-lg-5 -->
			</div> <!-- row -->
		</div> <!-- container-fluid -->
	</div> <!-- content -->

</div> <!-- content-wrapper -->

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/backend/permission.js')}}"></script>

@endsection
