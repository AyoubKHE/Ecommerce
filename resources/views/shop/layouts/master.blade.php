{{-- @php
    dd($navCategories)
@endphp --}}
<!doctype html>
<html lang="en">

<!-- Head -->

<head>
    <!-- Page Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="mask-icon" href="./assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor CSS -->
    {{-- <link rel="stylesheet" href="./assets/css/libs.bundle.css" /> --}}
    <link rel="stylesheet" href="{{ asset('./shop_assets/assets/css/libs.bundle.css') }}" />

    <!-- Main CSS -->
    {{-- <link rel="stylesheet" href="./assets/css/theme.bundle.css" /> --}}
    <link rel="stylesheet" href="{{ asset('./shop_assets/assets/css/theme.bundle.css') }}" />

    <!-- Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fix for custom scrollbar if JS is disabled-->
    <noscript>
        <style>
            /**
          * Reinstate scrolling for non-JS clients
          */
            .simplebar-content-wrapper {
                overflow: auto;
            }
        </style>
    </noscript>

    <!-- Page Title -->
    <title>Alpine | Bootstrap 5 Ecommerce HTML Template</title>


</head>

<body class="">

    <!-- Navbar -->
    @include('shop.layouts.partials.nav.nav', [
        'navCategories' => $navCategories,
        'cartItemsCount' => $cartData == null ? 0 : $cartData['items_count'],
        'showCartCanva' => $showCartCanva,
    ])
    <!-- / Navbar-->


    <!-- Main Section-->
    @yield('content')
    <!-- / Main Section-->


    <!-- Footer-->
    @include('shop.layouts.partials.footer')
    <!-- / Footer--> <!-- / Footer-->


    <!-- Offcanvas Imports-->
    @include('shop.layouts.partials.off_canvas_imports', [
        'cartData' => $cartData,
    ])
    <!-- Search Overlay-->
    @include('shop.layouts.partials.search_overlay')
    <!-- Theme JS -->
    <!-- Vendor JS -->
    {{-- <script src="./assets/js/vendor.bundle.js"></script> --}}
    <script src="{{ asset('./shop_assets/assets/js/vendor.bundle.js') }}"></script>

    <!-- Theme JS -->
    {{-- <script src="./assets/js/theme.bundle.js"></script> --}}
    <script src="{{ asset('./shop_assets/assets/js/theme.bundle.js') }}"></script>

    @yield('js')

    <script src="{{ asset('js/myScripts/shop/product/deleteCartItem.js') }}"></script>

</body>

</html>
