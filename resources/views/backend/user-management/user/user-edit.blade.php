@extends('layouts.master')
@section('title', 'Bikroyik :: Edit User')

@section('content')
<div class="content-wrapper" id="container-wrapper">
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
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="m-0"><strong> Edit User</strong></h5>
                        </div>

                        <div class="card-body">
                            <div class="container">
                                <form id="EditUserForm" action="" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}
                                    <div class="form-row">
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="name" style="font-weight: normal;">Name<span
                                                    class="text-danger"><strong>*</strong></span></label>
                                            <input type="text" class="form-control w-75" id="edit_name" name="name"
                                                placeholder="Enter Name" value="">
                                            <h6 class="text-danger pt-1" id="edit_wrongname" style="font-size: 14px;">
                                            </h6>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="email" style="font-weight: normal;">Email<span
                                                    class="text-danger"><strong>*</strong></span></label>
                                            <input type="text" class="form-control  w-75" id="edit_email" name="email"
                                                placeholder="Enter Email" value="" disabled>
                                            <h6 class="text-danger pt-1" id="edit_wrongemail" style="font-size: 14px;">
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="mobile" style="font-weight: normal;">Mobile<span
                                                    class="text-danger"><strong>*</strong></span></label>
                                            <input type="text" class="form-control w-75" id="edit_mobile" name="mobile"
                                                placeholder="013********">
                                            <h6 class="text-danger pt-1" id="edit_wrongmobile" style="font-size: 14px;"></h6>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="department" style="font-weight: normal;">Department<span
                                                    class="text-danger"><strong>*</strong></span></label>
                                            <input type="text" class="form-control w-75" id="edit_department" name="department"
                                                placeholder="Support">
                                            <h6 class="text-danger pt-1" id="edit_wrongdepartment" style="font-size: 14px;"></h6>
                                        </div>
                                    </div>

                                    {{-- <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="password" style="font-weight: normal;">Password<span
                                                    class="text-danger"><strong>*</strong></span></label>
                                            <input type="password" class="form-control  w-75" id="edit_password"
                                                name="password" placeholder="Enter Password">
                                            <h6 class="text-danger pt-1" id="edit_wrongpassword" style="font-size: 14px;"></h6>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="password_confirmation" style="font-weight: normal;">Confirm
                                                Password<span class="text-danger"><strong>*</strong></span></label>
                                            <input type="password" class="form-control w-75"
                                                id="edit_password_confirmation" name="password_confirmation"
                                                placeholder="Confirm password">
                                            <h6 class="text-danger pt-1" id="edit_wrongpassword_confirmation" style="font-size: 14px;"></h6>
                                        </div>
                                    </div> --}}

                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-6">
                                            <label for="roles" style="font-weight: normal;">Assign Roles<span
                                                    class="text-danger"><strong>*</strong></span></label><br>
                                            <select name="roles[]" id="edit_roles" class="selectpicker"
                                                data-live-search="true" aria-label="Default select example"
                                                title="Select role" data-width="50%">
                                                @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ?
                                                    'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <h6 class="text-danger pt-1" id="edit_wrongroles" style="font-size: 14px;"> </h6>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                                            <button type="reset" value="Reset"
                                                class="btn btn-outline-danger mt-2 col-form-label"
                                                onclick="resetButton()"><i class="fas fa-eraser"></i> Reset</button>
                                        </div>
                                    </div>
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
<script type="text/javascript" src="{{ asset('js/backend/user-edit.js') }}"></script>

<script>
    var user_id = $('#user_id').val();
fetchUser(user_id);

function resetButton(){
    $('form').on('reset', function() {
        setTimeout(function() {
            $('.selectpicker').selectpicker('refresh');
        });
    });
}

</script>
@endsection
