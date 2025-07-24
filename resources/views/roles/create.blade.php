@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
    <h1>Create Role</h1>
    {{ Breadcrumbs::render('roles.create') }}
@stop

@section('content')
    <form action="{{ route('roles.store') }}" method="POST" id="roleCreateForm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label> <span class="text-danger">*</span>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
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
                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}">
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

        <button type="submit" class="btn btn-success mt-3">Create Role</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
@stop
