
<x-dashboard.master>

    <div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title text-center" style="margin-top: 7px">Utilisateurs</h3>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <input style="width: 350px" class="form-control" type="search" name="search_by_username"
                                id="search_by_username" placeholder="Chercher par le username...">

                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#makeFilter">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div>
                    <div>
                        <a type="button" class="btn btn-success" href="{{ route('users.create') }}">
                            Ajouter un nouveau utilisateur
                        </a>
                    </div>
                </div>

            </div>
            <div class="card-body p-0" id="users-table">
                <x-dashboard.users.users_table :users-data="$data['usersData']" />
            </div>
        </div>
    </div>

    <x-dashboard.users.users_filter :filter-modal-data="$data['filterModalData']"/>

    <x-slot:js>
        <script src="{{ asset('js/myScripts/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/users/users_search.js') }}"></script>
        <script src="{{ asset('js/myScripts/users/users_filter.js') }}"></script>
    </x-slot>

</x-dashboard.master>
