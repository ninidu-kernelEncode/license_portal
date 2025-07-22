@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <style>
        /* Limit input width for better visual */
        .limited-width {
            max-width: 480px;
            width: 100%;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-group mb-3">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" id="name" class="form-control limited-width" value="{{ $user->name }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" id="email" class="form-control limited-width" value="{{ $user->email }}" disabled>
                </div>

                @if($user->roles->count())
                    <div class="form-group mb-3">
                        <label for="roles"><strong>Role{{ $user->roles->count() > 1 ? 's' : '' }}</strong></label>
                        <input type="text" id="roles" class="form-control limited-width" value="{{ $user->roles->pluck('name')->join(', ') }}" disabled>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
