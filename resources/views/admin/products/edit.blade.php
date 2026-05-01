{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Produk - ' . $product->name)

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Dashboard</a>
    <span class="text-gray-400 ml-2">/</span>
    <a href="{{ route('admin.products.index') }}"
        class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Produk</a>
    <span class="text-gray-400 ml-2">/</span>
    <span class="text-gray-800 font-medium ml-2">Edit</span>
@endsection

@section('content')
    @include('admin.products.form')
@endsection
