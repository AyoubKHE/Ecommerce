@extends('shop.layouts.master', [
    'navCategories' => $data['navCategories'],
    'cartData' => null,
    'showCartCanva' => false,
])

@section('content')

    <x-messages.flashbag />

    <div class="container" style="margin-left: 350px; margin-top: 20px">
        <form action="{{ route('shop.auth.register.register') }}" method="POST">

            @csrf

            <div class="col-12 col-lg-6 col-xl-7">
                <!-- Checkout Panel Contact -->
                <div class="checkout-panel">
                    <h5 class="title-checkout">Coordonnées</h5>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="firstName" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="last_name">
                            </div>
                            @error('last_name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Last Name-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lastName" class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="first_name">
                            </div>
                            @error('first_name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <!-- Email-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@example.com">
                                @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Mailing List Signup-->
                            <div class="form-group form-check m-0">
                                <input type="checkbox" class="form-check-input" name="add_to_mailing_list"
                                    id="add-mailinglist">
                                <label class="form-check-label" for="add-mailinglist">Tenez-moi au courant de vos dernières
                                    nouvelles et offres</label>
                            </div>
                        </div>


                        <!-- Phone-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lastName" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            @error('phone')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    {{-- <div class="row">

                        <!-- Email-->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@example.com">
                                @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Mailing List Signup-->
                            <div class="form-group form-check m-0">
                                <input type="checkbox" class="form-check-input" name="add_to_mailing_list"
                                    id="add-mailinglist">
                                <label class="form-check-label" for="add-mailinglist">Tenez-moi au courant de vos dernières
                                    nouvelles et offres</label>
                            </div>
                        </div>
                    </div> --}}

                    <br>

                    <div class="row">

                        <!-- Email-->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">

                        <!-- Email-->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Confirmation du mot de passe</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%" id="btn-login">S'inscrire</button>

                </div>

            </div>
        </form>
    </div>
@endsection
