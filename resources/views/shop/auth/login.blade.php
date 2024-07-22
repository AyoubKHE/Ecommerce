<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset("css/auth_styles/login_style.css") }}">
    <link rel="stylesheet" href="{{ asset("css/auth_styles/form_style.css") }}">

    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Login</title>
</head>

<body>

    <section class="container my-container">

        <x-messages.flashbag />

        <div class="row align-items-center" style="height: 80vh;">

            <div class="col-12">

                <form class="form" method="POST" action="{{ route('shop.auth.login.login') }}">

                    @csrf

                    <div style="text-align: center; color: rgb(123, 123, 123);">
                        <i class="fa fa-user-circle-o fa-5x my-icon" aria-hidden="true"></i>
                    </div>

                    <div class="inputForm">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="email" class="input" name="email" id="input-email" placeholder="Email"
                            value="{{ old('username') }}">

                    </div>
                    @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="inputForm">
                        <i class="fa fa-lock" aria-hidden="true"></i>

                        <input type="password" class="input" name="password" id="input-password"
                            placeholder="Mot de passe" value="{{ old('password') }}">

                        {{-- <i class="fa fa-eye" id="eye" aria-hidden="true"></i> --}}

                    </div>
                    @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- <div class="flex-row">
                        <div>
                            <input type="checkbox" id="chk-retain-password">
                            <label>Retenir le Mot de passe </label>
                        </div>

                        <!-- <span class="span">Mot de passe oublié ?</span> -->
                    </div> --}}

                    <button class="button-submit" id="btn-login">Se Connecter</button>

                    <a class="btn btn-success" style="background-color: #7f857a; margin-top: 0" href="{{ route("shop.auth.register.form") }}">S'inscrire</a>

                </form>

            </div>

        </div>


    </section>

    <script src="{{ asset('js/myScripts/auth/login.js') }}"></script>

    {{-- <script src="{{ asset("assets/js/auth/login.js") }}"></script> --}}

</body>

</html>
