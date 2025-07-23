@extends('adminlte::page')
@section('title', 'Create Customers')
@section('content_header') <h1>Create Customers</h1>
{{ Breadcrumbs::render('customers.create') }}
@stop
@section('content')
    @include('customers.form', ['route' => route('customers.store'), 'method' => 'POST', 'customer' => null , 'customer_ref_id' => $customer_ref_id])
@stop
