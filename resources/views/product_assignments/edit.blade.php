@extends('adminlte::page')
@section('title', 'Edit Product Assignment')
@section('content_header') <h1>Edit Product Assignment</h1>
{{ Breadcrumbs::render('product_assignments.edit',$assignment) }}
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
    <form action="{{  route('product_assignments.update',$assignment->assignment_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card shadow-sm">
            <div class="card-body">


                <div class="form-group mt-3 col-6">
                    <label for="customer_ref_id">Customer</label>
                        <input class="form-control" type="text" id="customer_name" value="{{ $customer->customer_name  }}" readonly>
                        <input type="hidden" name="customer_ref_id" id="customer_ref_id" value="{{ $customer->customer_ref_id  }}">
                    </div>

                <div class="form-group   mt-3 col-6">
                    <label for="product_ref_id">Product</label>
                    <input class="form-control" type="text" id="name" value="{{ $product->name  }}" readonly>
                    <input type="hidden" name="product_ref_id" id="product_ref_id" value="{{ $product->product_ref_id  }}">
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
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm revoke-license"
                                    data-license-id="{{ $license->license_id }}"
                                >
                                    Revoke
                                </button>
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
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '3000',
            extendedTimeOut: '1000'
        };
        $(document).ready(function () {
            $('#isLicenseCreate').val(0);
            let haslicense =  $('#isHasLicense').val();
            let licenseEnabled = false;
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

            $('.revoke-license').on('click', function () {
                if (!confirm('Are you sure you want to revoke this license?')) return;

                let licenseId = $(this).data('license-id');

                $.ajax({
                    url: `/licenses/${licenseId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success('License revoked successfully!');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        alert('Failed to revoke license.');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
