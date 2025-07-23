@extends('adminlte::page')

@section('title', 'Product Assignments')

@section('content_header')
    <h1>Product Assignments</h1>
    {{ Breadcrumbs::render('product_assignments.index') }}
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

    <div class="create-assignment d-flex">
    <a href="{{ route('product_assignments.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Assign Product
    </a>
    </div>

    <div class="card create-assignment-card">
        <div class="card-body table-responsive">

            <table class="table table-hover mb-0 product-assign">
                <thead class="table-dark">
                <tr>
                    <th>Customer Name</th>
                    <th>Assigned Products</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($assignments as $customer)
                    <tr>
                        <td>{{ $customer->customer_name }}</td>
                        <td>
                            @foreach($customer->assignments as $assignment)
                                <a href="{{ route('product_assignments.edit', $assignment->assignment_id) }}" class="badge bg-info text-white">
                                    {{ $assignment->product->name }}
                                </a>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('product_assignments.show', $customer->customer_ref_id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            const table = $('.product-assign').DataTable();

            const customerFilter = $('<select id="customerFilter" class="form-select form-select-sm ms-2"><option value="">All Customers</option></select>');
            const productFilter = $('<select id="productFilter" class="form-select form-select-sm ms-2"><option value="">All Products</option></select>');

            @foreach($assignments as $customer)
            customerFilter.append(`<option value="{{ $customer->customer_name }}">{{ $customer->customer_name }}</option>`);
            @endforeach

            @foreach($products as $product)
            productFilter.append(`<option value="{{ $product->name }}">{{ $product->name }}</option>`);
            @endforeach

            $('.dataTables_length').after(
                $('<div class="d-flex gap-3 mt-2 mb-2 ms-1"></div>').append(customerFilter, productFilter)
            );

            customerFilter.on('change', function () {
                table.column(0).search(this.value).draw();
            });

            productFilter.on('change', function () {
                table.column(1).search(this.value).draw();
            });
        });
    </script>
@endpush
