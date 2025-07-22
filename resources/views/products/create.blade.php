@extends('adminlte::page')
@section('title', 'Create Products')
@section('content_header') <h1>Create Products</h1> @stop
@section('content')
    @include('products.form', ['route' => route('products.store'), 'method' => 'POST','product' => null ])
@stop
