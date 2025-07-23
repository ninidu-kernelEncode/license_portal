@extends('adminlte::page')

@section('title', 'Licenses Management')

@section('content_header')
    <h1>Licenses Management</h1>
    {{ Breadcrumbs::render('licenses.index') }}
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="customer card shadow-sm">
        <div class="card-body p-0">
            <table id="licenses-table" class="table table-hover mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>License Key</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    @foreach($customer->licenses as $license)
                        <tr>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $license->product->name ?? '-' }}</td>
                            <td>{{ $license->license_key }}</td>
                            <td>
                                    <span class="badge bg-{{ $license->status === 'Active' ? 'success' : 'secondary' }}">
                                        {{ $license->status }}
                                    </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach

                @if($customers->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">No licenses found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('js')
    {{-- DataTables JS --}}
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#licenses-table').DataTable({
                pageLength: 10,
                order: [[0, 'asc']],
                responsive: true
            });
        });
    </script>
@endsection
