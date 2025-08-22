@extends('layouts.master')
@section('title', 'Bikroyik :: Defaulter List')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </div> <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Defaulter </strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="row container-fluid">
                                <div class="col-lg-3 col-md-6 col-sm-6" id="totalDefaulters" hidden>
                                    <div class="card card-stats card-height">
                                        <div class="card-header card-header-warning card-header-icon">
                                            <div class="card-icon">
                                                <i class="fas fa-duotone fa-mobile nav-icon"></i>
                                            </div>
                                            <p class="card-category">Total Defaulter</p>
                                            <h3 class="card-title"id="total_Defaulters"></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row col-lg-9 col-md-6 col-sm-6">
                                    <div class="col">
                                        <label for="type" class="col-form-label">Search By
                                            <span class="text-danger"><strong>*</strong></span>
                                        </label>
                                        <select class="selectpicker form-control" id="type" title="Select Retail or Model" data-live-search="true">
                                            <option value="Plaza">Retail</option>
                                            <option value="Model">Model</option>
                                        </select>
                                    </div>
                                    <div class="col type" hidden>
                                        <div class="dropdown" style="margin-top: 38px">
                                            <button onclick="toggleDropdown()" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Options</button>
                                            <div id="option" class="dropdown-content form-check">
                                            </div>
                                        </div>
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
                                        <table id="unpaid_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Number</th>
                                                    <th>Retail Id</th>
                                                    <th>Retail Name</th>
                                                    <th>Defaulted Amount</th>
                                                    <th>Defaulted Date</th>
                                                    <th>Defaulted Days</th>
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
            </div> <!-- container-fluid -->
        </div> <!-- /.content -->
    </div> <!-- /.content-wrapper -->

    <!-- Print Modal -->
    <div class="modal fade bd-example-modal-xl" id="PRINTEMIMODAL" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-body">
                <div class="m-5">
                    <h3 class="mt-4"><b>Device Info : </b></h3>
                    <div class="table-responsive">
                        <table id="device_info_table" class="display table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Index</th>
                                    <th>Model</th>
                                    <th>IMEI 1</th>
                                    <th>IMEI 2</th>
                                    <th>Serial Number</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- END Print Modal -->
@endsection

@section('script')
    <style>
        #option {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            width: 100%
        }

        .dropdown button{
            width: 100%
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            width: inherit;
            overflow-y: auto;
            height: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content label {
            display: block;
            padding: 5px 10px;
            cursor: pointer;
        }

        .dropdown-content label:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
        .dark-mode .dropdown-content{
            background-color:#2b2b2b;
            color: rgb(220, 220, 220);
        }
        .dark-mode .dropdown-content label:hover{
            background-color: #3a3a3a;
        }
    </style>
    <script type="text/javascript" src="{{ asset('js/backend/report.js') }}"></script>
@endsection
