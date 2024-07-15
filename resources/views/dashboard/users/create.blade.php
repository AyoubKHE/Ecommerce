<x-dashboard.master>

    <h2 class="text-center">Ajouter un utilisateur</h2>

    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a id="user-informations-link" class="nav-link active" aria-current="page" href="#"
                onclick="showUserInformationsForm()">Informations d'utilisateur</a>
        </li>

        <li class="nav-item" id="user-permissions-button">
            <a id="user-permissions-link" disabled class="nav-link" href="#"
                onclick="showUserPermissionsForm()">Permissions
                d'utilisateur</a>
        </li>

    </ul>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container py-3">

            <div id="user-informations-form">

                <label for="" class="form-label">Prénom</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" />
                @error('first_name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Nom</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" />
                @error('last_name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" />
                @error('username')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
                @error('email')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                @error('password')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Téléphone</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone') }}" />
                @error('phone')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Date de naissance</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" />
                @error('birth_date')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <div class="d-flex">
                    <label for="" class="form-label">Active:</label>

                    <div class="form-check">
                        <label class="form-check-label" style="margin-left: 8px" for="user-active-yes"> Oui </label>
                        <input class="form-check-input" id="user-active-yes" type="radio" name="is_active"
                            value="1" checked style="margin-left: 5px;" />
                    </div>
                    <div class="form-check" style="margin-left: 25px">
                        <label class="form-check-label" for="user-active-no">Non</label>
                        <input class="form-check-input" id="user-active-no" type="radio" name="is_active"
                            value="0" />
                    </div>
                </div>
                <br>

                <div class="d-flex align-items-center">
                    <label for="" class="form-label m-0">Role:</label>
                    <select name="role" id="user-role-select" style="margin-left: 10px; width: 1202px"
                        class="form-select h-25" id="inputGroupSelect01">
                        <option value="user">Utilisateur</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

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

            <div id="user-permissions-form" style="display: none">


                <div class="card" style="margin-top: 50px">
                    <h3 class="card-title" style="text-align: center">Les Permissions</h3>
                    <div class="card-body p-0">
                        <table class="table table-striped text-nowrap my-3">
                            <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Rien</th>
                                    <th>Lire</th>
                                    <th>Ajouter</th>
                                    <th>Mis à jour</th>
                                    <th>Supprimer</th>
                                    <th>Toutes</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data['systemPermissions'] as $system_permission)
                                    <tr>
                                        <td>{{ $system_permission }}</td>
                                        <td>
                                            <input type="checkbox" id="nothing-permissions-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="checkbox" id="read-permission-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="checkbox" id="add-permission-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="checkbox" id="update-permission-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="checkbox" id="delete-permission-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="checkbox" id="all-permissions-{{ $system_permission }}"
                                                >
                                        </td>
                                        <td>
                                            <input type="hidden" name="permissions[{{ $system_permission }}]" value="0">
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{-- @foreach ($data['systemPermissions'] as $system_permission)
                            <input type="hidden" name="permissions[{{ $system_permission }}]">
                        @endforeach --}}

                    </div>
                </div>




            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary mt-3" style="width: 30%;font-size: large;">
                    Ajouter
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>
        <script src="{{ asset('js/myScripts/users/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/users/create/user_informations.js') }}"></script>
        {{-- <script src="{{ asset('js/myScripts/users/create/user_permissions.js') }}"></script> --}}
    </x-slot>

</x-dashboard.master>
