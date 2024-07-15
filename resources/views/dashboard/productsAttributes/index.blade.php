<x-dashboard.master>
    <div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title text-center" style="margin-top: 7px">Attributs</h3>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <input style="width: 350px" class="form-control" type="search" name="search_by_atribute_name"
                                id="search_by_attribute_name" placeholder="Chercher par le nom de l'attribut...">

                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#makeFilter">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div>
                    <div>
                        <a type="button" class="btn btn-success" href="{{ route('products-attributes.create') }}">
                            Ajouter un nouveau Attribut
                        </a>
                    </div>
                </div>

            </div>
            <div class="card-body p-0" id="brands-table">
                <x-dashboard.productsAttributes.products_attributes_table :products-attributes-data="$data['productsAttributesData']" />
            </div>
        </div>
    </div>

    {{-- <x-dashboard.productsAttributes.products_attributes_filter :filter-modal-data="$data['filterModalData']" /> --}}

    <x-slot:js>
        {{-- <script src="{{ asset('js/myScripts/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/brands/brands_search.js') }}"></script>
        <script src="{{ asset('js/myScripts/brands/brands_filter.js') }}"></script> --}}
    </x-slot>

</x-dashboard.master>
