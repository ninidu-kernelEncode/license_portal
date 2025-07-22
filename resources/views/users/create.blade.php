@extends('adminlte::page')
@section('title', 'Create User')
@section('content_header') <h1>Create User</h1> @stop
@section('content')
    @include('users.form', ['route' => route('users.store'), 'method' => 'POST', 'user' => null])
@stop
