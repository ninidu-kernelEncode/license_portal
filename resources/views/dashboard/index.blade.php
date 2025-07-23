@extends('adminlte::page')

@section('title', 'License Portal')

@section('content_header')
    <h1>Dashboard</h1>
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
@stop

@section('content')
    <div class="row g-4">
        {{-- Total Customers --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-user-friends fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total Customers</p>
                        <h4 class="mb-0 fw-semibold text-dark">{{ $totalCustomers }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-box-open fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total Products</p>
                        <h4 class="mb-0 fw-semibold text-dark">{{ $totalProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>
        {{-- Total Active Licenses --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-key fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Active Licenses</p>
                        <h4 class="mb-0 fw-semibold text-dark">{{ $totalActiveLicenses }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
