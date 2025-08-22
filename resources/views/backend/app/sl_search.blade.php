@extends('layouts.master')
@section('title', 'Bikroyik :: Serial Search')


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
                            <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Serial Search</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label for="data" class="col-form-label">Type Serial Number
                                        <span class="text-danger"><strong>*</strong></span>
                                    </label>
                                    <input class="form-control" type="text" id="data" placeholder="Type Serial Number">
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
                                <div class="pt-3" id="pos_sale" hidden>
                                    <label for="pos_sale_table" class="col-form-label">Pos Sale Info</label>
                                    <div class="table-responsive">
                                        <table id="pos_sale_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Serial Number</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="pt-3" id="app_info" hidden>
                                    <label for="app_info_table" class="col-form-label">App Info</label>
                                    <div class="table-responsive">
                                        <table id="app_info_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Serial Number</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="pt-3" id="replace_sale" hidden>
                                    <label for="replace_sale_table" class="col-form-label text-xxl-center">Replace Sale Info</label>
                                    <div class="table-responsive">
                                        <table id="replace_sale_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Serial Number</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                    <th>New IMEI</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="pt-3" id="return_sale" hidden>
                                    <label for="return_sale_table" class="col-form-label">Return Sale Info</label>
                                    <div class="table-responsive">
                                        <table id="return_sale_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Serial Number</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="pt-3" id="reset_sale" hidden>
                                    <label for="reset_sale_table" class="col-form-label">Reset Sale Info</label>
                                    <div class="table-responsive">
                                        <table id="reset_sale_table" class="display table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Index</th>
                                                    <th>ACTION DATETIME</th>
                                                    <th>Serial Number</th>
                                                    <th>IMEI 1</th>
                                                    <th>IMEI 2</th>
                                                    <th>Customer ID</th>
                                                    <th>Customer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
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
            $('#data').val('');
            location.reload();
        });

        $('#gen').click(function (e) {
            e.preventDefault();

            document.getElementById("dataTable").setAttribute("hidden", "hidden");
            var data = $('#data').val();

            if(data != '')
            {
                $.ajax({
                    type: "get",
                    url: "/serial-data",
                    data: {serial_number :   data},
                    success: function (response) {
                        if(response.status==200){

                            $('#pos_sale_table tbody').empty();
                            $('#return_sale_table tbody').empty();
                            $('#reset_sale_table tbody').empty();
                            $('#app_info_table tbody').empty();
                            $('#replace_sale_table tbody').empty();

                            document.getElementById("pos_sale").setAttribute("hidden", "hidden");
                            document.getElementById("return_sale").setAttribute("hidden", "hidden");
                            document.getElementById("reset_sale").setAttribute("hidden", "hidden");
                            document.getElementById("replace_sale").setAttribute("hidden", "hidden");
                            document.getElementById("app_info").setAttribute("hidden", "hidden");

                            pos_sale        = (response.pos_sale);
                            return_sale     = (response.return_sale);
                            reset_sale      = (response.reset_sale);
                            replace_sale    = (response.replace_sale);
                            app_info        = (response.app_info);

                            if(pos_sale.length > 0){
                                count = 0;
                                pos_sale.forEach(element => {
                                    count++;
                                    let test = `
                                        <tr>
                                            <td>`+count+`</td>
                                            <td>`+element.date+`</td>
                                            <td>`+element.serial_number+`</td>
                                            <td>`+element.imei_1+`</td>
                                            <td>`+element.imei_2+`</td>
                                            <td>`+element.basic_info.customer_id+`</td>
                                            <td>`+element.basic_info.customer_name+`</td>
                                        </tr>
                                    `;
                                    $('#pos_sale_table tbody').append(test);
                                });
                                $('#pos_sale').removeAttr('hidden');
                            }

                            if(return_sale.length > 0){
                                count = 0;
                                return_sale.forEach(element => {
                                    count++;
                                    let test = `
                                        <tr>
                                            <td>`+count+`</td>
                                            <td>`+element.date+`</td>
                                            <td>`+element.serial_number+`</td>
                                            <td>`+element.imei_1+`</td>
                                            <td>`+element.imei_2+`</td>
                                            <td>`+element.customer_id+`</td>
                                            <td>`+element.customer_name+`</td>
                                        </tr>
                                    `;
                                    $('#return_sale_table tbody').append(test);
                                });
                                $('#return_sale').removeAttr('hidden');
                            }

                            if(reset_sale.length > 0){
                                count = 0;
                                reset_sale.forEach(element => {
                                    count++;
                                    let test = `
                                        <tr>
                                            <td>`+count+`</td>
                                            <td>`+element.date+`</td>
                                            <td>`+element.serial_number+`</td>
                                            <td>`+element.imei_1+`</td>
                                            <td>`+element.imei_2+`</td>
                                            <td>`+element.customer_id+`</td>
                                            <td>`+element.customer_name+`</td>
                                        </tr>
                                    `;
                                    $('#reset_sale_table tbody').append(test);
                                });
                                $('#reset_sale').removeAttr('hidden');
                            }

                            if(app_info.length > 0){
                                count = 0;
                                app_info.forEach(element => {
                                    count++;
                                    let test = `
                                        <tr>
                                            <td>`+count+`</td>
                                            <td>`+element.date+`</td>
                                            <td>`+element.serial_number+`</td>
                                            <td>`+element.imei_1+`</td>
                                            <td>`+element.imei_2+`</td>
                                            <td>`+element.app_get_info.customer_id+`</td>
                                            <td>`+element.app_get_info.customer_name+`</td>
                                        </tr>
                                    `;
                                    $('#app_info_table tbody').append(test);
                                });
                                $('#app_info').removeAttr('hidden');
                            }

                            if(replace_sale.length > 0){
                                count = 0;
                                replace_sale.forEach(element => {
                                    count++;
                                    let test = `
                                        <tr>
                                            <td>`+count+`</td>
                                            <td>`+element.date+`</td>
                                            <td>`+element.old_serial_number+`</td>
                                            <td>`+element.old_imei_1+`</td>
                                            <td>`+element.old_imei_2+`</td>
                                            <td>`+element.basic_info.customer_id+`</td>
                                            <td>`+element.basic_info.customer_name+`</td>
                                            <td>`+element.new_imei+`</td>
                                        </tr>
                                    `;
                                    $('#replace_sale_table tbody').append(test);
                                });
                                $('#replace_sale').removeAttr('hidden');
                            }
                        }
                    }
                });
                $('#dataTable').removeAttr('hidden');
            }
        });
   </script>
@endsection
