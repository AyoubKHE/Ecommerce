    <!-- Modal -->
    <div class="modal fade" id="makeFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filtrer les résultats</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">


                    <form action="">

                        {{-- <div class="row" style="margin-bottom: 10px">

                            <div class="col-1">
                                <label for="user-id" class="form-label my-form-label">Id:</label>
                            </div>

                            <div class="col-11" style="padding-right: 10px;">
                                <input type="number" class="form-control form-control-sm my-form-control"
                                    name="user_id" id="user-id" min="1">
                            </div>

                        </div> --}}

                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-6">

                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label for="user-id" class="form-label my-form-label">Id:</label>
                                    </div>

                                    <div class="col-10" style="padding-right: 10px;">
                                        <input type="number" class="form-control form-control-sm my-form-control"
                                            name="user_id" id="user-id" min="1">
                                    </div>
                                </div>


                            </div>

                            <div class="col-6">

                                <div class="row d-flex align-items-center">

                                    <div class="col-3">
                                        <label for="username" class="form-label my-form-label"
                                            style="margin-bottom: 0">Username:</label>
                                    </div>

                                    <div class="col-9" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="username" id="username">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-username" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-username-text"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-6">

                                <div class="row d-flex align-items-center">

                                    <div class="col-2">
                                        <label for="user-first-name" class="form-label my-form-label"
                                            style="margin-bottom: 0">Prénom:</label>
                                    </div>

                                    <div class="col-10" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="user_first_name" id="user-first-name">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-user-first-name" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-user-first-name-text"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">

                                <div class="row d-flex align-items-center">

                                    <div class="col-2">
                                        <label for="user-last-name" class="form-label my-form-label"
                                            style="margin-bottom: 0">Nom:</label>
                                    </div>

                                    <div class="col-10" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="user_last_name" id="user-last-name">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-user-last-name" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-user-last-name-text"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-6">

                                <div class="row d-flex align-items-center">

                                    <div class="col-2">
                                        <label for="user-email" class="form-label my-form-label"
                                            style="margin-bottom: 0">Email:</label>
                                    </div>

                                    <div class="col-10" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="user_email" id="user-email">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-user-email" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-user-email-text"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">

                                <div class="row d-flex align-items-center">

                                    <div class="col-3">
                                        <label for="user-phone" class="form-label my-form-label"
                                            style="margin-bottom: 0">Téléphone:</label>
                                    </div>

                                    <div class="col-9" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="user_phone" id="user-phone">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-user-phone" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-user-phone-text"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-4">
                                        <label for="created-by-username" style="margin-bottom: 5px"
                                            class="form-label">Ajouté par:</label>
                                    </div>

                                    <div class="col-8">
                                        <select name="created_by_username" class="form-select" id="created-by-username">
                                            <option value="All" selected>Tous les utilisateurs</option>
                                            @foreach ($filterModalData["usersNames"] as $user_name)
                                                <option value="{{ $user_name }}">{{ $user_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <label for="user-role" class="form-label m-0">Role:</label>
                                    </div>
                                    <div class="col-9">
                                        <select name="user_category_name" class="form-select"
                                            id="user-role">
                                            <option value="All" selected> Toutes les utilisateurs</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row d-flex align-items-center">

                            <div class="col-12">

                                <div class="row row d-flex align-items-center">
                                    <div class="col-2">
                                        <label class="form-label" style="margin-bottom: 0">Active:</label>
                                    </div>
                                    <div class="col-3" style="padding: 0; padding-left: 5px">
                                        <label class="form-check-label" for="yes">Oui</label>
                                        <input class="form-check-input" id="yes" type="radio" name="is_active"
                                            value="1" />
                                    </div>
                                    <div class="col-3" style="padding: 0">

                                        <label class="form-check-label" for="no">Non</label>
                                        <input class="form-check-input" id="no" type="radio" name="is_active"
                                            value="0" />
                                    </div>
                                    <div class="col-3" style="padding: 0">

                                        <label class="form-check-label" for="all">Tous</label>
                                        <input class="form-check-input" id="all" type="radio" name="is_active"
                                            value="all" checked />
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <label class="form-label">Date de naissance:</label>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="birth_date_from" style="width: 257px"
                                                id="birth-date-from" value={{$filterModalData["minBirthDate"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-birth-date-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-birth-date-from-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>À:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="birth_date_to" id="birth-date-to" style="width: 257px"
                                                value={{$filterModalData["maxBirthDate"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-birth-date-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-birth-date-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <label class="form-label">Date de création:</label>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="created_at_date_from"
                                                id="created-at-date-from" value={{$filterModalData["minCreatedAtDate"]}}>
                                            <span></span>
                                            <input type="time" name="created_at_time_from"
                                                id="created-at-time-from" value={{$filterModalData["minCreatedAtTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-created-at-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-created-at-from-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>À:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="created_at_date_to" id="created-at-date-to"
                                                value={{$filterModalData["maxCreatedAtDate"]}}>
                                            <span></span>
                                            <input type="time" name="created_at_time_to" id="created-at-time-to"
                                                value={{$filterModalData["maxCreatedAtTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-created-at-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-created-at-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <label class="form-label">Date de mis à jour:</label>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="updated_at_date_from"
                                                id="updated-at-date-from" value={{$filterModalData["minUpdatedAtDate"]}}>
                                            <span></span>
                                            <input type="time" name="updated_at_time_from"
                                                id="updated-at-time-from" value={{$filterModalData["minUpdatedAtTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-updated-at-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-updated-at-from-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>À:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="updated_at_date_to" id="updated-at-date-to"
                                                value={{$filterModalData["maxUpdatedAtDate"]}}>
                                            <span></span>
                                            <input type="time" name="updated_at_time_to" id="updated-at-time-to"
                                                value={{$filterModalData["maxUpdatedAtTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-updated-at-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-updated-at-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">

                            <label class="form-label">Dernière connexion:</label>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="last_login_date_from"
                                                id="last-login-date-from" value={{$filterModalData["minLastLoginDate"]}}>
                                            <span></span>
                                            <input type="time" name="last_login_time_from"
                                                id="last-login-time-from" value={{$filterModalData["minLastLoginTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-last-login-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-last-login-from-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>À:</label>
                                    </div>

                                    <div class="col-9">
                                        <div class="datetimepicker">
                                            <input type="date" name="last_login_date_to" id="last-login-date-to"
                                                value={{$filterModalData["maxLastLoginDate"]}}>
                                            <span></span>
                                            <input type="time" name="last_login_time_to" id="last-login-time-to"
                                                value={{$filterModalData["maxLastLoginTime"]}}>
                                        </div>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="last-login-at-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="last-login-at-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="apply">Appliqué</button>
                </div>
            </div>
        </div>
    </div>
