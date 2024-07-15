<x-dashboard.master>

    <h2 class="text-center">modifier mon compte</h2>

    <form action="{{ route('users.updateCurrentUser', $data['user']->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div id="user-informations-form">

            <input type="hidden" name="id" value="{{ $data['user']->id }}">

            <label for="" class="form-label">Prénom</label>
            <input type="text" name="first_name" class="form-control" value="{{ $data['user']->first_name }}" />
            @error('first_name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Nom</label>
            <input type="text" name="last_name" class="form-control" value="{{ $data['user']->last_name }}" />
            @error('last_name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $data['user']->username }}" />
            @error('username')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="{{ $data['user']->email }}" />
            @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" value="" />
            @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Téléphone</label>
            <input type="number" name="phone" class="form-control" value="{{ $data['user']->phone }}" />
            @error('phone')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Date de naissance</label>
            <input type="date" name="birth_date" class="form-control" value="{{ $data['user']->birth_date }}" />
            @error('birth_date')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Image de l'utilisateur</label>
            <input type="file" name="user_image" class="form-control" />
            @error('user_image')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

        </div>

        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary mt-3" style="width: 30%;font-size: large;">
                Modifier
            </button>
        </div>
    </form>




    <x-slot:js>
        {{-- <script src="{{ asset('js/myScripts/users/edit/user_permissions.js') }}"></script> --}}
    </x-slot>

</x-dashboard.master>
