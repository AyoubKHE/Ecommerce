@extends('shop.layouts.master', [
    'navCategories' => $data['navCategories'],
    'cartData' => $data['cartData'],
    'showCartCanva' => true,
])

@section('content')
    <section class="mt-0 ">
        <!-- Page Content Goes Here -->

        <!-- / Hero Section -->
        <section class="vh-100 position-relative bg-overlay-dark ">

            <div class="container d-flex h-100 justify-content-center align-items-center position-relative z-index-10">
                <div class="d-flex justify-content-center align-items-center h-100 position-relative z-index-10 text-white">
                    <div>
                        <h1 class="display-1 fw-bold px-2 px-md-5 text-center mx-auto col-lg-8 mt-md-0" data-aos="fade-up"
                            data-aos-delay="1000">Habillez votre style, exprimez votre personnalité.</h1>
                        <div data-aos="fade-in" data-aos-delay="2000">
                            <div class="d-md-flex justify-content-center mt-4 mb-3 my-md-5">

                                {{-- @foreach ($data['navCategories'] as $navCategory)
                                    <a href="#"
                                        class="btn btn-skew-left btn-orange btn-orange-chunky text-white mx-1 w-100 w-md-auto mb-2 mb-md-0">
                                        <span>
                                            {{ $navCategory['name'] }}
                                            <i class="ri-arrow-right-line align-middle fw-bold"></i>
                                        </span>
                                    </a>
                                @endforeach --}}

                                <a href="{{ route("shop.auth.register.form") }}"
                                    class="btn btn-skew-left btn-orange btn-orange-chunky text-white mx-1 w-100 w-md-auto mb-2 mb-md-0">
                                    <span>
                                        S'inscrire
                                        <i class="ri-arrow-right-line align-middle fw-bold"></i>
                                    </span>
                                </a>

                                <a href="{{ route("shop.auth.login.index") }}"
                                class="btn btn-skew-left btn-orange btn-orange-chunky text-white mx-1 w-100 w-md-auto mb-2 mb-md-0">
                                <span>
                                    Se Connecter
                                    <i class="ri-arrow-right-line align-middle fw-bold"></i>
                                </span>
                            </a>

                            </div>
                            <i class="ri-mouse-line d-block text-center animation-float ri-2x transition-all opacity-50-hover text-white"
                                data-pixr-scrollto data-target=".brand-section" data-aos="fade-up" data-aos-delay="700"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-absolute z-index-1 top-0 bottom-0 start-0 end-0">
                <!-- Swiper Info -->
                <div class="swiper-container overflow-hidden bg-light w-100 h-100" data-swiper
                    data-options='{
                    "slidesPerView": 1,
                    "speed": 1500,
                    "loop": true,
                    "effect": "fade",
                    "autoplay": {
                      "delay": 5000
                    }
                  }'>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide position-relative">
                            <div class="w-100 h-100 bg-img-cover animation-move bg-pos-center-center"
                                style="background-image: url('{{ asset('./shop_assets/assets/images/slideshows/slideshow-7.jpg') }}')">
                            </div>
                        </div>

                        <div class="swiper-slide position-relative">
                            <div class="w-100 h-100 bg-img-cover animation-move bg-pos-center-center"
                                style="background-image: url('{{ asset('./shop_assets/assets/images/slideshows/slideshow-2.jpg') }}')">
                            </div>
                        </div>

                        <div class="swiper-slide position-relative">
                            <div class="w-100 h-100 bg-img-cover animation-move bg-pos-center-center"
                                style="background-image: url('{{ asset('./shop_assets/assets/images/slideshows/slideshow-3.jpg') }}')">
                            </div>
                        </div>

                    </div>

                </div>
                <!-- / Swiper Info-->
            </div>

        </section>
        <!--/ Hero Section-->


        <!-- Featured Brands-->
        {{-- <div class="mb-lg-7 bg-light py-4" data-aos="fade-in">

        <div class="container">
            <div class="row gx-3 align-items-center">

                <div
                    class="col-12 justify-content-center justify-content-md-between align-items-center d-flex flex-wrap">

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop Kathmandu">

                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-1.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop Billabong">
                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-2.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop Oakley">
                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-9.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop Patagonia">
                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-4.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop North Face">
                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-5.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <div class="me-2 f-w-20 m-4 ms-md-0 mt-md-0 mb-md-0">
                        <a class="d-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shop Salomon">
                            <img class="img-fluid d-table mx-auto"
                                src="{{ asset('./shop_assets/assets/images/logos/logo-7.svg') }}"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </a>
                    </div>

                    <a href="#" class="btn btn-link fw-bolder">Explore All Brands <i
                            class="ri-arrow-right-line align-bottom fw-bold"></i></a>
                </div>

            </div>
        </div>

    </div> --}}
        <!--/ Featured Brands-->


        <!-- Staff Picks-->
        <section class="mb-9 mt-5" data-aos="fade-up">

            <div class="container">

                <div class="w-md-50 mb-5">
                    <p class="small fw-bolder text-uppercase tracking-wider mb-2 text-muted">FAVORIS DE L'ÉTÉ</p>
                    <h2 class="display-5 fw-bold mb-3">Sélection des stylistes</h2>
                    <p class="lead">
                        Soleil, liberté, insouciance : vibrez au rythme de l'été avec notre sélection tendance.
                    </p>
                </div>

                <!-- Swiper Latest -->
                <div class="swiper-container overflow-visible" data-swiper
                    data-options='{
                    "spaceBetween": 25,
                    "cssMode": true,
                    "roundLengths": true,
                    "scrollbar": {
                      "el": ".swiper-scrollbar",
                      "hide": false,
                      "draggable": true
                    },
                    "navigation": {
                      "nextEl": ".swiper-next",
                      "prevEl": ".swiper-prev"
                    },
                    "breakpoints": {
                      "576": {
                        "slidesPerView": 1
                      },
                      "768": {
                        "slidesPerView": 2
                      },
                      "992": {
                        "slidesPerView": 3
                      },
                      "1200": {
                        "slidesPerView": 4
                      }
                    }
                  }'>

                    <div class="swiper-wrapper pb-5 pe-1">
                        <div class="swiper-slide d-flex h-auto">

                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-1.jpg',
                                'imageHoverPath' => 'product-1b.jpg',
                            ])
                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-2.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-3.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-4.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-5.jpg',
                                'imageHoverPath' => 'product-5b.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-6.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-7.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => 2,
                                'productName' => 'Full Zip Hoodie',
                                'productPrice' => 1129.99,
                                'productRating' => 90,
                                'image1Path' => 'product-8.jpg',
                            ])

                            <!--/ Card Product-->
                        </div>

                        <div class="swiper-slide d-flex h-auto justify-content-center align-items-center">
                            <a href="#"
                                class="d-flex text-decoration-none flex-column justify-content-center align-items-center">
                                <span class="btn btn-dark btn-icon mb-3">
                                    <i class="ri-arrow-right-line ri-lg lh-1"></i>
                                </span>
                                <span class="lead fw-bolder">See All</span>
                            </a>
                        </div>

                    </div>

                    <!-- Buttons-->
                    <div
                        class="swiper-btn swiper-disabled-hide swiper-prev swiper-btn-side btn-icon bg-dark text-white ms-3 shadow-lg mt-n5 ms-n4">
                        <i class="ri-arrow-left-s-line ri-lg"></i>
                    </div>
                    <div
                        class="swiper-btn swiper-disabled-hide swiper-next swiper-btn-side swiper-btn-side-right btn-icon bg-dark text-white me-n4 shadow-lg mt-n5">
                        <i class="ri-arrow-right-s-line ri-lg"></i>
                    </div>

                    <!-- Add Scrollbar -->
                    <div class="swiper-scrollbar"></div>

                </div>
                <!-- / Swiper Latest-->

            </div>

        </section>
        <!-- / Staff Picks-->


        <!-- Image Hotspot Banner-->
        <section class="my-10 position-relative">

            <!-- SVG Shape Divider-->
            <div class="position-absolute z-index-50 text-white top-0 start-0 end-0">
                <svg class="align-self-start d-flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1283 53.25">
                    <polygon fill="currentColor" points="1283 0 0 0 0 53.25 1283 0" />
                </svg>
            </div>
            <!-- /SVG Shape Divider-->

            <div class="w-100 h-100 bg-img-cover bg-pos-center-center hotspot-container py-5 py-md-7 py-lg-10"
                style="background-image: url(https://images.unsplash.com/photo-1508746829417-e6f548d8d6ed?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80);">

                <div class="hotspot d-none d-lg-block"
                    data-options='{
                    "placement": {
                        "left": "68%",
                        "bottom": "40%"
                    },
                    "alwaysVisible": true,
                    "alwaysAnimate": true,
                    "contentTarget": "#hotspot-one",
                    "trigger": "mouseenter"
                }'>
                </div>

                <div class="hotspot d-none d-lg-block"
                    data-options='{
                    "placement": {
                        "left": "53%",
                        "top": "40%"
                    },
                    "alwaysVisible": true,
                    "alwaysAnimate": true,
                    "contentTarget": "#hotspot-one"
                }'>
                </div>

                <div class="container py-lg-8 position-relative z-index-10 d-flex align-items-center" data-aos="fade-left">
                    <div
                        class="py-8 d-flex justify-content-end align-items-start align-items-lg-end flex-column col-lg-4 text-lg-end">
                        <p class="small fw-bolder text-uppercase tracking-wider mb-2 text-muted">PERFORMANCES EXTRÊMES
                        </p>
                        <h2 class="display-5 fw-bold mb-3">The North Face</h2>
                        <p class="lead d-none d-lg-block">Soyez prêt toute l'année avec notre sélection de North Face
                            vestes d'extérieur – parfaites à tout moment de l'année et tout au long de l'année. Choisissez
                            parmi une variété de nuances de couleurs et de styles pour vous réchauffer par temps froid.
                        </p>
                        <a class="text-decoration-none fw-bolder" href="#">Achetez The North Face &rarr;</a>
                    </div>
                </div>

                <!-- Example Hotspot HTML Content -->
                <div id="hotspot-one" class="d-none">

                    <div class="m-n2 rounded overflow-hidden">

                        <div class="mb-1 bg-light d-flex justify-content-center">
                            <div class="f-w-48 px-3 pt-3">
                                <img class="img-fluid"
                                    src="{{ asset('./shop_assets/assets/images/products/product-3.jpg') }}"
                                    alt="Bootstrap 5 Template by Pixel Rocket">
                            </div>
                        </div>

                        <div class="px-4 py-4 text-center">
                            <div class="d-flex justify-content-center align-items-center mx-auto mb-1">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars" style="width: 80%">
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                        <i class="ri-star-fill text-dark mr-1"></i>
                                    </div>
                                    <div class="stars">
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                        <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    </div>
                                </div> <span class="small fw-bolder ms-2 text-muted"> 4.4 (1289)</span>
                            </div>
                            <p class="mb-0 mx-4">Pusher Outdoor Jeans Black Women</p>
                            <p class="lead lh-1 m-0 fw-bolder mt-2 mb-3">$199.87</p>
                            <a href="#" class="fw-bolder text-link-border pb-1 fs-6">Full details <i
                                    class="ri-arrow-right-line align-bottom"></i></a>
                        </div>

                    </div>

                </div>

            </div>

            <!-- SVG Shape Divider-->
            <div class="position-absolute z-index-50 text-white bottom-0 start-0 end-0">
                <svg class="align-self-end d-flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1283 53.25">
                    <polygon fill="currentColor" points="0 53.25 1283 53.25 1283 0 0 53.25" />
                </svg>
            </div>
            <!-- /SVG Shape Divider-->

        </section>
        <!-- / Image Hotspot Banner-->


        <!-- Linked Product Carousels-->
        <section class="py-5" data-aos="fade-in">

            <div class="container">

                <div class="row g-5">

                    <div class="col-12 col-md-7" data-aos="fade-right">

                        <div class="m-0">
                            <p class="small fw-bolder text-uppercase tracking-wider mb-2 text-muted">LES ESSENTIELS DE LA
                                RANDONNÉE</p>

                            <h2 class="display-5 fw-bold mb-6">Nos derniers produits incontournables</h2>

                            <div class="px-8 position-relative">

                                <!-- Swiper-->
                                <div class="swiper-container swiper-linked-carousel-small">

                                    <!-- Add Pagination -->
                                    <div class="swiper-pagination-blocks mb-4">
                                        <div class="swiper-pagination-custom"></div>
                                    </div>

                                    <div class="swiper-wrapper">

                                        <!-- Swiper Slide-->
                                        <div class="swiper-slide overflow-hidden">
                                            <!-- Card-->
                                            <!-- Card Product-->
                                            @include('shop.layouts.products.product_card', [
                                                'productId' => 2,
                                                'productName' => 'Full Zip Hoodie',
                                                'productPrice' => 1129.99,
                                                'productRating' => 90,
                                                'image1Path' => 'product-10.jpg',
                                            ])
                                            <!--/ Card Product-->
                                            <!--/ Card-->
                                        </div>
                                        <!-- / Swiper Slide-->

                                        <!-- Swiper Slide-->
                                        <div class="swiper-slide overflow-hidden">
                                            <!-- Card-->
                                            <!-- Card Product-->
                                            @include('shop.layouts.products.product_card', [
                                                'productId' => 2,
                                                'productName' => 'Full Zip Hoodie',
                                                'productPrice' => 1129.99,
                                                'productRating' => 90,
                                                'image1Path' => 'product-11.jpg',
                                            ])
                                            <!--/ Card Product-->
                                            <!--/ Card-->
                                        </div>
                                        <!-- / Swiper Slide-->

                                        <!-- Swiper Slide-->
                                        <div class="swiper-slide overflow-hidden">
                                            <!-- Card-->
                                            <!-- Card Product-->
                                            @include('shop.layouts.products.product_card', [
                                                'productId' => 2,
                                                'productName' => 'Full Zip Hoodie',
                                                'productPrice' => 1129.99,
                                                'productRating' => 90,
                                                'image1Path' => 'product-12.jpg',
                                            ])
                                            <!--/ Card Product-->
                                            <!--/ Card-->
                                        </div>
                                        <!-- / Swiper Slide-->

                                    </div>
                                </div> <!-- /Swiper-->

                                <!-- Swiper Arrows -->
                                <div
                                    class="swiper-prev-linked position-absolute top-50 start-0 mt-n8 cursor-pointer transition-all opacity-50-hover">
                                    <i class="ri-arrow-left-s-line ri-2x"></i>
                                </div>

                                <div
                                    class="swiper-next-linked position-absolute top-50 end-0 me-3 mt-n8 cursor-pointer transition-all opacity-50-hover">
                                    <i class="ri-arrow-right-s-line ri-2x"></i>
                                </div>
                                <!-- / Swiper Arrows-->

                            </div>

                        </div>

                    </div>

                    <div class="col-md-5 d-none d-md-flex" data-aos="fade-left">

                        <div class="w-100 h-100">

                            <!-- Swiper-->
                            <div class="swiper-container h-100 swiper-linked-carousel-large">

                                <div class="swiper-wrapper h-100">

                                    <!-- Swiper Slide-->
                                    <div class="swiper-slide">
                                        <div class="row g-3">
                                            <div class="col-12 col-md-6">
                                                <!-- Card Product-->
                                                @include('shop.layouts.products.product_card', [
                                                    'productId' => 2,
                                                    'productName' => 'Full Zip Hoodie',
                                                    'productPrice' => 1129.99,
                                                    'productRating' => 90,
                                                    'image1Path' => 'product-13.jpg',
                                                ])
                                                <!--/ Card Product-->
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <!-- Card Product-->
                                                @include('shop.layouts.products.product_card', [
                                                    'productId' => 2,
                                                    'productName' => 'Full Zip Hoodie',
                                                    'productPrice' => 1129.99,
                                                    'productRating' => 90,
                                                    'image1Path' => 'product-14.jpg',
                                                ])
                                                <!--/ Card Product-->
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <!-- Card Product-->
                                                @include('shop.layouts.products.product_card', [
                                                    'productId' => 2,
                                                    'productName' => 'Full Zip Hoodie',
                                                    'productPrice' => 1129.99,
                                                    'productRating' => 90,
                                                    'image1Path' => 'product-15.jpg',
                                                ])
                                                <!--/ Card Product-->
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <!-- Card Product-->
                                                @include('shop.layouts.products.product_card', [
                                                    'productId' => 2,
                                                    'productName' => 'Full Zip Hoodie',
                                                    'productPrice' => 1129.99,
                                                    'productRating' => 90,
                                                    'image1Path' => 'product-16.jpg',
                                                ])
                                                <!--/ Card Product-->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Swiper Slide-->

                                </div>

                            </div> <!-- / Swiper-->

                        </div>

                    </div>

                </div>

            </div>

        </section>
        <!-- / Linked Product Carousels-->


        <!-- Sale Banner -->
        {{-- <section class="position-relative my-5 my-md-7 my-lg-9 bg-dark" data-aos="fade-in">

        <!-- SVG Shape Divider-->
        <div class="position-absolute text-white z-index-50 top-0 end-0 start-0">
            <svg class="align-self-start d-flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1283 53.25">
                <polygon fill="currentColor" points="1283 0 0 0 0 53.25 1283 0" />
            </svg>
        </div>
        <!-- /SVG Shape Divider-->

        <div class="py-7 py-lg-10">

            <div class="container text-white py-4 py-md-6">

                <div class="row g-5 align-items-center">

                    <div class="col-12 col-lg-4 justify-content-center d-flex justify-content-lg-start"
                        data-aos="fade-right" data-aos-delay="250">
                        <h3 class="fs-1 fw-bold mb-0 lh-1"><i class="ri-timer-flash-line align-bottom"></i> Sale
                            Extended</h3>
                    </div>

                    <div class="col-12 col-lg-4 d-flex justify-content-center flex-column" data-aos="fade-up"
                        data-aos-delay="250">

                        <a href="#" class="btn btn-orange btn-orange-chunky text-white my-1">
                            <span>Shop Menswear</span>
                        </a>

                        <a href="#" class="btn btn-orange btn-orange-chunky text-white my-1">
                            <span>Shop Womenswear</span>
                        </a>

                        <a href="#" class="btn btn-orange btn-orange-chunky text-white my-1">
                            <span>Shop Kidswear</span>
                        </a>

                        <a href="#" class="btn btn-orange btn-orange-chunky text-white my-1">
                            <span>Shop Accessories</span>
                        </a>

                    </div>

                    <div class="col-12 col-lg-4 text-center text-lg-end" data-aos="fade-left" data-aos-delay="250">
                        <p class="lead fw-bolder">Discount applied to products at checkout.</p>
                        <a class="text-white fw-bolder text-link-border border-2 border-white align-self-start pb-1 transition-all opacity-50-hover"
                            href="#">Exclusions apply. Learn more <i
                                class="ri-arrow-right-line align-bottom"></i></a>
                    </div>

                </div>

            </div>

        </div>

        <!-- SVG Shape Divider-->
        <div class="position-absolute z-index-50 text-white bottom-0 start-0 end-0">
            <svg class="align-self-end d-flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1283 53.25">
                <polygon fill="currentColor" points="0 53.25 1283 53.25 1283 0 0 53.25" />
            </svg>
        </div>
        <!-- /SVG Shape Divider-->

    </section> --}}
        <!-- /Sale Banner -->


        <!-- Reviews-->
        <section>

            <div class="container" data-aos="fade-in">
                <h2 class="fs-1 fw-bold mb-3 text-center mb-5">Avis des clients</h2>

                <div class="row g-3">

                    <div class="col-12 col-lg-4" data-aos="fade-left">
                        <div
                            class="bg-light p-4 d-flex h-100 justify-content-start align-items-center flex-column text-center">
                            <p class="fw-bolder lead">Service incroyable!</p>
                            <p class="mb-3">Je fais des achats avec eux depuis quelques années maintenant. Articles très
                                faciles à sélectionner, articles toujours comme décrit. Je n'ai jamais eu à retourner un
                                article. Bon rapport qualité prix.</p>
                            <small class="text-muted d-block mb-2 fw-bolder">John Doe, London</small>

                            <!-- Review Stars Small-->
                            <div class="rating position-relative d-table">
                                <div class="position-absolute stars" style="width: 75%">
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                </div>
                                <div class="stars">
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-lg-4" data-aos="fade-left" data-aos-delay="150">
                        <div
                            class="bg-light p-4 d-flex h-100 justify-content-start align-items-center flex-column text-center">
                            <p class="fw-bolder lead">Prix imbattable</p>
                            <p class="mb-3">Trouvez toujours ces gars compétitifs et avec une vaste gamme de
                                produits, associés à un excellent marketing, il est difficile de ne pas acheter quelque
                                chose.</p>
                            <small class="text-muted d-block mb-2 fw-bolder">Sally Smith, Dublin</small>
                            <!-- Review Stars Small-->
                            <div class="rating position-relative d-table">
                                <div class="position-absolute stars" style="width: 75%">
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                </div>
                                <div class="stars">
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4" data-aos="fade-left" data-aos-delay="300">
                        <div
                            class="bg-light p-4 d-flex h-100 justify-content-start align-items-center flex-column text-center">
                            <p class="fw-bolder lead">Site Web fantastique</p>
                            <p class="mb-3">Il manquait un article à mon colis mais le service client l'a résolu
                                immédiatement et j'ai reçu une autre livraison assez rapidement. De plus, le produit était
                                absolument charmant.</p>
                            <small class="text-muted d-block mb-2 fw-bolder">John Patrick, London</small>
                            <!-- Review Stars Small-->
                            <div class="rating position-relative d-table">
                                <div class="position-absolute stars" style="width: 75%">
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                    <i class="ri-star-fill text-dark mr-1"></i>
                                </div>
                                <div class="stars">
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                    <i class="ri-star-fill mr-1 text-muted opacity-25"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-center flex-column mt-7 align-items-center">
                    <h3 class="mb-4 fw-bold fs-4">Voir ce que des autres ont dit</h3>

                    <div class="d-flex justify-content-center align-items-center">
                        <span class="fs-3 fw-bold me-4">4.85 / 5</span>
                        <!-- Review Stars Medium-->
                        <div class="rating position-relative d-table">
                            <div class="position-absolute stars" style="width: 88%">
                                <i class="ri-star-fill text-dark ri-2x mr-1"></i>
                                <i class="ri-star-fill text-dark ri-2x mr-1"></i>
                                <i class="ri-star-fill text-dark ri-2x mr-1"></i>
                                <i class="ri-star-fill text-dark ri-2x mr-1"></i>
                                <i class="ri-star-fill text-dark ri-2x mr-1"></i>
                            </div>
                            <div class="stars">
                                <i class="ri-star-fill ri-2x mr-1 text-muted"></i>
                                <i class="ri-star-fill ri-2x mr-1 text-muted"></i>
                                <i class="ri-star-fill ri-2x mr-1 text-muted"></i>
                                <i class="ri-star-fill ri-2x mr-1 text-muted"></i>
                                <i class="ri-star-fill ri-2x mr-1 text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-dark rounded-0 mt-4">Lire 4,215 avis supplémentaires</a>
                </div>

            </div>

        </section>
        <!-- /Reviews-->

        <!-- /Page Content -->
    </section>
@endsection
