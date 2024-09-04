@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.WishList')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await WishList();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
