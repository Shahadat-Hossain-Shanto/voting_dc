@extends('layouts.master')
@section('title', 'Bikroyik :: Location History')

<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

@section('content')
    <div class="container">
        <h3>Location History Report</h3>

        <div class="row">
            <div class="col-md-3">
                <label>IMEI Number:</label>
                <input type="text" id="imei" class="form-control" placeholder="Enter IMEI">
            </div>
            <div class="col-md-3">
                <label>Start Date:</label>
                <input type="date" id="start_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>End Date:</label>
                <input type="date" id="end_date" class="form-control">
            </div>
            <div class="col-md-3 mt-4">
                <button id="filter" class="btn btn-primary">Filter</button>
                <button id="reset" class="btn btn-secondary">Reset</button>
            </div>
        </div>

        <table id="locationHistoryTable" class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMEI</th>
                    <th>Location</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Date</th>
                </tr>
            </thead>
        </table>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

        <script>
        $(document).ready(function() {
            let table = new DataTable('#locationHistoryTable', {
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('location.data') }}",
                    type: "GET",  // Ensure GET request is used
                    data: function(d) {
                        d.imei = $('#imei').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        console.log("Data Sent to Server:", d); // Debugging
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'imei_1', name: 'imei_1' },
                    { data: 'location', name: 'location' },
                    { data: 'latitude', name: 'latitude' },
                    { data: 'longitude', name: 'longitude' }
                    { data: 'formatted_date', name: 'formatted_date' }
                ]
            });

            $('#filter').on('click', function() {
                console.log('Filter button clicked!');
                table.ajax.reload(null, false); // Reload without resetting pagination
            });

            $('#reset').on('click', function() {
                console.log('Reset button clicked!');
                $('#imei').val('');
                $('#start_date').val('');
                $('#end_date').val('');
                table.ajax.reload(null, false);
            });
        });
        </script>
    @endpush

@endsection
