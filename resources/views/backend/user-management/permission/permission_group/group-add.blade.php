@extends('layouts.master')
@section('title', 'Create Permission Group')

@section('content')
<div class="content-wrapper">
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
                            <h5 class="m-0"><strong><i class="fas fa-wallet"></i> PERMISSION GROUP </strong></h5>
                        </div>

                        <div class="card-body">
                            <div class="container">

                                <form id="AddPermissionForm" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="group_name" class="form-label"
                                            style="font-weight: normal;">Permission Group Name<span
                                                class="text-danger"><strong>*</strong></span></label>
                                        <input type="text" class="form-control w-50" name="group_name" id="group_name"
                                            placeholder="e.g. Apllication Settings">
                                        <h6 class="text-danger pt-1" id="wrong_group_name" style="font-size: 14px;">
                                        </h6>
                                    </div>
                                    <div class="form-group pt-3">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <button type="reset" value="Reset" class="btn btn-outline-danger"
                                            onclick="resetButton()"><i class="fas fa-eraser"></i> Reset</button>
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
<script type="text/javascript" src="{{asset('js/backend/permission-group.js')}}"></script>

@endsection
