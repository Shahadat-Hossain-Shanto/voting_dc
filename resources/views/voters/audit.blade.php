@extends('layouts.master')
@section('title', 'Voters')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
    </div>

    <div class="content">
        <div class="">
            <div class="card card-primary">
                <div class="card-header d-flex justify-content-between" style="height: 49px;">
                    <h5><strong><i class="fas fa-list"></i> Voter List</strong></h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="voterTable" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voter Number</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>President</th>
                                    <th>Secretary</th>
                                    <th>Status</th>
                                    <th>&nbsp;Actions&nbsp;&nbsp;&nbsp;</th>
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
        $('#voterTable').DataTable({
            ajax: {
            url: '{{ route('voter.data') }}',
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
            { data: 'voter_number' },
            { data: 'name' },
            { data: 'mobile_number' },
            { data: 'email' },
            { data: 'president_name' },
            { data: 'secretary_name' },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (data == 1) {
                        return `<span style="background-color: green; color: white; padding: 5px; border-radius: 5px;">Voted</span>`;
                    } else {
                        return `<span style="background-color: red; color: white; padding: 5px; border-radius: 5px;">Pending</span>`;
                    }
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button onclick="changeStatus(${row.id})" class="btn btn-success btn-sm">
                            <i class="fas fa-check-circle"></i>
                        </button>
                    `;
                },
                orderable: false,
                searchable: false
            }
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
