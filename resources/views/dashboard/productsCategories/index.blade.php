@php
    // dd($data["links"]);
@endphp
<x-dashboard.master>
    <div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title text-center" style="margin-top: 7px">Catégories</h3>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <input style="width: 350px" class="form-control" type="search" name="search_by_category_name"
                                id="search_by_category_name" placeholder="Chercher par le nom de la catégorie...">

                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#makeFilter">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div>
                    <div>
                        <a type="button" class="btn btn-success" href="{{ route('products-categories.create') }}">
                            Ajouter une nouvelle catégorie
                        </a>
                    </div>
                </div>

            </div>
            <div class="card-body p-0" id="products-categories-table">
                <x-dashboard.productsCategories.products_categories_table :products-categories-data="$data['productCategoriesData']" :links-data="$data['linksData']" />
            </div>
        </div>
    </div>

    <x-dashboard.productsCategories.products_categories_filter :filter-modal-data="$data['filterModalData']" />

    <x-slot:js>
        <script src="{{ asset('js/myScripts/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/products_categories/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/products_categories/products_categories_search.js') }}"></script>
        <script src="{{ asset('js/myScripts/products_categories/products_categories_filter.js') }}"></script>
    </x-slot>

</x-dashboard.master>
