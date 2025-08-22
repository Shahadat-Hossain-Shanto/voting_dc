@extends('layouts.master')
@section('title', 'Bikroyik :: User Activity List')


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
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> USER ACTIVITY LOG</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">

                                    <label for="start"class="col-form-label">IMEI : </label>
                                    <span class="text-danger modelPriority"><strong>*</strong></span>
                                    <input class="form-control" type="text" id="imei" name="imei">
                                </div>

                                {{-- <div class="col-md-3">
                                    <label for="end"class="col-form-label">End date:</label>
                                    <span class="text-danger modelPriority"><strong>*</strong></span>
                                    <input class="form-control" type="date" id="enddate" name="end">

                                </div> --}}
                                <div class="col pt-9" id="generateBtn">
                                    <button type="submit" class="btn btn-primary" id="gen"class="gen-button">
                                        Generate
                                    </button>

                                </div>

                            </div>
                            <div class="row" id="dataTable" hidden >
                                <div class="pt-3">
                                    <div class="table-responsive">
                                        <table id="activitylog_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>

                                                    <th>USER</th>
                                                    <th>ACTIVITY</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>ACTION DATETIME</th>

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







@endsection

@section('script')
   <script>
    $('#gen').click(function (e) {
        e.preventDefault();


        var imei = $('#imei').val();

        if(imei )
        {
            $('#dataTable').removeAttr('hidden');
            $('#activitylog_table').DataTable().destroy();
            var t = $('#activitylog_table').DataTable({

            ajax: {
                "url": "/activitylog-data",
                "dataSrc": "data",
                data: { imei: imei },

            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'activity'
                },
                {
                    data: 'imei_1'
                },
                {
                    data: 'imei_2'
                },
                {
                    data: 'date'

                },

            ],
            responsive: true,
            columnDefs: [{
                searchable: true,
                orderable: true,
                // targets: "_all",
                defaultContent: "_"
            }, ],
            order: [
                [5, 'desc']
            ],
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20],
                [5, 10, 20]
            ],

            });
            t.on('order.dt search.dt', function () {
            t.on('draw.dt', function () {
                var PageInfo = $('#activitylog_table').DataTable().page.info();
                t.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

            }).draw();
        }
     });















   </script>

@endsection
