@extends('adminlte::page')

@section('title', 'Roles & Permissions Management')

@section('content_header')
    <h1>Roles</h1>
    {{ Breadcrumbs::render('roles.index') }}
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
    <div class="d-flex role-create">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Role
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Permissions Count</th>
                    <th>Created At</th>
                    <th style="width: 130px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ ucfirst($role->name) }}</td>
                        <td>{{ $role->permissions->count() }}</td>
                        <td>{{ $role->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning" title="Edit Role">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Delete Role"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No roles found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
