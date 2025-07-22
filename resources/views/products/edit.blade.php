@extends('adminlte::page')
@section('title', 'Edit Product')
@section('content_header') <h1>Edit Product</h1> @stop
@section('content')
    @include('products.form', ['route' => route('products.update', $product), 'method' => 'PUT', 'product' => $product])
@stop
