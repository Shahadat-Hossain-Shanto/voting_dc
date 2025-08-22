@extends('layouts.master')
@section('title', 'Emi')
<link rel="stylesheet" href="{{ asset('css/bootstrap/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/demo/demo.css') }}">
<style>
    .card-height {
        height: 120px;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard/edmaterial-dashboard.min.css') }}">



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
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats card-height">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <p class="card-category">Total Device</p>
                                <h3 class="card-title">{{ $totalDevice }}

                                </h3>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-height card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <p class="card-category">Total EMI Active</p>
                                <h3 class="card-title">{{ $totalActiveEmi }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-danger card-header-icon card-height">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <h3 class="card-category">Total EMI Paid</h3>
                                <h3 class="card-title">{{ $totalInActiveEmi }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon card-height">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <p class="card-category">Total Sale</p>
                                <h3 class="card-title">{{ $totalSale }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon card-height">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <p class="card-category">Total Collect Amount</p>
                                <h3 class="card-title">{{ $totalPaid }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon card-height">
                                <div class="card-icon">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                </div>
                                <p class="card-category">Total Due Amount</p>
                                <h3 class="card-title">{{ $totalDue }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header   card-height">

                                <h5 class="card-text">Current Month</h5>
                                <h6 class="card-text">Sales : {{ $currentMonthTotalSale }}</h6>
                                <h6 class="card-text">Collect :{{ $currentMonthTotalCollect }} </h6>
                                <h6 class="card-text">Due: </h6>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">List of EMI Paid Device(Current Month)</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="paid_table" class="table table-hover" width="100%">
                                    <thead class="text-info">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>IMEI</th>
                                            <th>Amount</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">List of Defaulter Device(Current Month)</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="unpaid_table" class="table table-hover" width="100%">
                                    <thead class="text-info">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>IMEI</th>
                                            <th>Last Payment Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart" style="height: 400px; width: 100%;">
                                    <!-- <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
                                    <figure class="highcharts-figure">
                                        <div id="container1"></div>
                                        <p class="highcharts-description">

                                        </p>
                                    </figure>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart" style="height: 400px; width: 100%;">
                                    <!-- <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
                                    <figure class="highcharts-figure">
                                        <div id="container2"></div>
                                        <p class="highcharts-description">

                                        </p>
                                    </figure>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- /.content -->
    </div> <!-- /.content-wrapper -->

    

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/backend/dashboard.js') }}"></script>

    <script src="{{ asset('dist/js/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/data.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/drilldown.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/exporting.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/export-data.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/accessibility.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#myModal").modal('show');
        });

        $(document).on('click', '#noted', function(e) {

            e.preventDefault()
            $("#myModal").modal('hide');
        });
    </script>
@endsection
