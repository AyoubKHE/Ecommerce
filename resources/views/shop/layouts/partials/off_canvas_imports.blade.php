<!-- Cart Offcanvas-->

<div class="offcanvas offcanvas-end d-none" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header d-flex align-items-center">
        <h5 class="offcanvas-title" id="offcanvasCartLabel">Votre panier</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column justify-content-between w-100 h-100">

            <div>

                {{-- <div class="mt-4 mb-5">
                    <p class="mb-2 fs-6"><i class="ri-truck-line align-bottom me-2"></i> À <span class="fw-bolder"> 500
                            DA </span> de la livraison gratuite</p>
                    <div class="progress f-h-1">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}

                @if ($cartData !== null)
                    @foreach ($cartData['items'] as $cartItem)
                        <div class="row mx-0 pb-4 mb-4 border-bottom"
                            id="cart-item-{{ $cartItem['cart_id'] }}-{{ $cartItem['productVariation_id'] }}">
                            <div class="col-3">
                                <picture class="d-block bg-light">

                                    @php
                                        $imagePath = collect($cartItem['variation']['product']['images'])
                                            ->filter(function ($image) {
                                                return $image['is_default'] == 1;
                                            })
                                            ->first()['image_path'];
                                    @endphp

                                    <img class="img-fluid" src="{{ asset('storage/' . $imagePath) }}"
                                        alt="Bootstrap 5 Template by Pixel Rocket">
                                </picture>
                            </div>
                            <div class="col-9">
                                <div>
                                    <h6 class="justify-content-between d-flex align-items-start mb-2">
                                        {{ $cartItem['variation']['product']['name'] }}
                                        <i class="ri-close-line"
                                            id="delete-cart-item-{{ $cartItem['cart_id'] }}-{{ $cartItem['productVariation_id'] }}"></i>
                                    </h6>

                                    @foreach ($cartItem['variation']['attributes_options_pivot'] as $attribute_option)
                                        <small
                                            class="d-block text-muted fw-bolder">{{ $attribute_option['attribute']['name'] }}:
                                            {{ $attribute_option['option']['value'] }}</small>
                                    @endforeach

                                    <br>
                                    <small class="d-block text-muted fw-bolder">Qty:
                                        {{ $cartItem['quantity'] }}</small>
                                </div>

                                <p class="fw-bolder text-end m-0"
                                    id="item-price-{{ $cartItem['cart_id'] }}-{{ $cartItem['productVariation_id'] }}">
                                    {{ $cartItem['price'] }} DA</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 style="text-align: center; font-family: cursive;">Votre panier est vide</h5>

                @endif



                {{-- <!-- Cart Product-->
                <div class="row mx-0 pb-4 mb-4 border-bottom">
                    <div class="col-3">
                        <picture class="d-block bg-light">
                            <img class="img-fluid" src="./assets/images/products/product-1.jpg"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </picture>
                    </div>
                    <div class="col-9">
                        <div>
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Mens StormBreaker Jacket
                                <i class="ri-close-line"></i>
                            </h6>
                            <small class="d-block text-muted fw-bolder">Size: Medium</small>
                            <small class="d-block text-muted fw-bolder">Qty: 1</small>
                        </div>
                        <p class="fw-bolder text-end m-0">$85.00</p>
                    </div>
                </div>

                <!-- Cart Product-->
                <div class="row mx-0 pb-4 mb-4 border-bottom">
                    <div class="col-3">
                        <picture class="d-block bg-light">
                            <img class="img-fluid" src="./assets/images/products/product-2.jpg"
                                alt="Bootstrap 5 Template by Pixel Rocket">
                        </picture>
                    </div>
                    <div class="col-9">
                        <div>
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Mens Torrent Terrain Jacket
                                <i class="ri-close-line"></i>
                            </h6>
                            <small class="d-block text-muted fw-bolder">Size: Medium</small>
                            <small class="d-block text-muted fw-bolder">Qty: 1</small>
                        </div>
                        <p class="fw-bolder text-end m-0">$99.00</p>
                    </div>
                </div> --}}

            </div>

            <div class="border-top pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0 fw-bolder">Total</p>
                    <p class="m-0 fw-bolder" id="cart-total-price">
                        {{ $cartData !== null ? $cartData['total_price'] : '0.00' }} DA</p>
                </div>

                <button class="btn btn-orange btn-orange-chunky mt-5 mb-2 d-block text-center" style="width: 100%"
                    {{ $cartData == null ? 'disabled' : '' }}>
                    <a href="{{ auth()->user() == null ? route('shop.auth.login.index') : route('shop.checkout') }}" style="text-decoration: none">Commander
                    </a>
                </button>

                {{-- <a href="./cart.html"
                    class="btn btn-dark fw-bolder d-block text-center transition-all opacity-50-hover">View
                    Cart</a> --}}
            </div>

        </div>
    </div>
</div>
