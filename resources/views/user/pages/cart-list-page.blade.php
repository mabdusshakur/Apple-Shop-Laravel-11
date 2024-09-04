@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.PaymentMethodList')
    @include('user.component.CartList')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await CartList();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
