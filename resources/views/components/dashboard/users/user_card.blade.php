@php
    // dd($data);
@endphp

<div class="container" style="width: 70%">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="text-align: center">{{ $data['userData']->name }}</h2>
        <div class="btn-container d-flex gap-1" style="padding-left: 100px">
            <div>
                <a class="btn btn-primary" href="{{ route('users.edit', $data['userData']->id) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Modifier
                </a>
            </div>

            <form action="{{ route('users.destroy', $data['userData']->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette utilisateur ?');">
                    <i class="fas fa-trash">
                    </i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <img src="{{ asset('storage/' . $data['userData']->image_path) }}" alt="Image de du produit"
        class="category-image w-100 border border-1 rounded" style="height: 400px">

    <div class="details d-flex">
        <div style="width: 50%">

            <p><strong>Id:</strong> {{ $data['userData']->id }}</p>
            <p><strong>Prénom:</strong> {{ $data['userData']->first_name }}</p>
            <p><strong>Nom:</strong> {{ $data['userData']->last_name }}</p>
            <p><strong>Username:</strong> {{ $data['userData']->username }}</p>
            <p><strong>Créé le:</strong> {{ $data['userData']->created_at }}</p>
            <p><strong>Modifié le:</strong> {{ $data['userData']->updated_at }}</p>
            <p><strong>Role:</strong> {{ $data['userData']->role }}</p>

        </div>
        <div style="width: 70%">

            <p><strong>Email:</strong> {{ $data['userData']->email }}</p>
            <p><strong>Téléphone:</strong> {{ $data['userData']->phone }}</p>
            <p><strong>Date de naissance:</strong> {{ $data['userData']->birth_date }}</p>
            <p><strong>Dernière connexion:</strong> {{ $data['userData']->last_login }}</p>
            <p><strong>Ajouté par:</strong> {{ $data['userData']->added_by_username }}</p>
            <p>
                <strong>Active:</strong>
                <small
                    style="background-color: {{ $data['userData']->is_active === 1 ? 'green' : 'red' }}; color: white">
                    {{ $data['userData']->is_active === 1 ? 'Oui' : 'Non' }}
                </small>
            </p>
        </div>

    </div>



    @isset($data['userPermissions'])
        <div id="user-permissions">

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
                                @php
                                    $user_permission_value = $data['userPermissions']->systemPermissionsPivot
                                        ->filter(function ($systemPermissionPivot) use ($system_permission) {
                                            return $systemPermissionPivot->systemPermission_id ===
                                                $system_permission->id;
                                        })
                                        ->first()->value;

                                @endphp

                                <tr>
                                    <td>{{ $system_permission->name }}</td>
                                    <td>
                                        <input type="radio" {{ $user_permission_value === 0 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="radio" {{ ($user_permission_value & 1) === 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="radio" {{ ($user_permission_value & 2) === 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="radio" {{ ($user_permission_value & 4) === 4 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="radio" {{ ($user_permission_value & 8) === 8 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="radio" {{ $user_permission_value === -1 ? 'checked' : '' }}>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    @endisset



</div>
