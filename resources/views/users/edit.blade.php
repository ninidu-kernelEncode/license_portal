@extends('adminlte::page')
@section('title', 'Edit User')
@section('content_header') <h1>Edit User</h1> @stop
@section('content')
    @include('users.form', ['route' => route('users.update', $user), 'method' => 'PUT', 'user' => $user])
@stop
