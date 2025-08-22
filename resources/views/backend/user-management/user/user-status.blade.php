@extends('layouts.master')
@section('title', 'Bikroyik :: Users Status')

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
                            <h5 class="m-0"><strong><i class="fas fa-users"></i> Users Status</strong></h5>
                        </div>
                        <div class="card-body">
                                <table id="menu_table" class="display ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">Sl</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Contact</th>
                                            <th width="10%">Email</th>
                                            <th width="10%">Department</th>
                                            <th width="10%">Roles</th>
                                            <th width="10%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->department }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                {{ $role->name }}
                                                </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($user->status=='Active')
                                                    <a class="delete_btn btn btn-success btn-sm" href="#">
                                                        {{ $user->status }}
                                                    </a>
                                                @else
                                                    <a class="delete_btn btn btn-danger btn-sm" href="#">
                                                        {{ $user->status }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div> <!-- Card-body -->
                </div> <!-- Card -->

            </div> <!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div> <!-- container-fluid -->
</div> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<script>
    $(document).ready(function () {
        $('#menu_table').DataTable({
            pageLength : 10,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
        });
    });

</script>
@endsection
