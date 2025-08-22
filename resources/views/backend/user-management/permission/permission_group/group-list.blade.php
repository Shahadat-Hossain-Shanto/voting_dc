@extends('layouts.master')
@section('title', 'Permission Group List')

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
                                <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Permissions Groups</strong>
                                </h5>
                            </div>
                            <div class="card-body">


                                <a href="/permission-group-add"><button type="button" class="btn btn-outline-info"><i
                                            class="fas fa-plus"></i> Create Permission Group</button></a>


                                <div class="pt-3">
                                    <table id="permission_group_table" class="display">
                                        <thead>
                                            <tr>
                                                <!-- <th>Sl</th> -->

                                                <th>Permission Group Name </th>

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
    <div class="modal fade" id="EDITPermissionGroupMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>UPDATE PERMISSION GROUP</strong></h5>
                </div>


                <!-- Update Vat Form -->
                <form id="UPDATEPermissionGroupFORM" enctype="multipart/form-data">

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="modal-body">

                        <input type="hidden" name="id" id="id">

                        <div class="form-group mb-3">
                            <label>Permission Name<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" id="edit_group_name" name="group_name" class="form-control">
                            <h6 class="text-danger pt-1" id="edit_wrong_group_name" style="font-size: 14px;"></h6>

                        </div>



                    </div>

                    <div class="modal-footer">
                        <button id="close" type="button" class="btn btn-outline-danger"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
                <!-- End Update Vat Form -->

            </div>
        </div>
    </div>
    <!-- End Edit Vat Modal -->

    <!-- Delete Modal -->

    <div class="modal fade" id="DELETEPermissionGroupMODAL" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form id="DELETEPermissionGroupFORM" method="POST" enctype="multipart/form-data">

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
    <script type="text/javascript" src="{{ asset('js/backend/permission-group.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '#close', function(e) {
            $('#EDITPermissionGroupMODAL').modal('hide');
            $('#edit_wrong_permission_group_name').empty();


        });
        $(document).on('click', '.cancel_btn', function(e) {
            $('#DELETEPermissionGroupMODAL').modal('hide');
        });
    </script>

@endsection
