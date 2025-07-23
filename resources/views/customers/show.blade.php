@extends('adminlte::page')

@section('title', 'Customer Details')

@section('content_header')
    <h1>Customer Details</h1>
    {{ Breadcrumbs::render('customers.show',$customer) }}
@stop

@section('content')
    <style>
        /* Limit input width for better visual */
        .limited-width {
            max-width: 480px;
            width: 100%;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-group mb-3">
                    <label for="name"><strong>Customer Name</strong></label>
                    <input type="text" id="name" class="form-control limited-width" value="{{ $customer->customer_name }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="customer_ref_id"><strong>Customer ID</strong></label>
                    <input type="text" id="customer_ref_id" class="form-control limited-width" value="{{ $customer->customer_ref_id }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" id="email" class="form-control limited-width" value="{{ $customer->email }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="name"><strong>Company</strong></label>
                    <input type="text" id="company" class="form-control limited-width" value="{{ $customer->company }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="name"><strong>Contact No</strong></label>
                    <input type="text" id="contact_number" class="form-control limited-width" value="{{ $customer->contact_number }}" disabled>
                </div>


                <div class="mt-4">
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
