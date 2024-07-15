<x-dashboard.master>

    <div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title text-center" style="margin-top: 7px">
                    Modifier l'apparence de l'entête de votre boutique en ligne
                </h3>
            </div>
            <form action="{{ route('showcase.header.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body p-0" id="categories-table">
                    <div class="card" style="margin-top: 50px">
                        <h3 class="card-title" style="text-align: center">Veuillez choisir les catégories à afficher
                            dans
                            l'entête</h3>
                        <div class="card-body p-0"
                            style="overflow-y: scroll; height: {{ count($data['productCategoriesData']) * 50 }}; max-height: 400px">
                            <table class="table table-striped text-nowrap my-3">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Ajouté par</th>
                                        <th>Active</th>
                                        <th>Quantité de<br>sous catégories</th>
                                        <th>Quantité de<br>produits</th>
                                        <th>Quantité de<br>produits actifs</th>
                                        <th>Catégorie<br>de base</th>
                                        <th>Afficher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['productCategoriesData'] as $product_category_data)
                                        <tr>
                                            <td class="product_category_data">{{ $product_category_data->id }}</td>
                                            <td class="product_category_data">{{ $product_category_data->name }}
                                            </td>
                                            <td class="product_category_data">
                                                {{ $product_category_data->added_by_username }}
                                            </td>
                                            <td class="product_category_data">
                                                <span
                                                    style="background-color: {{ $product_category_data->is_active === 1 ? '#198754' : 'red' }}; color: white; text-align: center; border-radius: 10px; display: block">
                                                    {{ $product_category_data->is_active === 1 ? 'Oui' : 'Non' }}
                                                </span>
                                            </td>
                                            <td class="product_category_data">
                                                {{ $product_category_data->subCategoriesCount }}
                                            </td>
                                            <td class="product_category_data">
                                                {{ $product_category_data->productsCount }}
                                            </td>
                                            <td class="product_category_data">
                                                {{ $product_category_data->activeProductsCount }}
                                            </td>

                                            <td class="product_category_data">
                                                <span style="{{ $product_category_data->base_category_name === null ? 'background-color: #198754; color: white; text-align: center; border-radius: 10px; display: block;' : '' }}">
                                                    {{ $product_category_data->base_category_name === null ? 'Catégorie racine' : $product_category_data->base_category_name }}
                                                </span>
                                            </td>

                                            <td class="product_category_data">
                                                <div class="d-flex" style="gap: 10px">
                                                    <div class="form-check" style="padding-left: 0">
                                                        <label class="form-check-label" style="margin-left: 8px"
                                                            for="related_yes_{{ $product_category_data->id }}">Oui</label>
                                                        <input class="form-check-input"
                                                            id="related_yes_{{ $product_category_data->id }}"
                                                            type="radio"
                                                            name="product_categories[{{ $product_category_data->id }}]"
                                                            value="1" style="margin-left: 5px;"
                                                            {{ $product_category_data->show_on_website_header === 1 ? 'checked' : '' }} />
                                                    </div>
                                                    <div class="form-check" style="margin-left: 25px">
                                                        <label class="form-check-label"
                                                            for="related_no_{{ $product_category_data->id }}">Non</label>
                                                        <input class="form-check-input"
                                                            id="related_no_{{ $product_category_data->id }}"
                                                            type="radio"
                                                            name="product_categories[{{ $product_category_data->id }}]"
                                                            value="0"
                                                            {{ $product_category_data->show_on_website_header === 0 ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div style="text-align: center">
                    <button type="submit" class="btn btn-primary mt-4 mb-2" style="width: 200px">
                        Appliquer
                    </button>
                </div>

            </form>


        </div>
    </div>

    <x-slot:js>

    </x-slot>

</x-dashboard.master>
