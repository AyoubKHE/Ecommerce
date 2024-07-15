<x-dashboard.master>

    <h2 class="text-center">modifier l'utilisateur: {{ $data['user']['username'] }}</h2>

    <form action="{{ route('users.update', $data['user']['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex" style="margin-left: 10px">

            <label for="" class="form-label">Active:</label>

            <div class="form-check">
                <label class="form-check-label" style="margin-left: 8px" for="user-active-yes"> Oui </label>
                <input class="form-check-input" id="user-active-yes" type="radio" name="is_active" value="1"
                    {{ $data['user']['isActive'] === 1 ? 'checked' : '' }} style="margin-left: 5px;" />
            </div>
            <div class="form-check" style="margin-left: 25px">
                <label class="form-check-label" for="user-active-no">Non</label>
                <input class="form-check-input" id="user-active-no" type="radio" name="is_active" value="0"
                    {{ $data['user']['isActive'] === 0 ? 'checked' : '' }}>

            </div>

        </div>

        <div id="user-permissions-form">

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
                                        <input type="checkbox" id="nothing-permissions-{{ $system_permission->name }}"
                                            {{ $user_permission_value === 0 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="read-permission-{{ $system_permission->name }}"
                                            {{ ($user_permission_value & 1) === 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="add-permission-{{ $system_permission->name }}"
                                            {{ ($user_permission_value & 2) === 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="update-permission-{{ $system_permission->name }}"
                                            {{ ($user_permission_value & 4) === 4 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="delete-permission-{{ $system_permission->name }}"
                                            {{ ($user_permission_value & 8) === 8 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="all-permissions-{{ $system_permission->name }}"
                                            {{ $user_permission_value === -1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="hidden" name="permissions[{{ $system_permission->name }}]"
                                            value="{{ $user_permission_value }}">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        </div>

        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary mt-3" style="width: 30%;font-size: large;">
                Modifier
            </button>
        </div>
    </form>




    <x-slot:js>
        <script src="{{ asset('js/myScripts/users/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/users/edit/user_permissions.js') }}"></script>
    </x-slot>

</x-dashboard.master>
