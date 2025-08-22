@extends('layouts.master')
@section('title', 'Bikroyik :: Replaced Devices')

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
                                <h5 class="m-0"><strong><i class="fas fa-clipboard-list"></i> Replaced Devices</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="row container-fluid">
                                    <div class="col-lg-3 col-md-6 col-sm-6" id="totalReplaced" hidden>
                                        <div class="card card-stats card-height">
                                            <div class="card-header card-header-warning card-header-icon">
                                                <div class="card-icon">
                                                    <i class="fas fa-duotone fa-mobile nav-icon"></i>
                                                </div>
                                                <p class="card-category">Total Replaced Devices</p>
                                                <h3 class="card-title"id="total_replaced"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-9 col-md-6 col-sm-6">
                                        <div class="col">
                                            <label for="type" class="col-form-label">Search By
                                                <span class="text-danger"><strong>*</strong></span>
                                            </label>
                                            <select class="selectpicker form-control" id="type" title="Select Retail, Customer Id, IMEI or Date" data-live-search="true">
                                                <option value="Retail">Retail</option>
                                                <option value="Customer Id">Customer Id</option>
                                                <option value="IMEI">IMEI</option>
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
                                            <table id="emi_table" class="display table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Index</th>
                                                        <th>Approval Date</th>
                                                        <th>Customer Id</th>
                                                        <th>Customer Name</th>
                                                        <th>Customer NID</th>
                                                        <th>Customer Mobile</th>
                                                        <th>Retail Id</th>
                                                        <th>Retail Name</th>
                                                        <th>New IMEI 1</th>
                                                        <th>New IMEI 2</th>
                                                        <th>New Model</th>
                                                        <th>Old IMEI 1</th>
                                                        <th>Old IMEI 2</th>
                                                        <th>Old Model</th>
                                                        <th>Branch Manager ID</th>
                                                        <th>Branch Manager Name</th>
                                                        <th>CMS ID</th>
                                                        <th>CMS Name</th>
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

    <!-- Print Modal -->
    <div class="modal fade bd-example-modal-xl" id="PRINTEMIMODAL" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-body"  id="printData">
                <div class="m-20">
                    <h1><b><center>Sale Receipt</center></b></h1>
                    <h3><b><center id="plaza_name"></center></b></h3>
                    <h5><b><center>Retail Id : <span id="plaza_id"></span></center></b></h5>

                    <div class="mt-2">
                        <table id="sales_info_table" class="display table table-borderless" class="align-middle" width="100%">
                            <tbody>
                                <tr>
                                    <td><b>Sales Person Id : </b><span id="sales_by"></span></td>
                                    <td class="text-end"><b>Date : </b><span id="date"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Sales Person name : </b><span id="sales_person_name"></span></td>
                                </tr>
                                <tr>
                                    <td><b>POS Invoice Number : </b><span id="pos_invoice_number"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <table id="customer_info_table" class="display table table-bordered" class="align-middle" width="100%">
                            <thead>
                                <tr>
                                    <th>Customer Id</th>
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Customer NID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span id="customer_id"></span></td>
                                    <td><span id="customer_name"></span></td>
                                    <td><span id="customer_mobile"></span></td>
                                    <td><span id="customer_nid"></span></td>
                                </tr>
                                <tr>
                                    <th>Customer Addess : </th>
                                    <td colspan="3"><span id="customer_address"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-6">
                            <h3><b>Mobile Information : </b></h3>
                            <div class="row pt-2">
                                <div class="col-6 pt-2">
                                    <label>Brand : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="brand" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Model : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="model" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Color : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="color" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Barcode : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="barcode" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Serial Number : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="serial_number" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>IMEI 1 : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="imei_1" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>IMEI 2 : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="imei_2" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3><b>Hire Sale Information : </b></h3>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Price(Tk) : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="hire_sale_price" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Number of Installment : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="number_of_installment" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Installment Completed : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="number_of_installment_complete" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Down Payment Date : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="down_payment_date" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Down Payment Amount(Tk) : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="down_payment" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Total Payment Amount(Tk) : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="total_payment" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>Total Due Amount(Tk) : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="total_due" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pt-2">
                                    <label>EMI Status : </label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="emi_status" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-4"><b>EMI Schedules : </b></h3>
                    <div class="table-responsive">
                        <table id="emi_schedules_table" class="display table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Installment Number</th>
                                    <th>Installment Date</th>
                                    <th>Installment Amount(Tk)</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <br>
                    <h3 class="mt-4"><b>Payments : </b></h3>
                    <div class="table-responsive">
                        <table id="payments_table" class="display table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>POS Invoice Number</th>
                                    <th>Payment Date</th>
                                    <th>Payment Amount(Tk)</th>
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

    <!-- Installment Modal -->
    <div class="modal fade bd-example-modal-xl" id="INSTALLMENTMODAL" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="m-5">
                    <h3 class="mt-4"><b>EMI Schedules : </b></h3>
                    <div class="table-responsive">
                        <table id="installment_emi_schedules_table" class="display table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Installment Number</th>
                                    <th>Installment Date</th>
                                    <th>Installment Amount</th>
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
    <!-- END Installment Modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/backend/replaced-devices.js') }}"></script>
@endsection
