@extends('layouts.master')
@section('title', ' Bikroyik :: Master Reset')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </div> <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Master Reset</strong>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row container-fluid">
                                    <div class="col-lg-3 col-md-6 col-sm-6" id="totalReseted" hidden>
                                        <div class="card card-stats card-height">
                                            <div class="card-header card-header-warning card-header-icon">
                                                <div class="card-icon">
                                                    <i class="fas fa-duotone fa-mobile nav-icon"></i>
                                                </div>
                                                <p class="card-category">Total Reseted</p>
                                                <h3 class="card-title"id="total_reseted"></h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row col-lg-9 col-md-6 col-sm-6">
                                        <div class="col">
                                            <label for="type" class="col-form-label">Search By
                                                <span class="text-danger"><strong>*</strong></span>
                                            </label>
                                            <select class="selectpicker form-control" id="type" title="Select Retail, Model or Date" data-live-search="true">
                                                <option value="Retail">Retail</option>
                                                <option value="Model">Model</option>
                                                <option value="Date">Date</option>
                                            </select>
                                        </div>
                                        <!-- Data Field (Dynamic) -->
                                        <div class="col type" hidden style="padding-top: 6px;">
                                            <label>Type <span class="text-danger"><strong>*</strong></span></label>
                                            <div class="data-container">
                                                <input type="text" name="data" id="data" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col date" hidden>
                                            <label for="start"class="col-form-label">Start date:</label>
                                            <span class="text-danger modelPriority"><strong>*</strong></span>
                                            <input class="form-control" type="date" id="startdate" name="start">
                                        </div>
                                        <div class="col date" hidden>
                                            <label for="end"class="col-form-label">End date:</label>
                                            <span class="text-danger modelPriority"><strong>*</strong></span>
                                            <input class="form-control" type="date" id="enddate" name="end">
                                        </div>
                                        <div class="col pt-9" id="generateBtn">
                                            <button type="submit" class="btn btn-primary" id="gen"class="gen-button">
                                                Generate
                                            </button>
                                            <button type="submit" class="btn btn-danger" id="reset"class="reset-button">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="dataTable" hidden>
                                    <div class="pt-3">
                                        <div class="table-responsive">
                                            <table id="mobile_table" class="display table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Index</th>
                                                        <th>Reset Date</th>
                                                        <th>Reset Reason</th>
                                                        <th>Customer id</th>
                                                        <th>Customer Name</th>
                                                        <th>Customer Nid</th>
                                                        <th>Contact Number</th>
                                                        <th>IMEI one</th>
                                                        <th>IMEI two</th>
                                                        <th>Serial No</th>
                                                        <th>Retail Id</th>
                                                        <th>Retail Name</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Pos Invoice Number</th>
                                                        <th>Price</th>
                                                        <th>Number of Installment</th>
                                                        <th>Down Payment</th>
                                                        <th>Purchase Date</th>
                                                        <th>Total Paid</th>
                                                        <th>Total Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- Card-body -->
                        </div> <!-- Card -->

                    </div> <!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div> <!-- container-fluid -->
        </div> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/backend/master-reset.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '#close', function(e) {
            $('#EDITDeviceMODAL').modal('hide');
            $('#edit_wrongdeviceyname').empty();
        });
    </script>
@endsection
