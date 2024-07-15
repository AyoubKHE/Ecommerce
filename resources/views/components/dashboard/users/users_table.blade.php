<table class="table table-striped text-nowrap my-3">

    <thead>
        <tr>
            <th>Id</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Username</th>
            {{-- <th>Email</th>
            <th>Phone</th>
            <th>Date de naissance</th> --}}
            <th>Active</th>
            <th>Role</th>
            <th>Créé le</th>
            <th>Mis à jour le</th>
            <th>Dernière connexion</th>
            <th>Ajouté par</th>
            {{-- <th>Supprimé(e)</th> --}}

        </tr>
    </thead>

    <tbody>

        @if (count($usersData->items()) == 0)
            <tr>
                <td colspan="9" style="height: 200px; padding-top: 90px; text-align: center; font-weight: 700">
                    Aucun Utilisateur n'a été trouvée.
                </td>
            </tr>
        @else
            @foreach ($usersData->items() as $userData)
                <tr>

                    <td class="product_data">{{ $userData->id }}</td>
                    <td class="product_data">{{ $userData->first_name }}</td>
                    <td class="product_data">{{ $userData->last_name }}</td>
                    <td class="product_data">{{ $userData->username }}</td>
                    {{-- <td class="product_data">{{ $userData->email }}</td>
                    <td class="product_data">{{ $userData->phone }}</td>
                    <td class="product_data">{{ $userData->birth_date }}</td> --}}
                    <td class="product_category_data"
                        style="background-color: {{ $userData->is_active === 1 ? '#198754' : 'red' }}; color: white; text-align: center">
                        {{ $userData->is_active === 1 ? 'Oui' : 'Non' }}
                    </td>

                    <td class="product_data">{{ $userData->role }}</td>

                    <td class="product_data">{{ $userData->created_at }}</td>
                    <td class="product_data">{{ $userData->updated_at }}</td>
                    <td class="product_data">{{ $userData->last_login !== null ? $userData->last_login : 'N/A' }}</td>
                    <td class="product_data">{{ $userData->added_by_username !== null ? $userData->added_by_username : 'N/A' }}</td>
                    {{-- <td class="product_category_data"
                        style="background-color: {{ $userData->deleted_at === null ? '#198754' : 'red' }}; color: white; text-align: center">
                        {{ $userData->deleted_at === null ? 'Oui' : 'Non' }}
                    </td> --}}
                    <td class="project-actions text-right d-flex justify-content-evenly">
                        <a class="btn btn-primary btn-sm" style="width: 100px"
                            href="{{ route('users.show', $userData->id) }}">
                            <i class="fas fa-folder">
                            </i>
                            Afficher
                        </a>
                        <a class="btn btn-info btn-sm" style="width: 100px"
                            href="{{ route('users.edit', $userData->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Modifier
                        </a>
                        <form action="{{ route('users.destroy', $userData->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width: 100px"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                <i class="fas fa-trash">
                                </i>
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif


    </tbody>

</table>
{{ $usersData->links() }}
