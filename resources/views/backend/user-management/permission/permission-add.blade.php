@extends('layouts.master')
@section('title', 'Create Permission')

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
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="m-0"><strong><i class="fas fa-wallet"></i> Permission</strong></h5>
                        </div>

                        <div class="card-body">
                            <div class="container">
                                <div id="form_div">

                                    <form id="" method="" enctype="multipart/form-data">
                                        {{-- {{ csrf_field() }} --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="vatname" class="form-label"
                                                        style="font-weight: normal;">Permission Name<span
                                                            class="text-danger"><strong>*</strong></span></label>
                                                    <input type="text" class="form-control w-75" name="permission_name"
                                                        id="permission_name" placeholder="Enter Permission Name">
                                                    <h6 class="text-danger pt-1" id="wrong_permission_name"
                                                        style="font-size: 14px;"></h6>

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">

                                                    <label for="brandname" class="form-label"
                                                        style="font-weight: normal;">Permission Group Name<span
                                                            class="text-danger"><strong>*</strong></span></label><br>
                                                    <select style="width:50%"
                                                        class="selectpicker border-left-0 border-right-0 border-top-0 rounded-0"
                                                        name="permission_group" id="permission_group"
                                                        data-live-search="true" title="Select Permission Group Name"
                                                        data-width="75%">
                                                        @foreach($permission_groups as $permission_group)
                                                        <option value="{{ $permission_group->group_name }}">{{
                                                            $permission_group->group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="vatname" class="form-label"
                                                        style="font-weight: normal;">Permission Route Name<span
                                                            class="text-danger"><strong>*</strong></span></label>
                                                    <input type="text" class="form-control w-75" name="route_name"
                                                        id="route_name" placeholder="Enter Permission Route Name">
                                                    <h6 class="text-danger pt-1" id="wrong_permission_name"
                                                        style="font-size: 14px;"></h6>

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="vatname" class="form-label"
                                                        style="font-weight: normal;">Permission type<span
                                                            class="text-danger"><strong>*</strong></span></label><br>
                                                    <select style="width:50%"
                                                        class="selectpicker border-left-0 border-right-0 border-top-0 rounded-0"
                                                        name="permission_type" id="permission_type"
                                                        data-live-search="true" title="Select Permission Type"
                                                        data-width="75%">
                                                        <option value="create">Create</option>
                                                        <option value="edit">Edit</option>
                                                        <option value="view">View</option>
                                                        <option value="destroy">Delete</option>
                                                    </select>
                                                    <h6 class="text-danger pt-1" id="wrong_permission_type"
                                                        style="font-size: 14px;"></h6>

                                                </div>
                                            </div>
                                            <div class="row form-group pt-3">
                                                <div class="col-10">
                                                    <button id="add_btn" type="button"
                                                        class=" w-30 btn btn-primary float-right ml-2"
                                                        onclick="permissionAddToTable()"><i class="fas fa-plus"></i>
                                                        Add</button>
                                                    <button type="reset" value="Reset"
                                                        class="btn btn-outline-danger float-right"
                                                        onclick="resetButton()"><i class="fas fa-eraser"></i>
                                                        Reset</button>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-10">
                                                    <table id="permission_transfer_table" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Route Name</th>

                                                                <th scope="col">Permission Name</th>

                                                                <th scope="col">Permission Group Name</th>

                                                                <th scope="col">Permission Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="permission_transfer_table_body">


                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-1"></div>
                                                <div class="col-9">
                                                    <h6 class="text-danger float-right"><strong id="errorMsg1"></strong>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-10" style="padding-top: 10px">
                                                    <button id="" type="button"
                                                        class=" w-30 btn btn-primary float-right"
                                                        onclick="permissionAddToServer()"> Create Permission</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

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
<script type="text/javascript" src="{{asset('js/backend/permission-transfer.js')}}"></script>

@endsection
