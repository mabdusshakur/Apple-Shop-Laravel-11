@extends('admin.layout.sidenav-layout')
@section('content')
    @include('admin.components.brand.brand-list')
    @include('admin.components.brand.brand-delete')
    @include('admin.components.brand.brand-create')
    @include('admin.components.brand.brand-update')
@endsection
