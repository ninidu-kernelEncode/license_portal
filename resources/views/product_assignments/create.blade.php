@extends('adminlte::page')
@section('title', 'Create Product Assignment')
@section('content_header') <h1>Create Product Assignment</h1> @stop
@section('content')
    <form action="{{  route('product_assignments.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="form-group col-6">
                    <label for="customer_ref_id">Customer</label>
                    <select name="customer_ref_id" id="customer_ref_id" class="form-control @error('customer_ref_id') is-invalid @enderror"  required>
                        <option value="">-- Select Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_ref_id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                    @error('customer_ref_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mt-3 col-6">
                    <label for="product_ref_id">Product</label>
                    <select name="product_ref_id" id="product_ref_id" class="form-control @error('product_ref_id') is-invalid @enderror" required>
                        <option value="">-- Select a product first --</option>
                    </select>
                    @error('product_ref_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- License Section --}}
                <div class="license-section border rounded p-3 mt-4">
                    <input type="hidden" name="isLicenseCreate" id="isLicenseCreate" class="isLicenseCreate">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Add License</h5>
                        <button type="button" id="toggle-license" class="btn btn-outline-primary btn-sm">
                            Create License
                        </button>
                    </div>

                    {{-- License Fields --}}
                    <div id="license-fields" class="row g-3 d-none">
                        <div class="col-md-4">
                            <label for="hash_algorithm" class="form-label">Hash Algorithm</label>
                            <select id="hash_algorithm" name="hash_algorithm" class="form-control">
                                <option value="">-- Select Algorithm --</option>
                                <option value="SHA256">SHA256</option>
                                <option value="MD5">MD5</option>
                                <option value="HMAC-SHA256">HMAC-SHA256</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="form-group d-flex user-create-submit">
                    <button type="submit" class="btn btn-success submit-button">
                       Save
                    </button>
                </div>

            </div>

        </div>
    </form>
@endsection
    @section('js')
        <script>
            $(document).ready(function () {
                $('#isLicenseCreate').val(0);
                let licenseEnabled = false;
                $('#customer_ref_id').on('change', function () {
                    const customerId = $(this).val();
                    const productSelect = $('#product_ref_id');

                    productSelect.empty().append('<option value="">Loading...</option>');

                    if (customerId) {
                        $.ajax({
                            url: `/unassigned-products/${customerId}`,
                            type: 'GET',
                            success: function (products) {
                                productSelect.empty();
                                if (products.length > 0) {
                                    productSelect.append('<option value="">-- Select Product --</option>');
                                    $.each(products, function (index, product) {
                                        productSelect.append(`<option value="${product.product_ref_id}">${product.name}</option>`);
                                    });
                                } else {
                                    productSelect.append('<option value="">No unassigned products found.</option>');
                                }
                            },
                            error: function () {
                                productSelect.empty().append('<option value="">Error loading products</option>');
                            }
                        });
                    } else {
                        productSelect.empty().append('<option value="">-- Select a customer first --</option>');
                    }
                });
                $('#toggle-license').on('click', function () {
                    licenseEnabled = !licenseEnabled;

                    if (licenseEnabled) {
                        $('#license-fields').removeClass('d-none');
                        $(this).text('Create Later');

                        // Add required attributes
                        $('#hash_algorithm').attr('required', true);
                        $('#start_date').attr('required', true);
                        $('#end_date').attr('required', true);
                        $('#isLicenseCreate').val(1);
                    } else {
                        $('#license-fields').addClass('d-none');
                        $(this).text('Create License');

                        // Remove required attributes
                        $('#hash_algorithm').removeAttr('required');
                        $('#start_date').removeAttr('required');
                        $('#end_date').removeAttr('required');

                        // Optional: clear field values
                        $('#hash_algorithm').val('');
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $('#isLicenseCreate').val(0);
                    }
                });
            });
        </script>
    @endsection
