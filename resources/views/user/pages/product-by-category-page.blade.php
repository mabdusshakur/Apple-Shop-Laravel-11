@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.ByCategoryList')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await Category();
            await ByCategory();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');

            await TopBrands();
        })()
    </script>
@endsection
