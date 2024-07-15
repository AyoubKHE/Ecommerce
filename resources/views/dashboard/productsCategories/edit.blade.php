<x-dashboard.master>

    <form action="{{ route('products-categories.update', $data['productCategoryData']['id']) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container my-3 py-3">

            <h2 class="text-center">modifer la catégorie: {{ $data['productCategoryData']['name'] }}</h2>

            <input type="hidden" name="id" value="{{ $data['productCategoryData']['id'] }}">

            <label for="" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control"
                value="{{ $data['productCategoryData']['name'] }}" />
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ $data['productCategoryData']['description'] }}</textarea>
            @error('description')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <div class="d-flex">

                <label for="" class="form-label">Active:</label>

                <div class="form-check">
                    <label class="form-check-label" style="margin-left: 8px" for="category-active-yes"> Oui </label>
                    <input class="form-check-input" id="category-active-yes" type="radio" name="is_active"
                        value="1" {{ $data['productCategoryData']['is_active'] === 1 ? 'checked' : '' }}
                        style="margin-left: 5px;" />
                </div>
                <div class="form-check" style="margin-left: 25px">
                    <label class="form-check-label" for="category-active-no">Non</label>
                    <input class="form-check-input" id="category-active-no" type="radio" name="is_active"
                        value="0" {{ $data['productCategoryData']['is_active'] === 0 ? 'checked' : '' }}>

                </div>

            </div>
            <div style="border: solid 1px darkgrey; padding: 5px; border-radius: 5px;">
                <strong style="color: red">NB:</strong>
                <p style="color: #be0000; margin-bottom: 0">Veuillez être conscient que la désactivation d'une catégorie
                    entraînera automatiquement la désactivation de toutes les liaisons des produits associés à cette
                    catégorie.</p>
            </div>

            <br>

            <div class="d-flex align-items-center">
                <label for="" class="form-label m-0">Catégorie de base:</label>
                <select name="base_category_name" id="" style="margin-left: 10px; width: 1120px"
                    class="form-select h-25" id="inputGroupSelect01">
                    <option value="N/A"
                        {{ $data['productCategoryData']['base_category_name'] === null ? 'selected' : '' }}>
                        N/A
                    </option>

                    @foreach ($data['productsCategoriesNames'] as $product_category_name)
                        <option value="{{ $product_category_name }}"
                            {{ $product_category_name === $data['productCategoryData']['base_category_name'] ? 'selected' : '' }}>
                            {{ $product_category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>
            <br>

            @isset($data['allProductsData'])
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title" style="margin-top: 7px">Les produits liée à cette catégorie</h3>
                    </div>
                    <div class="card-body p-0"
                        style="overflow-y: scroll; height: {{ count($data['allProductsData']) * 60 }}px; max-height: 400px">
                        <table class="table table-striped text-nowrap my-3">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Marque</th>
                                    <th>Note</th>
                                    <th>Crée le</th>
                                    <th>Mis à jour le</th>
                                    <th>Ajouté par</th>
                                    <th>Ajouté une liason</th>
                                    <th>Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['allProductsData']->all() as $product_data)
                                    @php
                                        $related_product = $data['relatedProductsData']
                                            ->where('product_id', $product_data->id)
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td class="product_data">{{ $product_data->id }}</td>
                                        <td class="product_data">{{ Str::substr($product_data->name, 0, 20) }}</td>
                                        <td class="product_data">{{ $product_data->price }}</td>
                                        <td class="product_data">{{ $product_data->brand_name }}</td>
                                        <td class="product_data">{{ $product_data->rating }}</td>
                                        <td class="product_data">{{ $product_data->created_at }}</td>
                                        <td class="product_data">{{ $product_data->updated_at }}</td>
                                        <td class="product_data">{{ $product_data->added_by_username }}</td>

                                        <td class="product_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="related_yes_{{ $product_data->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="related_yes_{{ $product_data->id }}" type="radio"
                                                        name="is_related_{{ $product_data->id }}" value="1"
                                                        style="margin-left: 5px;"
                                                        {{ $related_product !== null ? 'checked' : '' }} />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="related_no_{{ $product_data->id }}">No</label>
                                                    <input class="form-check-input" id="related_no_{{ $product_data->id }}"
                                                        type="radio" name="is_related_{{ $product_data->id }}"
                                                        value="0" {{ $related_product === null ? 'checked' : '' }} />
                                                </div>
                                            </div>
                                        </td>

                                        <td class="product_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="active_yes_{{ $product_data->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="active_yes_{{ $product_data->id }}" type="radio"
                                                        name="related_products[{{ $product_data->id }}]" value="1"
                                                        style="margin-left: 5px;"
                                                        {{ $related_product === null ? 'disabled' : '' }}
                                                        {{ $related_product !== null ? ($related_product->is_active === 1 ? 'checked' : '') : 'checked' }} />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="active_no_{{ $product_data->id }}">No</label>
                                                    <input class="form-check-input"
                                                        id="active_no_{{ $product_data->id }}" type="radio"
                                                        name="related_products[{{ $product_data->id }}]" value="0"
                                                        {{ $related_product === null ? 'disabled' : '' }}
                                                        {{ $related_product !== null ? ($related_product->is_active === 0 ? 'checked' : '') : '' }} />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            @endisset



            <label for="" class="form-label">Image de la categorie</label>
            <input type="file" name="product_category_image" class="form-control" />
            @error('product_category_image')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <div style="text-align: right">
                <button type="submit" class="btn btn-primary mt-3">
                    Modifier
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>
        <script src="{{ asset('js/myScripts/products_categories/commonLogic.js') }}"></script>
    </x-slot>

</x-dashboard.master>
