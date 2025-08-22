@extends('layouts.master')
@section('title', 'Bikroyik :: Role List')



@section('content')
<div class="content-wrapper" id="container-wrapper">
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
                            <h5 class="m-0"><strong> Role List</strong></h5>

                        </div>
                        <div class="card-body">
                            <!-- <h6 class="card-title">Special title treatment</h6> -->

                            <!-- <a href="/create-user"><button type="button" class="btn btn-outline-info"><i class="fas fa-plus"></i> Create
                                    User</button></a> -->
                            <!-- Table -->
                            <!-- {{-- @role('admin|superadmin') --}} -->

                            <a href="roles-create"><button type="button" class="btn btn-outline-info"><i class="fas fa-plus"></i> Create
                                    Role</button></a>


                            <!-- <a href="/users-list"><button type="button" class="btn btn-outline-info"><i class="fad fa-users"></i> User List</button></a> -->

                            <div class="card-body">
                                <!-- {{-- @endrole --}} -->
                            </div>

                            <table id="menu_table" class="display table-hover">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Role Name</th>
                                        <th width="60%">Permissions</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach($role->permissions as $perm)
                                                    <span class="badge badge-info mr-1">
                                                        {{ $perm->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>

                                                <a class="edit_btn btn btn-secondary btn-sm"
                                                    href="{{ route('roles.edit', $role->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <a class="delete_btn btn btn-outline-danger btn-sm"
                                                    href="{{ route('roles.destroy', $role->id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                    <i class="fas fa-trash"></i>


                                                </a>

                                                <form id="delete-form-{{ $role->id }}"
                                                    action="{{ route('roles.destroy', $role->id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>

                                                {{-- @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                    @endif

                                    <blade
                                        if|%20(Auth%3A%3Aguard(%26%2339%3Badmin%26%2339%3B)-%3Euser()-%3Ecan(%26%2339%3Badmin.edit%26%2339%3B))%0D>
                                        <a class="btn btn-danger text-white"
                                            href="{{ route('admin.roles.destroy', $role->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form-{{ $role->id }}"
                                            action="{{ route('admin.roles.destroy', $role->id) }}"
                                            method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endif--}}
                                    </td>
                                    </tr>
                                    @endforeach
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

<!-- Edit Category Modal -->
<div class="modal fade" id="EDITMenuMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Menu</h5>
            </div>


            <!-- Update Category Form -->
            <form id="UPDATEMenuFORM" enctype="multipart/form-data">

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body">

                    <input type="hidden" name="id" id="id">

                    <div class="form-group mb-3">
                        <label>Menu Name</label>
                        <input type="text" id="edit_menuname" name="menuname" class="form-control">
                    </div>


                </div>
                <div class="modal-body">


                    <div class="form-group mb-3">
                        <label>Menu Link</label>
                        <input type="text" id="edit_menulink" name="menulink" class="form-control">
                    </div>


                </div>
                <div class="modal-footer">
                    <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <!-- End Update Category Form -->

        </div>
    </div>
</div>
<!-- End Edit Category Modal -->

<!-- Delete Modal -->

<div class="modal fade" id="DELETEMenuMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="DELETEMenuFORM" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}
                {{ method_field('DELETE') }}


                <div class="modal-body">
                    <input type="hidden" name="" id="id">
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


<!-- Data Tablee-->


<!-- END Data Tablee -->

<!-- END Delete Modal -->
<script>
    $(document).ready(function () {
        $('#menu_table').DataTable({
            pageLength : 10,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
        });
    });

</script>
@endsection

@section('script')

<script type="text/javascript">
    $(document).on('click', '#close', function (e) {
        $('#EDITMenuMODAL').modal('hide');
    });

    $(document).on('click', '.cancel_btn', function (e) {
        $('#DELETEMenuMODAL').modal('hide');
    });

</script>

@endsection
