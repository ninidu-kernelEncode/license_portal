<form action="{{ $route }}" method="POST">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Name --}}
            <div class="form-group col-8">
                <label for="name"><i class="fas fa-user me-1 text-primary"></i> Product name</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name ?? '') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            {{-- Name --}}
            <div class="form-group col-8">
                <label for="version"><i class="fas fa-user me-1 text-primary"></i>version</label>
                <input id="version" name="version" type="text" class="form-control @error('version') is-invalid @enderror"
                       value="{{ old('version', $product->version ?? '') }}" required>
                @error('version') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            {{-- Description --}}
            <div class="form-group col-8">
                <label for="description"><i class="fas fa-align-left me-1 text-primary"></i> Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
