@extends('layouts.master')
@section('title', 'Presidents')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
    </div>

    <div class="content">
        <div class="">
            <div class="card card-primary">
                <div class="card-header d-flex justify-content-between" style="height: 49px;">
                    <h5><strong><i class="fas fa-list"></i> President Candidate List</strong></h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="secretaryTable" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Candidate Number</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Vote Counting</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#secretaryTable').DataTable({
            ajax: {
            url: '{{ route('president.data') }}',
            dataSrc: 'data'
            },
            responsive: true,
            columns: [
            {
                data: null,
                render: function(data, type, row, meta) {
                return meta.row + 1; // Add row number
                }
            },
            { data: 'candidate_number' },
            { data: 'name' },
            { data: 'mobile_number' },
            { data: 'email' },
            { data: 'counting' }
            ]
        });

        // Auto-hide alerts
        const alertBox = document.querySelector('.alert-dismissible');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add('fade');
                alertBox.style.display = 'none';
            }, 3000); // 3 seconds
        }
    });
    function changeStatus(id) {
            if (confirm('Mark this voter request as checked?')) {
                fetch(`/voter/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: '1' })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Failed to change status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.');
                });
            }
        }
</script>

<style>
    #voterTable_filter{
        margin-right: 10px;
    }
</style>
@endsection
