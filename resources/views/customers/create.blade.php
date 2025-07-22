@extends('adminlte::page')
@section('title', 'Create Customers')
@section('content_header') <h1>Create Customers</h1> @stop
@section('content')
    @include('customers.form', ['route' => route('customers.store'), 'method' => 'POST', 'customer' => null])
@stop
