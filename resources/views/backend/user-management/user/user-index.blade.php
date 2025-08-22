@extends('layouts.master')
@section('title', 'Bikroyik :: Users List')

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
                            <h5 class="m-0"><strong><i class="fas fa-users"></i> Users List</strong></h5>
                        </div>
                        <div class="card-body">
                            <!-- <h6 class="card-title">Special title treatment</h6> -->

                            <a href="/create-user"><button type="button" class="btn btn-outline-info"><i
                                        class="fas fa-plus"></i> Create User</button></a>
                            <div class="pt-3">
                                <table id="menu_table" class="display ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">Sl</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Email</th>
                                            {{-- <th width="10%">Contact</th> --}}
                                            <th width="10%">Roles</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            {{-- <td>{{ $user->contact_number }}</td> --}}
                                            <td>
                                                @foreach($user->roles as $role)

                                                {{ $role->name }}
                                                </span>
                                                @endforeach


                                                {{-- @foreach($roles as $role)
                                                @php
                                                $user_role=$user->hasRole($role->name);
                                                @endphp

                                                @if(is_null( $user_role))
                                                {{ 'no assign role' }}

                                                @else
                                                {{ $user$role->id }}
                                                @endif

                                                @endforeach--}}
                                                {{-- @foreach($user->roles as $role)
                                                <span class="badge badge-info mr-1">
                                                    {{ $role->name }}
                                                </span>
                                                @endforeach--}}
                                            </td>
                                            <td>

                                                <a class="edit_btn btn btn-secondary btn-sm"
                                                    href="{{ route('user.edit.view', $user->id) }}"><i
                                                        class="fas fa-edit"></i></a>

                                                <a class="delete_btn btn btn-outline-danger btn-sm"
                                                    href="{{ route('users.destroy', $user->id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                                {{-- <a class="btn btn-success text-white"
                                                    href="{{ route('users.edit', $user->id) }}">Edit</a>

                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('users.destroy', $user->id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                    Delete
                                                </a>

                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form> --}}
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
