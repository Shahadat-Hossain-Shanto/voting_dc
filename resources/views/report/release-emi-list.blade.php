@extends('layouts.master')
@section('title', 'Bikroyik :: Force Release')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- Optional header content -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Force Release</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <label for="retail">Retail:</label>
                                        <select class="selectpicker form-control" id="retail" title="Select Retail" data-live-search="true">
                                            @foreach ($retail as $retail)
                                                <option value="{{ $retail->id }}">{{ $retail->name }} ({{ $retail->id }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="customer">Customer Id:</label>
                                        <select class="selectpicker form-control" id="customer" title="Select Customer Id" data-live-search="true">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="selectpicker">IMEI:</label>
                                        <select class="selectpicker form-control" id="selectpicker" title="Select IMEI" data-live-search="true">
                                            @foreach ($imei as $imei)
                                                <option value="{{ $imei['imei'] }}">{{ $imei['imei'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="start">Start date:</label>
                                        <span class="text-danger"><strong>*</strong></span>
                                        <input class="form-control" type="date" id="start" name="start">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="end">End date:</label>
                                        <span class="text-danger"><strong>*</strong></span>
                                        <input class="form-control" type="date" id="end" name="end">
                                    </div>
                                    <div class="col-lg-2 my-auto pt-4">
                                        <button type="submit" class="btn btn-primary" id="gen">Generate</button>
                                        <button type="submit" class="btn btn-danger" id="reset">Reset</button>
                                    </div>
                                </div>

                                <div class="pt-3" id="data" hidden>
                                    <div class="table-responsive">
                                        <table id="location_table" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th># </th>
                                                    <th>Customer Id </th>
                                                    <th>Customer Name </th>
                                                    <th>Customer Number </th>
                                                    <th>Release Date</th>
                                                    <th>IMEI_1 </th>
                                                    <th>IMEI_2 </th>
                                                    <th>Actual Payment Date </th>
                                                    <th>Release Until </th>
                                                    <th>Release For Days </th>
                                                    <th>Sale Price </th>
                                                    <th>Down Payment </th>
                                                    <th>Number Of Installment </th>
                                                    <th>Total Payment </th>
                                                    <th>Total Due </th>
                                                    <th>Defaulted Amount </th>
                                                    <th>Defaulted Date </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- Card-body -->
                        </div> <!-- Card -->
                    </div> <!-- /.col-lg-12 -->
                </div><!-- /.row -->
            </div> <!-- container-fluid -->
        </div> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/backend/release-emi.js') }}"></script>
@endsection
