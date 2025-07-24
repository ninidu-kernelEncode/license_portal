<form action="{{ $route }}" method="POST">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Name --}}
            <div class="form-group col-8">
                <label for="name">Product name</label> <span class="text-danger">*</span>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name ?? '') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Customer REF ID --}}
            <div class="form-group col-8">
                <label for="product_ref_id">Product ID</label> <span class="text-danger">*</span>
                <input id="product_ref_id" name="product_ref_id" type="text" class="form-control @error('product_ref_id') is-invalid @enderror"
                       value="{{ isset($product_ref_id) ? $product_ref_id : $product->product_ref_id }}" required readonly>
                @error('product_ref_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Version --}}
            <div class="form-group col-8">
                <label for="version">version</label> <span class="text-danger">*</span>
                <input id="version" name="version" type="text" class="form-control @error('version') is-invalid @enderror"
                       value="{{ old('version', $product->version ?? '') }}" required>
                @error('version') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            {{-- Description --}}
            <div class="form-group col-8">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Submit --}}
            <div class="form-group d-flex user-create-submit">
                <button type="submit" class="btn btn-success submit-button">
                    {{ isset($product) ? 'Update' : 'Save' }}
                </button>
            </div>

        </div>
    </div>
</form>
