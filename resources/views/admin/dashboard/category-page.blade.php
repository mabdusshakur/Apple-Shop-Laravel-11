@extends('admin.layout.sidenav-layout')
@section('content')
    @include('admin.components.category.category-list')
    @include('admin.components.category.category-delete')
    @include('admin.components.category.category-create')
    @include('admin.components.category.category-update')
@endsection
