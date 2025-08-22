@extends('layouts.master')
@section('title', 'Reset Password')

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
                            <h5 class="m-0"><strong>RESET PASSWORD</strong></h5>
                        </div>

                        <div class="card-body">
                            <div class="container">
                                <form id="EditUserForm" action="" method="POST" enctype="multipart/form-data">

                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                                        <div class="form">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="old_password" style="font-weight: normal;">Password<span class="text-danger"><strong>*</strong></span></label>
                                                        <input type="password" class="form-control  w-75" id="edit_old_password" name="old_password"
                                                    placeholder="Enter Old Password">
                                                    <h6 class="text-danger pt-1" id="edit_wrongoldpassword" style="font-size: 14px;"></h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="password" style="font-weight: normal;"> New Password<span class="text-danger"><strong>*</strong></span></label>
                                                        <input type="password" class="form-control  w-75" id="edit_password" name="password"
                                                    placeholder="Enter Password">
                                                    <h6 class="text-danger pt-1" id="edit_wrongpassword" style="font-size: 14px;"></h6>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="password_confirmation" style="font-weight: normal;">Confirm Password<span class="text-danger"><strong>*</strong></span></label>
                                                    <input type="password" class="form-control w-75" id="edit_password_confirmation"
                                                        name="password_confirmation" placeholder="Confirm password">
                                                    <h6 class="text-danger pt-1" id="edit_wrongpassword_confirmation" style="font-size: 14px;"></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                    <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                                            <button type="reset" value="Reset" class="btn btn-outline-danger mt-2 col-form-label" onclick="resetButton()"><i class="fas fa-eraser"></i>Back</button>
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
<script type="text/javascript" src="{{ asset('js/backend/reset-password.js') }}"></script>

<script>



</script>
@endsection
