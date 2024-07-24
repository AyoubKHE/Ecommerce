@extends('shop.layouts.master', [
    'navCategories' => $data['navCategories'],
    'cartData' => null,
    'showCartCanva' => false,
])

@section('content')
    <section class="mt-5 container ">
        <!-- Page Content Goes Here -->

        <h1 class="mb-4 display-5 fw-bold text-center">Commander en toute sécurité</h1>
        {{-- <p class="text-center mx-auto">Veuillez remplir les détails ci-dessous pour finaliser votre commande. Déjà enregistré?
            <a href="#">Connectez-vous ici.</a>
        </p> --}}

        <form action="{{ route('shop.checkout.validation') }}" method="POST">

            @csrf

            <div class="row g-md-8 mt-4">
                <!-- Checkout Panel Left -->
                <div class="col-12 col-lg-6 col-xl-7">

                    <!-- /Checkout Panel Contact --> <!-- Checkout Shipping Address -->
                    <div class="checkout-panel">
                        <h5 class="title-checkout">Adresse de livraison</h5>
                        <div class="row">

                            <!-- Address-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>

                            <!-- Wilaya-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="form-label">Wilaya</label>
                                    <select class="form-select" id="wilayas-select" name="wilaya">
                                        <option value="">Veuillez sélectionner...</option>
                                        @foreach ($data['wilayas'] as $wilaya)
                                            <option data-wilaya-id="{{ $wilaya['id'] }}" value="{{ $wilaya['name'] }}"
                                                {{ $wilaya['name'] == 'Béjaïa' ? 'selected' : '' }}>{{ $wilaya['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Commune-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state" class="form-label">Commune</label>
                                    <select class="form-select" id="communes-select" name="commune">
                                        <option value="">Veuillez sélectionner...</option>
                                        @foreach ($data['BejaiaCommunes'] as $commune)
                                            <option value="{{ $commune['name'] }}">{{ $commune['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>

                        {{-- <div class="pt-4 mt-4 border-top d-flex justify-content-between align-items-center">
                            <!-- Shipping Same Checkbox-->
                            <div class="form-group form-check m-0">
                                <input type="checkbox" class="form-check-input" id="same-address" checked>
                                <label class="form-check-label" for="same-address">Use for billing address</label>
                            </div>
                        </div> --}}
                    </div>
                    <!-- /Checkout Shipping Address --> <!-- Checkout Billing Address-->
                    {{-- <div class="billing-address checkout-panel d-none">
                        <h5 class="title-checkout">Billing Address</h5>
                        <div class="row">
                            <!-- First Name-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="firstNameAddress" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstNameAddress" placeholder=""
                                        value="" required="">
                                </div>
                            </div>

                            <!-- Last Name-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lastNameAddress" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastNameAddress" placeholder=""
                                        value="" required="">
                                </div>
                            </div>

                            <!-- Address-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="addressAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="addressAddress"
                                        placeholder="123 Some Street Somewhere" required="">
                                </div>
                            </div>

                            <!-- Country-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="countryAddress" class="form-label">Country</label>
                                    <select class="form-select" id="countryAddress" required="">
                                        <option value="">Please Select...</option>
                                        <option>United States</option>
                                    </select>
                                </div>
                            </div>

                            <!-- State-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stateAddress" class="form-label">State</label>
                                    <select class="form-select" id="stateAddress" required="">
                                        <option value="">Please Select...</option>
                                        <option>California</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Post Code-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zipAddress" class="form-label">Zip/Post Code</label>
                                    <input type="text" class="form-control" id="zipAddress" placeholder=""
                                        required="">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- / Checkout Billing Address--> <!-- Checkout Shipping Method-->
                    <div class="checkout-panel">
                        <h5 class="title-checkout">Méthode de livraison</h5>

                        <!-- Shipping Option-->
                        <div class="form-check form-group form-check-custom form-radio-custom mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping-method-1"
                                checked value="from_store" data-price="0">
                            <label class="form-check-label" for="shipping-method-1">
                                <span class="d-flex justify-content-between align-items-start w-100">
                                    <span>
                                        <span class="mb-0 fw-bolder d-block">Commande en ligne, collecte en magasin</span>
                                        <small class="fw-bolder">Récupérez depuis notre magasin</small>
                                    </span>
                                    <span class="small fw-bolder text-uppercase">Gratuit</span>
                                </span>
                            </label>
                        </div>

                        <!-- Shipping Option-->
                        <div class="form-check form-group form-check-custom form-radio-custom mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping-method-2"
                                value="yalidine" data-price="300">
                            <label class="form-check-label" for="shipping-method-2">
                                <span class="d-flex justify-content-between align-items-start">
                                    <span>
                                        <span class="mb-0 fw-bolder d-block">Yalidine</span>
                                        <small class="fw-bolder">Opérateur de courrier Express en régime domestique</small>
                                    </span>
                                    <span class="small fw-bolder text-uppercase">300 DA</span>
                                </span>
                            </label>
                        </div>

                        <!-- Shipping Option-->
                        {{-- <div class="form-check form-group form-check-custom form-radio-custom mb-3">
                            <input class="form-check-input" type="radio" name="checkoutShippingMethod"
                                id="checkoutShippingMethodThree">
                            <label class="form-check-label" for="checkoutShippingMethodThree">
                                <span class="d-flex justify-content-between align-items-start">
                                    <span>
                                        <span class="mb-0 fw-bolder d-block">Service prioritaire DHL</span>
                                        <small class="fw-bolder">Livraison 24 à 36 heures</small>
                                    </span>
                                    <span class="small fw-bolder text-uppercase">300 DA</span>
                                </span>
                            </label>
                        </div> --}}
                    </div>
                    <!-- /Checkout Shipping Method --> <!-- Checkout Payment Method-->
                    <div class="checkout-panel">
                        <h5 class="title-checkout">Informations de paiement</h5>

                        <div class="row">
                            <!-- Payment Option-->
                            <div class="col-12">
                                <div class="form-check form-group form-check-custom form-radio-custom mb-3">
                                    <input class="form-check-input" type="radio" name="checkoutPaymentMethod"
                                        id="checkoutPaymentStripe" checked>
                                    <label class="form-check-label" for="checkoutPaymentStripe">
                                        <span class="d-flex justify-content-between align-items-start">
                                            <span>
                                                <span class="mb-0 fw-bolder d-block">Carte de crédit (Chargily epay)</span>
                                            </span>
                                            <i class="ri-bank-card-line"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Payment Option-->
                            <div class="col-12">
                                <div class="form-check form-group form-check-custom form-radio-custom mb-3">
                                    <input class="form-check-input" type="radio" name="checkoutPaymentMethod"
                                        id="checkoutPaymentPaypal">
                                    <label class="form-check-label" for="checkoutPaymentPaypal">
                                        <span class="d-flex justify-content-between align-items-start">
                                            <span>
                                                <span class="mb-0 fw-bolder d-block">PayPal</span>
                                            </span>
                                            <i class="ri-paypal-line"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- <!-- Payment Details-->
                        <div class="card-details">
                            <div class="row pt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cc-name" class="form-label">Nom sur la carte</label>
                                        <input type="text" class="form-control" id="cc-name" name="credit_card_name">
                                        <small class="text-muted">Nom complet tel qu'affiché sur la carte</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cc-number" class="form-label">Numéro de Carte de Crédit</label>
                                        <input type="text" class="form-control" id="cc-number" name="credit_card_number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cc-expiration" class="form-label">Expiration</label>
                                        <input type="date" class="form-control" id="cc-expiration"
                                            name="creadit_card_expiration_date">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="d-flex">
                                            <label for="cc-cvv"
                                                class="form-label d-flex w-100 justify-content-between align-items-center">Code
                                                de sécurité</label>
                                            <button type="button" class="btn btn-link p-0 fw-bolder fs-xs text-nowrap"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Un CVV est un numéro sur votre carte de crédit ou de débit qui s'ajoute au numéro de votre carte de crédit et à sa date d'expiration.">
                                                Qu'est-ce que c'est ça?
                                            </button>
                                        </div>
                                        <input type="text" class="form-control" id="cc-cvv"
                                            name="credit_card_password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Payment Details--> --}}

                        <!-- Paypal Info-->
                        <div class="paypal-details bg-light p-4 d-none mt-3 fw-bolder">
                            Please click on complete order. You will then be transferred to Paypal to enter your payment
                            details.
                        </div>
                        <!-- /Paypal Info-->
                    </div>
                    <!-- /Checkout Payment Method-->
                </div>
                <!-- / Checkout Panel Left -->

                <!-- Checkout Panel Summary -->
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="bg-light p-4 sticky-md-top top-5">


                        <div class="border-bottom pb-3">
                            <!-- Cart Item-->

                            @if ($data['cartData'] != null)
                                @foreach ($data['cartData']['items'] as $cartItem)
                                    <div class="d-none d-md-flex justify-content-between align-items-start py-2">
                                        <div class="d-flex flex-grow-1 justify-content-start align-items-start">
                                            <div class="position-relative f-w-20 border p-2 me-4">
                                                <span class="checkout-item-qty">{{ $cartItem['quantity'] }}</span>
                                                {{-- <img src="./assets/images/products/product-1.jpg" alt=""
                                                class="rounded img-fluid"> --}}

                                                @php
                                                    $imagePath = collect($cartItem['variation']['product']['images'])
                                                        ->filter(function ($image) {
                                                            return $image['is_default'] == 1;
                                                        })
                                                        ->first()['image_path'];
                                                @endphp


                                                <img class="rounded img-fluid" src="{{ asset('storage/' . $imagePath) }}"
                                                    alt="">
                                            </div>
                                            <div>
                                                <p class="mb-1 fs-6 fw-bolder">
                                                    {{ $cartItem['variation']['product']['name'] }}
                                                </p>

                                                @php
                                                    $options = '';
                                                    foreach (
                                                        $cartItem['variation']['attributes_options_pivot']
                                                        as $attribute_option
                                                    ) {
                                                        $options =
                                                            $options . $attribute_option['option']['value'] . ' / ';
                                                    }

                                                    $options = substr($options, 0, -2);

                                                @endphp

                                                <span
                                                    class="fs-xs text-uppercase fw-bolder text-muted">{{ $options }}</span>

                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 fw-bolder">
                                            <span>{{ $cartItem['price'] }} DA</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5 style="text-align: center; font-family: cursive;">Votre panier est vide</h5>
                            @endif



                            <!-- / Cart Item-->
                        </div>
                        <div class="py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="m-0 fw-bolder fs-6">Sous-Total</p>
                                <p class="m-0 fs-6 fw-bolder" id="sous-total">
                                    {{ $data['cartData'] != null ? $data['cartData']['total_price'] : 0.0 }} DA</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <p class="m-0 fw-bolder fs-6">Expédition</p>
                                <p class="m-0 fs-6 fw-bolder" id="shipping-price">0 DA</p>
                            </div>
                        </div>
                        <div class="py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="m-0 fw-bold fs-5">Total</p>
                                    {{-- <span class="text-muted small">Incluant 100 DA de taxe de vente</span> --}}
                                </div>
                                <p class="m-0 fs-5 fw-bold" id="price-total">
                                    {{ $data['cartData'] != null ? $data['cartData']['total_price'] : 0.0 }} DA</p>
                            </div>
                        </div>
                        {{-- <div class="py-3 border-bottom">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control" placeholder="Enter your coupon code">
                                <button class="btn btn-dark btn-sm px-4">Apply</button>
                            </div>
                        </div> --}}
                        <!-- Accept Terms Checkbox-->
                        <div class="form-group form-check my-4">
                            <input type="checkbox" class="form-check-input" id="accept-terms" checked>
                            <label class="form-check-label fw-bolder" for="accept-terms">J'accepte les conditions
                                générales
                                d'Eleganza <a href="#">termes &
                                    conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-dark w-100" role="button">Valider la commande</button>
                    </div>
                </div>
                <!-- /Checkout Panel Summary -->
            </div>
        </form>



        <!-- /Page Content -->
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/myScripts/shop/checkout/script.js') }}"></script>
@endsection
