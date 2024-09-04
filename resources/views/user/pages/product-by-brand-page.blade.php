@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.ByBrandList')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await Category();
            await ByBrand();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await TopBrands();
        })()
    </script>
@endsection
