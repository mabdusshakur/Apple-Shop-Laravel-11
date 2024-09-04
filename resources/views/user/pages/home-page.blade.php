@extends('user.layout.app')
@section('content')
    @include('user.component.MenuBar')
    @include('user.component.HeroSlider')
    @include('user.component.TopCategories')
    @include('user.component.ExclusiveProducts')
    @include('user.component.TopBrands')
    @include('user.component.Footer')
    <script>
        (async () => {
            await Category();
            await Hero();
            await TopCategory();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await Popular();
            await New();
            await Top();
            await Special();
            await Trending();
            await TopBrands();
        })()
    </script>
@endsection
