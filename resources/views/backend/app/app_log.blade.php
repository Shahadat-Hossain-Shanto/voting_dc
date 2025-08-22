@extends('layouts.master')
@section('title', 'Bikroyik :: App Log')


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
                            <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> App LOG</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label for="type" class="col-form-label">Search By
                                        <span class="text-danger"><strong>*</strong></span>
                                    </label>
                                    <select class="selectpicker form-control" id="type" title="Select Model, IMEI or Date" data-live-search="true">
                                        <option value="Model">Model</option>
                                        <option value="IMEI">IMEI</option>
                                        <option value="Date">Date</option>
                                    </select>
                                </div>
                                <div class="col type" hidden>
                                    <label for="imei" class="col-form-label">Type
                                        <span class="text-danger"><strong>*</strong></span>
                                    </label>
                                    <input class="form-control" type="text" id="data" placeholder="Type IMEI" disabled>
                                </div>
                                <div class="col date" hidden>
                                    <label for="start"class="col-form-label">Start Date : </label>
                                    <span class="text-danger modelPriority"><strong>*</strong></span>
                                    <input class="form-control" type="date" id="startdate" name="start">
                                </div>

                                <div class="col date" hidden>
                                    <label for="end"class="col-form-label">End Date : </label>
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
                            <div class="row" id="dataTable" hidden >
                                <div class="pt-3">
                                    <div class="table-responsive">
                                        <table id="appLog_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Store IMEI 1</th>
                                                    <th>Store IMEI 2</th>
                                                    <th>Store Serial Number</th>
                                                    <th>Info Status (Change)</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Serial Number</th>
                                                    <th>Device Status</th>

                                                    <th>Message</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Emi Status</th>
                                                    <th>Lock</th>
                                                    <th>Immediate Lock</th>
                                                    <th>Number Of Installment</th>
                                                    <th>Last Payment</th>
                                                    <th>Total Paid</th>
                                                    <th>Next Payable</th>
                                                    <th>Next Payment Date</th>

                                                    <th>Store WIFI Mac</th>
                                                    <th>Store Bluetooth Mac</th>
                                                    <th>WIFI Mac</th>
                                                    <th>Bluetooth Mac</th>

                                                    <th>Password</th>
                                                    <th>Notification Frequency</th>
                                                    <th>Notify User Day Count</th>
                                                    <th>Api Hit After Minutes</th>
                                                    <th>Day Left To Lock</th>
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
        $("#reset").click(function (event) {
            event.preventDefault();
            $('#type').val('');
            $('#data').val('');
            $('#startdate').val('');
            $('#enddate').val('');
            $("#selectpicker").val('default');
            $("#selectpicker").selectpicker("refresh");

            location.reload();
        });

        $('#type').on('change', function () {
            $('#data').prop('disabled', false);
            $('#data').attr("placeholder", "Type "+$('#type').val());
            $('#data').val('');
            $('#startdate').val('');
            $('#enddate ').val('');

            if($('#type').val()=='Date'){
                $('.modelPriority').text('*');
                $('.type').attr("hidden", true);
                $('.date').attr("hidden", false);
            }
            else{
                $('.type').attr("hidden", false);
                $('.modelPriority').text('');
                $('.date').attr("hidden", false);
            }
        });

        $('#gen').click(function (e) {
            e.preventDefault();
            var type = $('#type').val();
            var data = $('#data').val();
            var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();

            let cheeck = 1;

            if(!type){
                $.notify('Choose Search By', {className: 'error', position: 'top right'});
                cheeck = 0;
            }
            else {
                if(type=='Date' && !startdate || type=='Date' && !enddate || type=='Date' && !startdate && !enddate ){
                    $.notify('Select Start & End '+type, {className: 'error', position: 'top right'});
                    cheeck = 0;
                }
                else if(type!='Date' && !data){
                    $.notify('Enter Valid '+type, {className: 'error', position: 'top right'});
                    cheeck = 0;
                }
            }
            if(cheeck == 1)
            {
                $('#dataTable').removeAttr('hidden');
                $('#appLog_table').DataTable().destroy();
                var t = $('#appLog_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                    ajax: {
                        "url": "/app-log-data",
                        "dataSrc": "data",
                        data: { type:type , data:data, startdate: startdate, enddate: enddate },

                    },
                    columns: [
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'date'
                        },
                        {
                            data: 'store_imei_1'
                        },
                        {
                            data: 'store_imei_2'
                        },
                        {
                            data: 'store_serial_number'
                        },
                        {
                            data: 'info_change'
                        },
                        {
                            data: 'imei_1'
                        },
                        {
                            data: 'imei_2'
                        },
                        {
                            data: 'serial_number'
                        },
                        {
                            data: 'device_status'
                        },

                        {
                            data: 'message'
                        },
                        {
                            data: 'customer_id'
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'emi_status'
                        },
                        {
                            data: 'lock'
                        },
                        {
                            data: 'immediate_lock'
                        },
                        {
                            data: 'number_of_installment'
                        },
                        {
                            data: 'last_payment'
                        },
                        {
                            data: 'total_paid'
                        },
                        {
                            data: 'next_Paybale'
                        },
                        {
                            data: 'next_payment_date'
                        },

                        {
                            data: 'store_wifi_mac'
                        },
                        {
                            data: 'store_bluetooth_mac'
                        },
                        {
                            data: 'wifi_mac'
                        },
                        {
                            data: 'bluetooth_mac'
                        },

                        {
                            data: 'Password'
                        },
                        {
                            data: 'notification_frequency'
                        },
                        {
                            data: 'notify_user_day_count'
                        },
                        {
                            data: 'hit_api_after_minutes'
                        },
                        {
                            data: 'dayslefttolock'
                        }
                    ],
                    responsive: true,
                    columnDefs: [{
                        searchable: true,
                        orderable: true,
                        targets: "_all",
                        defaultContent: "_"
                    }, ],
                    order: [
                        [1, 'desc']
                    ],
                    pageLength: 200,
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'colvis',
                            collectionLayout: 'fixed columns',
                            collectionTitle: 'Column Visibility Control'
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ],
                    lengthMenu: [
                        [5, 10, 20, 50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 1000, 10000000000],
                        [5, 10, 20, 50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 1000, "All"]
                    ],
                });
                t.on('order.dt search.dt', function () {
                    t.on('draw.dt', function () {
                        var PageInfo = $('#appLog_table').DataTable().page.info();
                        t.column(0, {
                            page: 'current'
                        }).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1 + PageInfo.start;
                        });
                    });
                }).draw();
                $('.dataTables_length').find('label').find('select').css('width', '45px');
            }
        });
   </script>
@endsection
