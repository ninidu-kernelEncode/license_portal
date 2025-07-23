<form action="{{ $route }}" method="POST">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Name --}}
            <div class="form-group col-8">
                <label for="customer_name">Customer name</label>
                <input id="customer_name" name="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror"
                       value="{{ old('customer_name', $customer->customer_name ?? '') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Customer REF ID --}}
            <div class="form-group col-8">
                <label for="customer_ref_id">Customer ID</label>
                <input id="customer_ref_id" name="customer_ref_id" type="text" class="form-control @error('customer_ref_id') is-invalid @enderror"
                       value="{{ isset($customer_ref_id) ? $customer_ref_id : $customer->customer_ref_id }}" required readonly>
                @error('customer_ref_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mt-3 col-8">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $customer->email ?? '') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- company --}}
            <div class="form-group col-8">
                <label for="name">Company</label>
                <input id="company" name="company" type="text" class="form-control @error('company') is-invalid @enderror"
                       value="{{ old('company', $customer->company ?? '') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{--  Contact No --}}
            <div class="form-group col-8">
                <label for="name">Contact No</label>
                <input id="contact_number" name="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror"
                       value="{{ old('contact_number', $customer->contact_number ?? '') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            {{-- Submit --}}
            <div class="form-group d-flex user-create-submit">
                <button type="submit" class="btn btn-success submit-button">
                    {{ isset($user) ? 'Update' : 'Save' }}
                </button>
            </div>

        </div>
    </div>
</form>
