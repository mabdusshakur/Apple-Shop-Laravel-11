<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-lg-start text-center">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
                            <li><i class="ti-email"></i><span>info@apple.com</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-end text-center">
                        <ul class="header_list">
                            <li><a href="/policy?type=about">About</a></li>

                            {{-- <div id="menu-control">

                            </div> --}}
                            {{-- @if (Cookie::get('token') !== null)
                                <li><a href="{{ url('/profile') }}"> <i class="linearicons-user"></i> Account</a></li>
                                <li><a class="btn btn-danger btn-sm" href="#"> Logout</a></li>
                            @else
                                <li><a class="btn btn-danger btn-sm" href="{{ route('web.login') }}">Login</a></li>
                            @endif --}}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ route('web.home') }}">
                    <img class="logo_dark" src="{{ asset('user/assets/images/logo_dark.png') }}" alt="logo" />
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="navbar-collapse justify-content-end collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{ route('web.home') }}">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#">Products</a>
                            <div class="dropdown-menu">
                                <ul id="CategoryItem">

                                </ul>
                            </div>
                        </li>
                        <li><a class="nav-link nav_item" href="{{ route('web.wish-list') }}"><i class="ti-heart"></i> Wish</a></li>
                        <li><a class="nav-link nav_item" href="{{ route('web.cart-list') }}"><i class="linearicons-cart"></i> Cart </a></li>
                        <li><a class="nav-link search_trigger" href="javascript:void(0);"><i class="linearicons-magnifier"></i> Search</a>
                            <div class="search_wrap">
                                <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                                <form>
                                    <input class="form-control" id="search_input" type="text" placeholder="Search">
                                    <button class="search_icon" type="submit"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div>
                            <div class="search_overlay"></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>
    loadMenuControl();

    async function Category() {
        let res = await axios.get('/api/categories');
        res = res.data[0];

        $("#CategoryItem").empty()

        res.forEach((item, i) => {
            let EachItem = ` <li><a class="dropdown-item nav-link nav_item" href="/product-by-category?id=${item['id']}">${item['name']}</a></li>`
            $("#CategoryItem").append(EachItem);
        })
    }

    function Logout() {
        axios.post('/api/auth/logout')
            .then(res => {
                window.location.href = '/login';
                setLoggedOut();
            })
    }

    function loadMenuControl() {
        $menuControl = $('.header_list');
        $menuControl.empty();

        if (isLoggedIn()) {
            $item = `<li><a href="/profile"> <i class="linearicons-user"></i> Account</a></li>
            <li><a class="btn btn-danger btn-sm" href="#" onclick="Logout()"> Logout</a></li>`;
            $menuControl.append($item);
        } else {
            $menuControl.append(`<li><a class="btn btn-danger btn-sm" href="/login">Login</a></li>`);
        }
    }
</script>
