<x-dashboard.master>

    <form action="{{ route('products-categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container py-3">

            <h2 class="text-center">Ajouter une catégorie</h2>

            <label for="" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <div class="d-flex">
                <label for="" class="form-label">Active:</label>

                <div class="form-check">
                    <label class="form-check-label" style="margin-left: 8px" for="category-active-yes"> Yes </label>
                    <input class="form-check-input" id="category-active-yes" type="radio" name="is_active"
                        value="1" checked style="margin-left: 5px;" />
                </div>
                <div class="form-check" style="margin-left: 25px">
                    <label class="form-check-label" for="category-active-no">No</label>
                    <input class="form-check-input" id="category-active-no" type="radio" name="is_active"
                        value="0" />
                </div>
            </div>

            <br>

            <div class="d-flex align-items-center">
                <label for="" class="form-label m-0">Catégorie de base:</label>
                <select name="base_category_name" id="" style="margin-left: 10px; width: 1120px"
                    class="form-select h-25" id="inputGroupSelect01">
                    <option value="N/A" selected>N/A</option>
                    @foreach ($data['productsCategoriesNames'] as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="card" style="margin-top: 50px">
                <h3 class="card-title" style="text-align: center">Les Produits</h3>
                <div class="card-body p-0"
                    style="overflow-y: scroll; height: {{ count($data['productsData']) * 60 }}px; max-height: 400px">
                    <table class="table table-striped text-nowrap my-3">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Ajouté par</th>
                                <th>Marque</th>
                                <th>Prix</th>
                                <th>Note</th>
                                <th>Crée le</th>
                                <th>Mis à jour le</th>
                                <th>Ajouté une liason</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['productsData'] as $product_data)
                                <tr>
                                    <td class="product_data">{{ $product_data->id }}</td>
                                    <td class="product_data">{{ Str::substr($product_data->name, 0, 20) }}</td>
                                    <td class="product_data">{{ $product_data->added_by_username }}</td>
                                    <td class="product_data">{{ $product_data->brand_name }}</td>
                                    <td class="product_data">{{ $product_data->price }}</td>
                                    <td class="product_data">{{ $product_data->rating }}</td>
                                    <td class="product_data">{{ $product_data->created_at }}</td>
                                    <td class="product_data">{{ $product_data->updated_at }}</td>

                                    <td class="product_category_data">
                                        <div class="d-flex" style="gap: 10px">
                                            <div class="form-check" style="padding-left: 0">
                                                <label class="form-check-label" style="margin-left: 8px"
                                                    for="related_yes_{{ $product_data->id }}">Yes</label>
                                                <input class="form-check-input"
                                                    id="related_yes_{{ $product_data->id }}" type="radio"
                                                    name="is_related_{{ $product_data->id }}" value="1"
                                                    style="margin-left: 5px;" />
                                            </div>
                                            <div class="form-check" style="margin-left: 25px">
                                                <label class="form-check-label"
                                                    for="related_no_{{ $product_data->id }}">No</label>
                                                <input class="form-check-input" id="related_no_{{ $product_data->id }}"
                                                    type="radio" name="is_related_{{ $product_data->id }}"
                                                    value="0" checked>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="product_category_data">
                                        <div class="d-flex" style="gap: 10px">
                                            <div class="form-check" style="padding-left: 0">
                                                <label class="form-check-label" style="margin-left: 8px"
                                                    for="active_yes_{{ $product_data->id }}">Yes</label>
                                                <input class="form-check-input" id="active_yes_{{ $product_data->id }}"
                                                    type="radio" name="related_products[{{ $product_data->id }}]"
                                                    value="1" style="margin-left: 5px;" disabled checked />
                                            </div>
                                            <div class="form-check" style="margin-left: 25px">
                                                <label class="form-check-label"
                                                    for="active_no_{{ $product_data->id }}">No</label>
                                                <input class="form-check-input"
                                                    id="active_no_{{ $product_data->id }}" type="radio"
                                                    name="related_products[{{ $product_data->id }}]" value="0"
                                                    disabled>
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
            <br>

            <label for="" class="form-label">Bannières de la categorie</label>
            <input type="file" name="product_category_image" class="form-control" />
            @error('product_category_image')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>
            <div style="border: solid 1px darkgrey; padding: 5px; border-radius: 5px;">
                <strong style="color: red">NB:</strong>
                <p style="color: #be0000; margin-bottom: 0">En utilisant des bannières pour vos catégories de
                    vêtements, vous pouvez améliorer l'apparence, de votre boutique en ligne.
                </p>
            </div>

            <div style="text-align: right">
                <button type="submit" class="btn btn-primary mt-3">
                    Ajouter
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>
        <script src="{{ asset('js/myScripts/products_categories/commonLogic.js') }}"></script>
    </x-slot>

</x-dashboard.master>
