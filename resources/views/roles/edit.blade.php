@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    <h1>Edit Role</h1>
    {{ Breadcrumbs::render('roles.edit',$role) }}
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="roleName" class="form-label">Role Name</label>
            <input type="text" id="roleName" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
            @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <h5>Permissions</h5>
        <div class="accordion" id="permissionsAccordion">
            @foreach($permissions as $module => $perms)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $module }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $module }}" aria-expanded="false" aria-controls="collapse-{{ $module }}">
                            {{ ucfirst($module) }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $module }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $module }}" data-bs-parent="#permissionsAccordion">
                        <div class="accordion-body">
                            @foreach($perms as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" id="perm-{{ $permission->id }}" name="permissions[]"
                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm-{{ $permission->id }}">
                                        {{ ucfirst(str_replace('.', ' ', $permission->name)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Changes</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
@stop
