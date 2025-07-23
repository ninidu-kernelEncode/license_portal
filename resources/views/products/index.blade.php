@extends('adminlte::page')

@section('title', 'Product Management')

@section('content_header')
    <h1>Product Management</h1>
    {{ Breadcrumbs::render('products.index') }}
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

    <div class="d-flex create-user mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Create Product
        </a>
    </div>

    <div class="customer card shadow-sm">
        <div class="card-body p-0">
            <table id="product-table" class="table table-hover mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Version</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->version }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this Product?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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

@section('js')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#product-table').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true
            });
        });
    </script>
@endsection
