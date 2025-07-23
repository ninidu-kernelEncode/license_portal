@extends('adminlte::page')
@section('title', 'Create Products')
@section('content_header') <h1>Create Products</h1>
{{ Breadcrumbs::render('products.create') }}
@stop
@section('content')
    @include('products.form', ['route' => route('products.store'), 'method' => 'POST','product' => null , 'product_ref_id' => $product_ref_id ])
@stop
