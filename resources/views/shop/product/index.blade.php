@extends('shop.layouts.master', [
    'navCategories' => $data['navCategories'],
    'cartData' => $data['cartData'],
    'showCartCanva' => true,
])

@section('content')
    <input type="hidden" id="product_id" value="{{ $data['productData']['id'] }}">

    <x-messages.flashbag />

    <section class="mt-5 ">
        <!-- Page Content Goes Here -->

        <!-- Product Top-->
        <section class="container">

            <div class="row g-5">

                <!-- Images Section-->
                <div class="col-12 col-lg-7">

                    <div class="row g-1">

                        <div class="swiper-container gallery-thumbs-vertical col-2 pb-4">

                            <div class="swiper-wrapper">

                                @foreach ($data['productData']['images'] as $product_image)
                                    <div class="swiper-slide bg-light bg-light h-auto">
                                        <picture>
                                            <img class="img-fluid mx-auto d-table"
                                                src={{ asset('storage/' . $product_image['image_path']) }}
                                                alt="Bootstrap 5 Template by Pixel Rocket">
                                        </picture>
                                    </div>
                                @endforeach

                            </div>

                        </div>

                        <div class="swiper-container gallery-top-vertical col-10">

                            <div class="swiper-wrapper">

                                @foreach ($data['productData']['images'] as $product_image)
                                    <div class="swiper-slide bg-white h-auto">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto"
                                                src={{ asset('storage/' . $product_image['image_path']) }}
                                                alt="Bootstrap 5 Template by Pixel Rocket" data-zoomable>
                                        </picture>
                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>
                <!-- /Images Section-->

                <!-- Product Info Section-->
                <div class="col-12 col-lg-5">

                    <div class="pb-3">

                        <!-- Product Name, Review, Brand, Price-->

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <p class="small fw-bolder text-uppercase tracking-wider text-muted mb-0 lh-1">
                                {{ $data['productData']['brand_name'] }}</p>
                            <div class="d-flex justify-content-start align-items-center">
                                <!-- Review Stars Small-->
                                <div class="rating position-relative d-table">
                                    <div class="position-absolute stars"
                                        style="width: {{ $data['productData']['rating'] == null ? 50 : $data['productData']['rating'] }}%">
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
                                <small class="text-muted d-inline-block ms-2 fs-bolder">(1288)</small><span
                                    style="color: red">***</span>
                            </div>
                        </div>

                        <h1 class="mb-2 fs-2 fw-bold">{{ $data['productData']['name'] }}</h1>

                        <div class="d-flex justify-content-start align-items-center">
                            <p class="lead fw-bolder m-0 fs-3 lh-1 text-danger me-2" id="product-price">
                                {{ $data['productData']['price'] }} DA</p>

                            <s class="lh-1 me-2"><span class="fw-bolder m-0">$94.99</span></s><span
                                style="color: red">***</span>
                            <p class="lead fw-bolder m-0 fs-6 lh-1 text-success">Save $10.00</p><span
                                style="color: red">***</span>
                        </div>

                        <!-- /Product Name, Review, Brand, Price-->

                        <!-- Product Views-->
                        <div class="d-flex justify-content-start mt-3">
                            <div class="alert bg-light rounded py-1 px-2 d-table m-0">
                                <div class="d-flex justify-content-start align-items-center">
                                    <i class="ri-fire-fill lh-1 text-orange"></i>
                                    <div class="ms-2">
                                        <small class="opacity-75 fw-bolder lh-1">167 views today <span
                                                style="color: red">***</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Options-->
                        @foreach ($data['productData']['attributes'] as $product_attribute => $product_attribute_options)
                            <div class="py-4 widget-filter border-top">

                                <small class="text-uppercase d-block fw-bolder mb-2"
                                    id="attribute-label-{{ $product_attribute }}">
                                    {{ $product_attribute }} :
                                </small>

                                @foreach ($product_attribute_options as $key => $option)
                                    <div class="form-group d-inline-block mr-2 mb-2 form-check-bg form-check-custom"
                                        id="container-attribute-{{ $product_attribute }}-{{ $option }}">
                                        <input type="radio"
                                            name="attribute-{{ $product_attribute }}"
                                            value="{{ $option }}" class="form-check-bg-input"
                                            id="attribute-{{ $product_attribute }}-{{ $key }}">
                                        <label class="form-check-label fw-normal"
                                            for="attribute-{{ $product_attribute }}-{{ $key }}">{{ $option }}</label>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                        <div id="spinner-container" style="text-align: center; margin-bottom: 10px">

                        </div>

                        <div id="variation-more-details" style="text-align: center; margin-bottom: 10px">

                        </div>

                        <div style="text-align: center; margin-bottom: 20px">
                            <button id="reset-filters"
                                style="border: none; border-radius: 10px; color: #000000; background-color: #c2f190; width: 70px; display: inline-block;">
                                reset
                            </button>

                        </div>
                        <!-- Add To Cart-->

                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"
                            id="cart-form">

                            @csrf

                            <input id="variation-id" type="hidden" name="variation_id" value="">

                            <div class="d-flex align-items-center" style="gap: 10px">
                                <input type="number" id="quantity-of-variation" name="item_quantity"
                                    style="height: 55px; width: 10%; text-align: center; border-radius: 5px" value="1">

                                <button type="submit" class="btn btn-dark btn-dark-chunky flex-grow-1 me-2 text-white"
                                    style="border-radius: 5px">Ajouter au panier
                                </button>
                            </div>
                        </form>
                        <!-- /Add To Cart-->

                        <div class="d-flex align-items-center" style="gap: 10px">

                        </div>

                        <!-- /Product Options-->



                        <!-- Socials-->
                        <div class="my-4">
                            <div class="d-flex justify-content-start align-items-center">
                                <p class="fw-bolder lh-1 mb-0 me-3">Share</p>
                                <ul class="list-unstyled p-0 m-0 d-flex justify-content-start lh-1 align-items-center mt-1">
                                    <li class="me-2"><a class="text-decoration-none" href="#" role="button"><i
                                                class="ri-facebook-box-fill"></i></a></li>
                                    <li class="me-2"><a class="text-decoration-none" href="#" role="button"><i
                                                class="ri-instagram-fill"></i></a></li>
                                    <li class="me-2"><a class="text-decoration-none" href="#" role="button"><i
                                                class="ri-pinterest-fill"></i></a></li>
                                    <li class="me-2"><a class="text-decoration-none" href="#" role="button"><i
                                                class="ri-twitter-fill"></i></a></li>
                                </ul>
                                <span style="color: red">***</span>
                            </div>
                        </div>
                        <!-- Socials-->

                        <!-- Special Offers-->
                        <div class="bg-light rounded py-2 px-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex border-0 px-0 bg-transparent">
                                    <i class="ri-truck-line"></i>
                                    <span class="fs-6 ms-3">Livraison standard gratuite pour les commandes de plus de 10000
                                        DA.
                                        Livraison le lendemain 500 DA</span>
                                </li>
                            </ul>
                        </div>
                        <!-- /Special Offers-->

                    </div>

                </div>
                <!-- / Product Info Section-->
            </div>
        </section>
        <!-- / Product Top-->

        <section>

            <!-- Product Tabs-->
            <div class="mt-7 pt-5 border-top">
                <div class="container">
                    <!-- Tab Nav-->
                    <ul class="nav justify-content-center nav-tabs nav-tabs-border mb-4" id="myTab" role="tablist">
                        <li class="nav-item w-100 mb-2 mb-sm-0 w-sm-auto mx-sm-3" role="presentation">
                            <a class="nav-link fs-5 fw-bolder nav-link-underline mx-sm-3 px-0 active" id="details-tab"
                                data-bs-toggle="tab" href="#details" role="tab" aria-controls="details"
                                aria-selected="true">Description</a>
                        </li>
                        {{-- <li class="nav-item w-100 mb-2 mb-sm-0 w-sm-auto mx-sm-3" role="presentation">
                            <a class="nav-link fs-5 fw-bolder nav-link-underline mx-sm-3 px-0" id="reviews-tab"
                                data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                aria-selected="false">Reviews</a>
                        </li> --}}
                        <li class="nav-item w-100 mb-2 mb-sm-0 w-sm-auto mx-sm-3" role="presentation">
                            <a class="nav-link fs-5 fw-bolder nav-link-underline mx-sm-3 px-0" id="delivery-tab"
                                data-bs-toggle="tab" href="#delivery" role="tab" aria-controls="delivery"
                                aria-selected="false">Livraison</a>
                        </li>
                        <li class="nav-item w-100 mb-2 mb-sm-0 w-sm-auto mx-sm-3" role="presentation">
                            <a class="nav-link fs-5 fw-bolder nav-link-underline mx-sm-3 px-0" id="returns-tab"
                                data-bs-toggle="tab" href="#returns" role="tab" aria-controls="returns"
                                aria-selected="false">Les retours</a>
                        </li>
                    </ul>
                    <!-- / Tab Nav-->

                    <!-- Tab Content-->
                    <div class="tab-content" id="myTabContent">

                        <!-- Tab Details Content-->
                        <div class="tab-pane fade show active py-5" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            <div class="col-12 col-lg-10 mx-auto">
                                <div class="row g-5">
                                    {{ $data['productData']['description'] }}
                                    {{-- <div class="col-12 col-md-6">
                                        <p>Soft, stretchy - the most flattering product of the season! What could be easier?
                                            Beautifully soft and
                                            light cotton-modal jersey, with the extra advantage of stretch, cut in an A-line
                                            - the universally
                                            flattering shape for every body. We promise you, once you've tried these lovely
                                            products - you'll be
                                            hooked..</p>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <ul>
                                            <li>Stretchy cotton-modal jersey stripe</li>
                                            <li>Garment washed</li>
                                            <li>Flat, covered elastic waistband</li>
                                            <li>58% pima cotton/38% viscose </li>
                                            <li>Modal/4% Lycra® elastane</li>
                                        </ul>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                        <!-- Tab Details Content-->

                        <!-- Delivery Tab Content-->
                        <div class="tab-pane fade py-5" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                <p>Nous proposons désormais une livraison sans contact afin que vous puissiez toujours
                                    recevoir vos colis en toute sécurité sans nécessiter de signature. Veuillez consulter
                                    ci-dessous les méthodes de livraison disponibles, les coûts et les délais.
                                </p>
                                <ul class="list-group list-group-flush mb-4">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-4 bg-transparent">
                                        <div>
                                            <span class="fw-bolder d-block">Livraison Standard</span>
                                            <span class="text-muted">Livraison dans les 5 jours suivant votre
                                                commande.</span>
                                        </div>
                                        <p class="m-0 lh-1 fw-bolder">500 DA</p>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-4 bg-transparent">
                                        <div>
                                            <span class="fw-bolder d-block">Livraison prioritaire</span>
                                            <span class="text-muted">Livraison dans les 2 jours suivant votre
                                                commande.</span>
                                        </div>
                                        <p class="m-0 lh-1 fw-bolder">700 DA</p>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-4 bg-transparent">
                                        <div>
                                            <span class="fw-bolder d-block">Livraison le lendemain</span>
                                            <span class="text-muted">Livraison dans les 24 heures suivant votre
                                                commande.</span>
                                        </div>
                                        <p class="m-0 lh-1 fw-bolder">1000 DA</p>
                                    </li>
                                </ul>
                                <div class="bg-light rounded p-3">
                                    <p class="fs-6">Pour plus d'informations, veuillez consulter notre FAQ sur la
                                        livraison <a href="#">ici</a></p>
                                    <p class="m-0 fs-6">Si vous ne trouvez pas de réponse à votre question, veuillez
                                        contacter notre
                                        équipe de support client sur
                                        <b>0987878787</b> ou envoyez-nous un email à <b>support@domain.com</b>. Nous
                                        souhaitons répondre
                                        dans les 48 heures aux requêtes.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- / Delivery Tab Content-->

                        <!-- Returns Tab Content-->
                        <div class="tab-pane fade py-5" id="returns" role="tabpanel" aria-labelledby="returns-tab">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                                <p>Nous croyons que vous serez entièrement satisfait de votre article, mais si ce n'est pas
                                    le cas, ne vous inquiétez pas. Nous avons répertorié ci-dessous les façons dont vous
                                    pouvez nous retourner votre article.</p>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item px-0 py-4 bg-transparent">
                                        <p class="fw-bolder">Retour par la poste</p>
                                        <p class="fs-6">Pour retourner vos articles gratuitement via le système postal,
                                            veuillez
                                            remplissez le formulaire de retour fourni avec votre commande. Vous trouverez
                                            une étiquette au bas du formulaire. Décollez simplement l'étiquette et
                                            dirigez-vous vers votre
                                            bureau de poste le plus proche.</p>
                                    </li>
                                    <li class="list-group-item px-0 py-4 bg-transparent">
                                        <p class="fw-bolder">Retour en personne</p>
                                        <p class="fs-6">Pour retourner vos articles gratuitement en personne, il vous
                                            suffit de vous rendre dans n'importe quel magasin.
                                            de nos emplacements et parlez à un membre de notre équipe en magasin.</p>
                                    </li>
                                </ul>

                                <div class="bg-light rounded p-3">
                                    <p class="fs-6">Pour plus d'informations, veuillez consulter notre FAQ sur la
                                        livraison <a href="#">ici</a></p>
                                    <p class="m-0 fs-6">Si vous ne trouvez pas de réponse à votre question, veuillez
                                        contacter notre
                                        équipe de support client sur
                                        <b>0987878787</b> ou envoyez-nous un email à <b>support@domain.com</b>. Nous
                                        souhaitons répondre
                                        dans les 48 heures aux requêtes.
                                    </p>
                                </div>

                            </div>
                        </div>
                        <!-- / Returns Tab Content-->

                    </div>
                    <!-- / Tab Content-->
                </div>
            </div>
            <!-- / Product Tabs-->

        </section>

        <!-- Related Products-->
        <div class="container my-8">
            <h3 class="fs-4 fw-bold mb-5 text-center">Vous pourriez aussi aimer</h3>
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
                    @foreach ($data['relatedProducts'] as $product)
                        @php
                            $image1Path = collect($product['images'])
                                ->filter(function ($image) {
                                    return $image['is_default'] == 1;
                                })
                                ->first()['image_path'];

                            $imageHoverPath = collect($product['images'])
                                ->filter(function ($image) {
                                    return $image['is_default'] == 0;
                                })
                                ->first()['image_path'];

                        @endphp



                        <div class="swiper-slide d-flex h-auto swiper-slide-active">
                            <!-- Card Product-->
                            @include('shop.layouts.products.product_card', [
                                'productId' => $product['id'],
                                'productName' => $product['name'],
                                'productPrice' => $product['price'],
                                'productRating' => $product->rating ?? 50,
                                'image1Path' => $image1Path,
                                'imageHoverPath' => $imageHoverPath,
                            ])
                            <!--/ Card Product-->
                        </div>
                    @endforeach

                    <div class="swiper-slide d-flex h-auto justify-content-center align-items-center">
                        <a href="./category.html"
                            class="d-flex text-decoration-none flex-column justify-content-center align-items-center">
                            <span class="btn btn-dark btn-icon mb-3"><i class="ri-arrow-right-line ri-lg lh-1"></i></span>
                            <span class="lead fw-bolder">Voir tout</span>
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
        <!--/ Related Products-->


        <!-- /Page Content -->
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/myScripts/shop/product/script.js') }}"></script>
@endsection
