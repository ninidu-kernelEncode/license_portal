@extends('adminlte::page')
@section('title', 'Product Assignment Details')
@section('content_header') <h1>Product Assignment Details</h1> @stop
@section('content')
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="customer-name form-group mt-3 col-6">
                    <h4>{{ $customer->customer_name }}</h4>
                </div>

                @foreach ($productLicenses as $item)
                    <div class="license-card-show card mb-3">
                        <div class="card-header">
                            <strong>Product:</strong> {{ $item['product']->name ?? 'N/A' }}
                        </div>
                        <div class="card-body">
                            @if ($item['license'])
                                <p><strong>License Key:</strong> {{ $item['license']->license_key }}</p>
                                <p><strong>Algorithm:</strong> {{ $item['license']->hash_algorithm }}</p>
                                <p><strong>Valid:</strong> {{ $item['license']->start_date }} to {{ $item['license']->end_date }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $item['license']->status === 'Active' ? 'success' : 'secondary' }}">
                        {{ $item['license']->status }}
                    </span>
                                </p>
                            @else
                                <p class="text-muted">No license found for this product.</p>
                            @endif
                        </div>
                    </div>
                @endforeach

        </div>
@endsection
