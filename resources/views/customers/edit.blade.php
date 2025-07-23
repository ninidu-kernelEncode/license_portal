@extends('adminlte::page')
@section('title', 'Edit Customer')
@section('content_header') <h1>Edit Customer</h1>
{{ Breadcrumbs::render('customers.edit',$customer) }}
@stop
@section('content')
    @include('customers.form', ['route' => route('customers.update', $customer), 'method' => 'PUT', 'customer' => $customer])
@stop
