@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
    <h1>Product Details</h1>
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
                    <label for="name"><strong>Product Name</strong></label>
                    <input type="text" id="name" class="form-control limited-width" value="{{ $product->name }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="product_ref_id"><strong>Product ID</strong></label>
                    <input type="text" id="product_ref_id" class="form-control limited-width" value="{{ $product->product_ref_id }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="name"><strong>Version</strong></label>
                    <input type="text" id="version" class="form-control limited-width" value="{{ $product->version }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="name"><strong>Description</strong></label>
                    <textarea id="description" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4"  disabled>{{ old('description', $product->description ?? '') }}</textarea>
                </div>


                <div class="mt-4">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
