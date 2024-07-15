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
                                <label for="product-id" class="form-label my-form-label">Id:</label>
                            </div>

                            <div class="col-11" style="padding-right: 10px;">
                                <input type="number" class="form-control form-control-sm my-form-control"
                                    name="product_id" id="product-id" min="1">
                            </div>

                        </div>

                        <div class="row" style="margin-bottom: 10px">

                            <div class="col-5">

                                <div class="row d-flex align-items-center">

                                    <div class="col-2">
                                        <label for="product-name" class="form-label my-form-label"
                                            style="margin-bottom: 0">Nom:</label>
                                    </div>

                                    <div class="col-10" style="padding-right: 10px;">
                                        <input type="text" class="form-control form-control-sm my-form-control"
                                            name="product_name" id="product-name">
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-product-name" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-product-name-text"></div>
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
                                            @foreach ($filterModalData["usersNames"] as $user_name)
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
                                        <label for="product-category-name" class="form-label m-0">Catégorie:</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="product_category_name" class="form-select"
                                            id="product-category-name">
                                            <option value="All" selected> Toutes les catégories</option>
                                            @foreach ($filterModalData["productsCategoriesNames"] as $product_category_name)
                                                <option value="{{ $product_category_name }}">{{ $product_category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-bottom: 10px; margin-top: 20px">

                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <label for="brand-name" class="form-label m-0">Marque:</label>
                                </div>
                                <div class="col-10">
                                    <select name="brand_name" class="form-select"
                                        id="brand-name">
                                        <option value="All" selected> Toutes les Marques</option>
                                        @foreach ($filterModalData["brandsNames"] as $brand_name)
                                            <option value="{{ $brand_name }}">{{ $brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <label class="form-label">Prix:</label>

                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <input type="number" class="form-control form-control-sm my-form-control"
                                            name="price_from" id="price-from"
                                            min="0" value={{ $filterModalData["minPrice"] }}>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-price-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-price-from-text"></div>
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
                                            name="price_to" id="price-to" min="0"
                                            value={{ $filterModalData["maxPrice"] }}>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-price-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-price-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex align-items-center">

                            <label class="form-label">Note:</label>

                            <div class="col-12 col-md-3">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>De:</label>
                                    </div>

                                    <div class="col-9">
                                        <input type="number" class="form-control form-control-sm my-form-control"
                                            name="rating_from" id="rating-from"
                                            min="0" value={{ $filterModalData["minRating"] }}>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-rating-from" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-rating-from-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="row d-flex align-items-center">
                                    <div class="col-1">
                                        <label>À:</label>
                                    </div>

                                    <div class="col-9">
                                        <input type="number" class="form-control form-control-sm my-form-control"
                                            name="rating_to" id="rating-to" min="0"
                                            value={{ $filterModalData["maxRating"] }}>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-rating-to" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-rating-to-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-11">
                                        <label class="form-label" for="include-null-rating" style="margin-bottom: 0">Inclure les produit qui ne possède pas de note:</label>
                                    </div>
                                    <div class="col-1" style="padding: 0; padding-left: 5px">
                                        <input class="form-check-input" type="checkbox" id="include-null-rating" checked/>
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

                        <div class="row">

                            <div class="col-12">

                                <label for="product-description" class="form-label">Description:</label>

                                <div class="row d-flex align-items-center">
                                    <div class="col-12" style="padding-right: 10px;">
                                        <textarea class="form-control" name="product_description" id="product-description"></textarea>
                                    </div>

                                    <div class="col-1" style="padding-left: 0px;">
                                        <div class="my-tooltip" id="ep-product-description" style="display: none">
                                            <div class="icon">!</div>
                                            <div class="my-tooltiptext" id="ep-product-description-text"></div>
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
