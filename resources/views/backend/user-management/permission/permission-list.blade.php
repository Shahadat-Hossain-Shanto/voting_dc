@extends('layouts.master')
@section('title', 'Permission')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row mb-2 -->
        </div><!-- /.container-fluid -->
    </div> <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Permissions</strong></h5>
                        </div>
                        <div class="card-body">
                            <!-- <h6 class="card-title">Special title treatment</h6> -->
                            <!-- Table -->

                            <a href="/permission-create"><button type="button" class="btn btn-outline-info"><i
                                        class="fas fa-plus"></i> Create Permission</button></a>
                            <!-- <a href="/permission-group-add"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Create Permission Group</button></a> -->


                            <div class="pt-3">
                                <table id="permission_table" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Route Name</th>
                                            <th>Permission Name</th>
                                            <th>Permission Group </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- Card-body -->
                    </div> <!-- Card -->

                </div> <!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div> <!-- container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<!-- Edit Vat Modal -->
<div class="modal fade" id="EDITPermissionMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>UPDATE PERMISSION</strong></h5>
            </div>


            <!-- Update Vat Form -->
            <form id="UPDATEPermissionFORM" enctype="multipart/form-data">

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body">

                    <input type="hidden" name="id" id="id">

                    <div class="form-group mb-3">
                        <label>Permission Name<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" id="edit_permission_name" name="permission_name" class="form-control">
                        <h6 class="text-danger pt-1" id="edit_wrong_permission_name" style="font-size: 14px;"></h6>

                    </div>

                    {{-- {{$permission->group_name}} --}}
                    <div class="form-group mb-3">
                        <label>Permission Group Name <span class="text-danger"><strong>*</strong></span></label><br>
                        <select class="selectpicker" data-width="100%" data-live-search="true" name="permission_group"
                            id="edit_permission_group">
                            @foreach($permission_groups as $permission_group)
                            <option value="{{$permission_group->group_name}}">{{$permission_group->group_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Permission route name <span class="text-danger"><strong>*</strong></span></label>
                        <input type="test" id="edit_route_name" name="route_name" class="form-control">
                        <h6 class="text-danger pt-1" id="edit_wrong_permission_group" style="font-size: 14px;"></h6>

                    </div>

                    <div class="form-group mb-3">
                        <label>Permission Type <span class="text-danger"><strong>*</strong></span></label>
                        <select class="form-control" name="permission_group_type" id="edit_permission_group_type">
                            <option value="create">Create</option>
                            <option value="edit">Edit</option>
                            <option value="view">View</option>
                            <option value="destroy">Delete</option>
                        </select>
                    </div>


                </div>

                <div class="modal-footer">
                    <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <!-- End Update Vat Form -->

        </div>
    </div>
</div>
<!-- End Edit Vat Modal -->

<!-- Delete Modal -->

<div class="modal fade" id="DELETEPermissionMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="DELETEPermissionFORM" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}
                {{ method_field('DELETE') }}


                <div class="modal-body">
                    <input type="hidden" name="" id="vatid">
                    <h5 class="text-center">Are you sure you want to delete?</h5>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="cancel btn btn-secondary cancel_btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" class="delete btn btn-danger">Yes</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- END Delete Modal -->

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/backend/permission-list.js')}}"></script>
<script type="text/javascript">
    $(document).on('click', '#close', function (e) {
		$('#EDITPermissionMODAL').modal('hide');
		$('#edit_wrong_permission_name').empty();
		$('#edit_wrong_permission_group').empty();

	});
	$(document).on('click', '.cancel_btn', function (e) {
		$('#DELETEPermissionMODAL').modal('hide');
	});
</script>

@endsection

