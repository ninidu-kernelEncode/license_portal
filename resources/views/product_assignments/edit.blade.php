@extends('adminlte::page')
@section('title', 'Create Product Assignment')
@section('content_header') <h1>Edit Product Assignment</h1> @stop
@section('content')
    <form action="{{  route('product_assignments.update',$assignment->assignment_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card shadow-sm">
            <div class="card-body">


                <div class="form-group mt-3 col-6">
                    <label for="customer_id">Customer</label>
                        <input class="form-control" type="text" id="customer_name" value="{{ $customer->customer_name  }}" readonly>
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->customer_id  }}">
                    </div>

                <div class="form-group   mt-3 col-6">
                    <label for="product_id">Product</label>
                    <input class="form-control" type="text" id="name" value="{{ $product->name  }}" readonly>
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->product_id  }}">
                </div>

                {{-- License Section --}}
                <div class="license-section border rounded p-3 mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">License</h5>
                        @if ($license)
                            <button type="button" id="toggle-license" class="btn btn-outline-secondary btn-sm">
                                Update License
                            </button>
                        @else
                            <button type="button" id="toggle-license" class="btn btn-outline-primary btn-sm">
                                Create License
                            </button>
                        @endif
                    </div>

                    {{-- Show existing license info --}}
                    @if ($license)
                        <div id="existing-license" class="mb-3">
                            <p><strong>Key:</strong> {{ $license->license_key }}</p>
                            <p><strong>Algorithm:</strong> {{ $license->hash_algorithm }}</p>
                            <p><strong>Valid:</strong> {{ $license->start_date }} to {{ $license->end_date }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-{{ $license->status === 'Active' ? 'success' : 'secondary' }}">{{ $license->status }}</span></p>
                            @if ($license->status != 'Revoked')
                            <div class="d-flex gap-2 mt-2">
                                <form method="POST" action="{{ route('product_assignments.destroy', $license->license_id) }}"
                                      onsubmit="return confirm('Revoke this license?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Revoke</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @endif

                    {{-- License Fields (hidden by default or shown if updating/creating) --}}
                    <div id="license-fields" class="row g-3 d-none">
                        <input type="hidden" name="isLicenseCreate" id="isLicenseCreate" >
                        <input type="hidden"  id="isHasLicense" value="{{ !$license ? 0 : 1 }}">
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
                        Update
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
            let haslicense =  $('#isHasLicense').val();
            let licenseEnabled = false;
            // $('#customer_id').on('change', function () {
            //     const customerId = $(this).val();
            //     const productSelect = $('#product_id');
            //
            //     productSelect.empty().append('<option value="">Loading...</option>');
            //
            //     if (customerId) {
            //         $.ajax({
            //             url: `/unassigned-products/${customerId}`,
            //             type: 'GET',
            //             success: function (products) {
            //                 productSelect.empty();
            //                 if (products.length > 0) {
            //                     productSelect.append('<option value="">-- Select Product --</option>');
            //                     $.each(products, function (index, product) {
            //                         productSelect.append(`<option value="${product.product_id}">${product.name}</option>`);
            //                     });
            //                 } else {
            //                     productSelect.append('<option value="">No unassigned products found.</option>');
            //                 }
            //             },
            //             error: function () {
            //                 productSelect.empty().append('<option value="">Error loading products</option>');
            //             }
            //         });
            //     } else {
            //         productSelect.empty().append('<option value="">-- Select a customer first --</option>');
            //     }
            // });
            $('#toggle-license').on('click', function () {
                licenseEnabled = !licenseEnabled;

                if (licenseEnabled) {
                    $('#license-fields').removeClass('d-none');

                    if( haslicense == 0 ){
                        $(this).text('Create Later');
                    }else{
                        $(this).text('Update Later');
                    }

                    // Add required attributes
                    $('#hash_algorithm').attr('required', true);
                    $('#start_date').attr('required', true);
                    $('#end_date').attr('required', true);
                    $('#isLicenseCreate').val(1);
                } else {
                    $('#license-fields').addClass('d-none');

                    if( haslicense == 0 ){
                        $(this).text('Create License');
                    }else{
                        $(this).text('Update License');
                    }
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
