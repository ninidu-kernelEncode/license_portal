<form action="{{ $route }}" method="POST">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Name --}}
            <div class="form-group col-8">
                <label for="name"><i class="fas fa-user me-1 text-primary"></i> Name</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name ?? '') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mt-3 col-8">
                <label for="email"><i class="fas fa-envelope me-1 text-primary"></i> Email</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email ?? '') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mt-3 col-8">
                <label for="role">User Role</label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Password --}}
            <div class="form-group mt-3 col-8">
                <label for="password"><i class="fas fa-lock me-1 text-primary"></i> Password
                    @if(isset($user)) <small class="text-muted">(Leave blank to keep current)</small> @endif
                </label>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    {{ isset($user) ? '' : 'required' }}>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group mt-3 col-8">
                <label for="password_confirmation"><i class="fas fa-lock me-1 text-primary"></i> Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control"
                    {{ isset($user) ? '' : 'required' }}>
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
