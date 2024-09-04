@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.ProductDetails')
    @include('user.component.ProductSpecification')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await productDetails();
            await productReview();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
