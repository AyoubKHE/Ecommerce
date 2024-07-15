<x-dashboard.master>
    <div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title text-center" style="margin-top: 7px">Marques</h3>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <input style="width: 350px" class="form-control" type="search" name="search_by_brand_name"
                                id="search_by_brand_name" placeholder="Chercher par le nom de la marque...">

                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#makeFilter">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div>
                    <div>
                        <a type="button" class="btn btn-success" href="{{ route('brands.create') }}">
                            Ajouter une nouvelle Marque
                        </a>
                    </div>
                </div>

            </div>
            <div class="card-body p-0" id="brands-table">
                <x-dashboard.brands.brands_table :brands-data="$data['brandsData']" />
            </div>
        </div>
    </div>

    <x-dashboard.brands.brands_filter :filter-modal-data="$data['filterModalData']" />

    <x-slot:js>
        <script src="{{ asset('js/myScripts/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/brands/brands_search.js') }}"></script>
        <script src="{{ asset('js/myScripts/brands/brands_filter.js') }}"></script>
    </x-slot>

</x-dashboard.master>
