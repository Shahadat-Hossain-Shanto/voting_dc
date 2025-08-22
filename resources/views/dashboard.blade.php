@extends('layouts.master')
@section('title', 'Bikroyik :: DashBoard')
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/demo/demo.css') }}"> --}}
<style>
    .card-height {
        height: 120px;

    }
</style>

{{-- <link rel="stylesheet" href="{{ asset('css/dashboard/edmaterial-dashboard.min.css') }}"> --}}



@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                
                <div class="row mt-3">
                    <!-- Today's Devices -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-warning text-white">
                            <span class="info-box-icon bg-white text-warning elevation-1">
                                <i class="fas fa-plus-circle"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Today's Uses</strong></h6>
                                <h5 class="info-box-number" id="todayDevices">{{ $todayConsumes }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- This Month's Devices -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-danger text-white">
                            <span class="info-box-icon bg-white text-danger elevation-1">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Current Month Uses</strong></h6>
                                <h5 class="info-box-number" id="monthDevices">{{ $monthlyConsumes }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Total Devices -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-secondary text-white">
                            <span class="info-box-icon bg-white text-secondary elevation-1">
                                <i class="fas fa-hdd"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Total Uses</strong></h6>
                                <h5 class="info-box-number" id="totalDevices">{{ $totalConsumes }}</h5>
                            </div>
                        </div>
                    </div>
                    <!-- This Month's Subscriptions -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-success text-white">
                            <span class="info-box-icon bg-white text-success elevation-1">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Current Month Subscriptions</strong></h6>
                                <h5 class="info-box-number" id="monthSale">{{ $monthlySubscriptions }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subscriptions -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-info text-white">
                            <span class="info-box-icon bg-white text-info elevation-1">
                                <i class="fas fa-layer-group"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Total Subscriptions</strong></h6>
                                <h5 class="info-box-number" id="totalSale">{{ $totalSubscriptions }}</h5>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Balance -->
                    @if(auth()->check() && auth()->user()->company_id != 0 && $balance)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box text-white"style="background:#20c997;">
                            <span class="info-box-icon bg-white text-success elevation-1">
                                <i class="fas fa-wallet"></i>
                            </span>
                            <div class="info-box-content">
                                <h6 class="info-box-text mb-0"><strong>Balance</strong></h6>
                                <h5 class="info-box-number" id="totalBalance">{{ $balance->balance }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
                
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header card-header-info">
                                <h4 class="card-title"><b>Month Wise Uses</b></h4>
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
                                <canvas id="myChart0" style="width:100%;height:350px;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">Month Wise Purchased Subscription</h4>
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
                                <canvas id="myChart" style="width:100%;height:350px;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="card card-info">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">Todays Devices</h4>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="deviceTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>IMEI 1</th>
                                                <th>IMEI 2</th>
                                                <th>Serial</th>
                                                <th>Model</th>
                                                <th>Manufacturer</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Add Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script type="text/javascript" src="{{ asset('js/backend/dashboard.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="{{ asset('dist/js/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/data.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/drilldown.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/exporting.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/export-data.js') }}"></script>
    <script src="{{ asset('dist/js/highcharts/accessibility.js') }}"></script>


@endsection
