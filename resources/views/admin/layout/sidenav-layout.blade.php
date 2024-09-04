<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>

    <link type="image/x-icon" href="{{ asset('/admin/favicon.ico') }}" rel="icon" />
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/toastify.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}" rel="stylesheet" />

    <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('admin/js/toastify-js.js') }}"></script>
    <script src="{{ asset('admin/js/axios.min.js') }}"></script>
    <script src="{{ asset('admin/js/config.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.js') }}"></script>

    {{-- For The Client Side Auth --}}
    <script src=" https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js "></script>

    <script src="{{ asset('admin/js/auth.js') }}"></script>

</head>

<body>

    <div class="LoadingOverlay d-none" id="loader">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <nav class="navbar fixed-top bg-white px-0 shadow-sm">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <span class="icon-nav h5 m-0" onclick="MenuBarClickHandler()">
                    <img class="nav-logo-sm mx-2" src="{{ asset('admin/images/menu.svg') }}" alt="logo" />
                </span>
                <img class="nav-logo mx-2" src="{{ asset('admin/images/logo.png') }}" alt="logo" />
            </a>

            <div class="d-flex float-right h-auto">
                <div class="user-dropdown">
                    <img class="icon-nav-img" src="{{ asset('admin/images/user.webp') }}" alt="" />
                    <div class="user-dropdown-content">
                        <div class="mt-4 text-center">
                            <img class="icon-nav-img" src="{{ asset('admin/images/user.webp') }}" alt="" />
                            <h6>User Name</h6>
                            <hr class="user-dropdown-divider p-0" />
                        </div>
                        <a class="side-bar-item" href="{{ route('web.profile') }}">
                            <span class="side-bar-item-caption">Profile</span>
                        </a>
                        <a class="side-bar-item" onclick="logout()">
                            <span class="side-bar-item-caption">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="side-nav-open" id="sideNavRef">

        <a class="side-bar-item" href="{{ route('web.admin.dashboard') }}">
            <i class="bi bi-graph-up"></i>
            <span class="side-bar-item-caption">Dashboard</span>
        </a>

        <a class="side-bar-item" href="{{ route('web.admin.brand') }}">
            <i class="bi bi-list-nested"></i>
            <span class="side-bar-item-caption">Brand</span>
        </a>

        <a class="side-bar-item" href="{{ route('web.admin.category') }}">
            <i class="bi bi-list-nested"></i>
            <span class="side-bar-item-caption">Category</span>
        </a>

        <a class="side-bar-item" href="{{ route('web.admin.product') }}">
            <i class="bi bi-bag"></i>
            <span class="side-bar-item-caption">Product</span>
        </a>
    </div>

    <div class="content" id="contentRef">
        @yield('content')
    </div>

    <script>
        function MenuBarClickHandler() {
            let sideNav = document.getElementById('sideNavRef');
            let content = document.getElementById('contentRef');
            if (sideNav.classList.contains("side-nav-open")) {
                sideNav.classList.add("side-nav-close");
                sideNav.classList.remove("side-nav-open");
                content.classList.add("content-expand");
                content.classList.remove("content");
            } else {
                sideNav.classList.remove("side-nav-close");
                sideNav.classList.add("side-nav-open");
                content.classList.remove("content-expand");
                content.classList.add("content");
            }
        }


        function logout() {
            axios.post("/api/auth/logout");
            setLoggedOut(); // Client side Auth
            window.location.href = '{{ route('web.login') }}';
        }
    </script>

    {{-- Client side Auth
    <script src="{{ asset('admin/js/auth.js') }}"></script>
    <script>
        auth();
    </script> --}}
</body>

</html>
