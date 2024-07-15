
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

                    <div class="row" style="margin-bottom: 10px">

                        <div class="col-1">
                            <label for="category-id" class="form-label my-form-label">Id:</label>
                        </div>

                        <div class="col-11" style="padding-right: 10px;">
                            <input type="number" class="form-control form-control-sm my-form-control"
                                name="category_id" id="category-id" min="1">
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 10px">

                        <div class="col-5">

                            <div class="row d-flex align-items-center">

                                <div class="col-2">
                                    <label for="category-name" class="form-label my-form-label"
                                        style="margin-bottom: 0">Nom:</label>
                                </div>

                                <div class="col-10" style="padding-right: 10px;">
                                    <input type="text" class="form-control form-control-sm my-form-control"
                                        name="category_name" id="category-name">
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-category-name" style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-category-name-text"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-7">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="created-by-username" style="margin-bottom: 5px"
                                        class="form-label">Ajouté par:</label>
                                </div>

                                <div class="col-8">
                                    <select name="created_by_username" class="form-select" id="created-by-username">
                                        <option value="All" selected>Tous les utilisateurs</option>
                                        @foreach ($filterModalData['usersNames'] as $user_name)
                                            <option value="{{ $user_name }}">{{ $user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>




                    </div>

                    <div class="row d-flex align-items-center">

                        <div class="col-12 col-lg-5">

                            <div class="row row d-flex align-items-center">
                                <div class="col-3">
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

                        <div class="col-12 col-lg-7">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="base-category-name" class="form-label m-0">Catégorie de
                                        base:</label>
                                </div>
                                <div class="col-8">
                                    <select name="base_category_name" class="form-select" id="base-category-name">
                                        <option value="All" selected> Toutes les catégories</option>
                                        @foreach ($filterModalData['productsCategoriesNames'] as $category_name)
                                            <option value="{{ $category_name }}">{{ $category_name }}</option>
                                        @endforeach
                                    </select>
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
                                        <input type="date" name="created_at_date_from" id="created-at-date-from"
                                            value={{ $filterModalData['minCreatedAtDate'] }}>
                                        <span></span>
                                        <input type="time" name="created_at_time_from" id="created-at-time-from"
                                            value={{ $filterModalData['minCreatedAtTime'] }}>
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
                                            value={{ $filterModalData['maxCreatedAtDate'] }}>
                                        <span></span>
                                        <input type="time" name="created_at_time_to" id="created-at-time-to"
                                            value={{ $filterModalData['maxCreatedAtTime'] }}>
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
                                        <input type="date" name="updated_at_date_from" id="updated-at-date-from"
                                            value={{ $filterModalData['minUpdatedAtDate'] }}>
                                        <span></span>
                                        <input type="time" name="updated_at_time_from" id="updated-at-time-from"
                                            value={{ $filterModalData['minUpdatedAtTime'] }}>
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
                                            value={{ $filterModalData['maxUpdatedAtDate'] }}>
                                        <span></span>
                                        <input type="time" name="updated_at_time_to" id="updated-at-time-to"
                                            value={{ $filterModalData['maxUpdatedAtTime'] }}>
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

                        <label class="form-label">Quantité de produits:</label>

                        <div class="col-12 col-md-6">
                            <div class="row d-flex align-items-center">
                                <div class="col-1">
                                    <label>De:</label>
                                </div>

                                <div class="col-9">
                                    <input type="number" class="form-control form-control-sm my-form-control"
                                        name="quantity_of_products_from" id="quantity-of-products-from"
                                        min="0" value={{ $filterModalData['minQuantityOfProducts'] }}>
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-quantity-of-products-from" style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-quantity-of-products-from-text"></div>
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
                                    <input type="number" class="form-control form-control-sm my-form-control"
                                        name="quantity_of_products_to" id="quantity-of-products-to" min="0"
                                        value={{ $filterModalData['maxQuantityOfProducts'] }}>
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-quantity-of-products-to" style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-quantity-of-products-to-text"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <label class="form-label">Quantité de produits Actifs:</label>

                        <div class="col-12 col-md-6">
                            <div class="row d-flex align-items-center">
                                <div class="col-1">
                                    <label>De:</label>
                                </div>

                                <div class="col-9">
                                    <input type="number" class="form-control form-control-sm my-form-control"
                                        name="quantity_of_actif_products_from" id="quantity-of-actif-products-from"
                                        min="0" value={{ $filterModalData['minQuantityOfActiveProducts'] }}>
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-quantity-of-actif-products-from"
                                        style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-quantity-of-actif-products-from-text">
                                        </div>
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
                                    <input type="number" class="form-control form-control-sm my-form-control"
                                        name="quantity_of_actif_products_to" id="quantity-of-actif-products-to"
                                        min="0" value={{ $filterModalData['maxQuantityOfActiveProducts'] }}>
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-quantity-of-actif-products-to"
                                        style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-quantity-of-actif-products-to-text"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">

                        <div class="col-12">

                            <label for="category-description" class="form-label">Description:</label>

                            <div class="row d-flex align-items-center">
                                <div class="col-12" style="padding-right: 10px;">
                                    <textarea class="form-control" name="category_description" id="category-description"></textarea>
                                </div>

                                <div class="col-1" style="padding-left: 0px;">
                                    <div class="my-tooltip" id="ep-category-description" style="display: none">
                                        <div class="icon">!</div>
                                        <div class="my-tooltiptext" id="ep-category-description-text"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="apply">Appliqué</button>
            </div>
        </div>
    </div>
</div>
