<x-dashboard.master>

    <h2 class="text-center">modifer le produit: {{ $data['productData']->name }}</h2>

    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a id="product-informations-link" class="nav-link active" aria-current="page" href="#"
                onclick="showProductInformationsForm()">Informations de produit</a>
        </li>

        <li class="nav-item">
            <a id="product-variations-link" class="nav-link" href="#"
                onclick="showProductVariationsForm()">Variations de produit</a>
        </li>

    </ul>

    <form id="update-form" action="{{ route('products.update', $data['productData']->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container my-3 py-3">

            <div id="product-informations-form">
                <input type="hidden" name="id" value="{{ $data['productData']->id }}">

                <label for="" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="{{ $data['productData']->name }}" />
                @error('name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <label for="" class="form-label">Description</label>
                <textarea class="form-control" name="description">{{ $data['productData']->description }}</textarea>
                @error('description')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <br>

                <div class="d-flex">

                    <label for="" class="form-label">Active:</label>

                    <div class="form-check">
                        <label class="form-check-label" style="margin-left: 8px" for="product-active-yes"> Oui </label>
                        <input class="form-check-input" id="product-active-yes" type="radio" name="is_active"
                            value="1" {{ $data['productData']->is_active === 1 ? 'checked' : '' }}
                            style="margin-left: 5px;" />
                    </div>
                    <div class="form-check" style="margin-left: 25px">
                        <label class="form-check-label" for="product-active-no">Non</label>
                        <input class="form-check-input" id="product-active-no" type="radio" name="is_active"
                            value="0" {{ $data['productData']->is_active === 0 ? 'checked' : '' }}>

                    </div>

                </div>
                <div style="border: solid 1px darkgrey; padding: 5px; border-radius: 5px;">
                    <strong style="color: red">NB:</strong>
                    <p style="color: #be0000; margin-bottom: 0">Veuillez noter que si vous choisissez de désactiver ce
                        produit, cela entraînera également la désactivation de toutes les associations de catégories
                        liées à
                        ce produit.</p>
                </div>

                <br>

                <div class="d-flex align-items-center">
                    <label for="" class="form-label m-0">Marque:</label>
                    <select name="brand_name" id="" style="margin-left: 10px; width: 1202px"
                        class="form-select h-25" id="inputGroupSelect01">
                        @foreach ($data['brandsNames'] as $brand_name)
                            <option value="{{ $brand_name }}"
                                {{ $brand_name === $data['productData']['brand_name'] ? 'selected' : '' }}>
                                {{ $brand_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <br>

                <label for="" class="form-label">Prix:</label>
                <input type="number" name="price" class="form-control" value="{{ $data['productData']->price }}" />
                @error('price')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

                <br>

                <div class="card" style="margin-top: 50px">
                    <h3 class="card-title" style="text-align: center">Les catégories liée à ce produit</h3>
                    <div class="card-body p-0"
                        style="overflow-y: scroll; height: {{ count($data['allCategoriesData']) * 60 }}px; max-height: 400px">
                        <table class="table table-striped text-nowrap my-3">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Ajouté par</th>
                                    <th>Quantité de<br>produits</th>
                                    <th>Quantité de<br>produits actifs</th>
                                    <th>Crée le</th>
                                    <th>Mis à jour le</th>
                                    <th>Ajouté une liason</th>
                                    <th>Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['allCategoriesData']->all() as $category_data)
                                    @php
                                        $related_category = $data['relatedCategoriesData']
                                            ->where('productCategory_id', $category_data->id)
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td class="product_category_data">{{ $category_data->id }}</td>
                                        <td class="product_category_data">{{ $category_data->name }}</td>
                                        <td class="product_category_data">{{ $category_data->added_by_username }}</td>
                                        <td class="product_category_data">{{ $category_data->quantity_of_products }}
                                        </td>
                                        <td class="product_category_data">
                                            {{ $category_data->quantity_of_active_products }}
                                        </td>
                                        <td class="product_category_data">{{ $category_data->created_at }}</td>
                                        <td class="product_category_data">{{ $category_data->updated_at }}</td>

                                        <td class="product_category_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="related_yes_{{ $category_data->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="related_yes_{{ $category_data->id }}" type="radio"
                                                        name="is_related_{{ $category_data->id }}" value="1"
                                                        style="margin-left: 5px;"
                                                        {{ $related_category !== null ? 'checked' : '' }} />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="related_no_{{ $category_data->id }}">No</label>
                                                    <input class="form-check-input"
                                                        id="related_no_{{ $category_data->id }}" type="radio"
                                                        name="is_related_{{ $category_data->id }}" value="0"
                                                        {{ $related_category === null ? 'checked' : '' }} />
                                                </div>
                                            </div>
                                        </td>

                                        <td class="product_category_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="active_yes_{{ $category_data->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="active_yes_{{ $category_data->id }}" type="radio"
                                                        name="related_categories[{{ $category_data->id }}]" value="1"
                                                        style="margin-left: 5px;"
                                                        {{ $related_category === null ? 'disabled' : '' }}
                                                        {{ $related_category !== null ? ($related_category->is_active === 1 ? 'checked' : '') : '' }} />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="active_no_{{ $category_data->id }}">No</label>
                                                    <input class="form-check-input"
                                                        id="active_no_{{ $category_data->id }}" type="radio"
                                                        name="related_categories[{{ $category_data->id }}]" value="0"
                                                        {{ $related_category === null ? 'disabled' : '' }}
                                                        {{ $related_category !== null ? ($related_category->is_active === 0 ? 'checked' : '') : 'checked' }} />
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



                <label for="" class="form-label" style="margin-top: 5px">Image(s) du produit:</label>
                <div class="image-container gap-3" style="display: flex">
                    @foreach ($data['product_images']->all() as $index => $product_image)
                        <x-dashboard.products.product_image_card :image-number="$index + 1" :image-path="$product_image->image_path" :is-default="$product_image->is_default"
                            :is-disabled="0" />
                    @endforeach

                    @php
                        $product_images_count = count($data['product_images']);
                        $imagePath = 'empty_image.png';
                        $isDefault = 0;
                    @endphp

                    @for ($i = 1; $i <= 4 - $product_images_count; $i++)
                        <x-dashboard.products.product_image_card :image-number="$i + $product_images_count" :image-path="$imagePath" :is-default="$isDefault"
                            :is-disabled="1" />
                    @endfor
                </div>
            </div>

            <div id="product-variations-form" style="display: none">
                <label for="" class="form-label m-0">Veuillez sélectionner les attribut(s) que vous souhaitez
                    assigner au produit:</label>
                <div class="d-flex align-items-center" style="gap: 50px; margin-top: 20px; margin-bottom: 20px">
                    <select name="" id="attributes-select" style="width: 25%;" class="form-select h-25"
                        id="inputGroupSelect01">
                        <option value="N/A" selected>Choisir ici...</option>
                        @foreach ($data['attributesNames'] as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    <div id="choosed-attributes-container" class="d-flex align-items-center flex-wrap"
                        style="
                                width: 900px;
                                padding: 15px;
                                border: solid 1px #ced4da;
                                border-radius: 4px;">
                        @foreach ($data['productVariations']['usedAttributes'] as $index => $name)
                            <div class="d-flex" style="margin-right: 30px; margin-bottom: 10px"
                                id="attribute-card-{{ $index + 1 }}">
                                <div class="d-flex align-items-center" style="gap: 10px">

                                    <input type="text" id="attribute-{{ $index + 1 }}"
                                        name="choosed_attributes[]" class="form-control"
                                        style="width: 100px; height: 30px" value="{{ $name }}">

                                    <span class="btn btn-danger btn-sm" id="delete-attribute-{{ $index + 1 }}">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </span>

                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>

                <div style="text-align: center; margin-bottom: 20px">
                    <a type="button" class="btn btn-success" id="add-new-variation-btn">
                        Ajouter une nouvelle variation
                    </a>
                </div>

                <div id="variations-container">

                    @foreach ($data['productVariations']['variations'] as $index => $variation)

                        <div class="d-flex align-items-center" id="variation-{{ $index + 1 }}"
                            style="gap: 20px; margin-bottom: 20px;">

                            <input type="hidden" id="variation-{{ $index + 1 }}-id-in-database" value="{{ $variation->id }}">

                            <label class="form-label" id="variation-label-{{ $index + 1 }}"
                                style="margin-bottom: -10px;">Variation {{ $index + 1 }}:</label>

                            <div id="options-container-{{ $index + 1 }}"
                                class="d-flex align-items-center flex-wrap"
                                style="gap: 10px; border: 2px solid rgb(206, 212, 218); padding: 10px; border-radius: 10px; max-width: 700px;">

                                @foreach ($data['productVariations']['attributesAndOptions'] as $attribute => $options)
                                    @php
                                        $originale_option = $variation->options
                                            ->filter(function ($option) use ($attribute) {
                                                return $option->productAttribute->name === $attribute;
                                            })
                                            ->first()->value;
                                    @endphp

                                    <div id="container-attribute-{{ $attribute }}-{{ $index + 1 }}"
                                        class="d-flex flex-column align-items-center">
                                        <label>{{ $attribute }}</label>

                                        <select class="form-select"
                                            name="variations[{{ $index }}][options][{{ $attribute }}]"
                                            id="options-select-{{ $attribute }}-{{ $index + 1 }}"
                                            style="width: 150px;">

                                            @foreach ($options as $option)
                                                <option value="{{ $option }}"
                                                    {{ $originale_option === $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                @endforeach

                            </div>

                            <div class="d-flex align-items-center flex-wrap"
                                style="gap: 10px; border: 2px solid rgb(206, 212, 218); padding: 10px; border-radius: 10px; max-width: 500px;">

                                <div class="d-flex flex-column align-items-center">
                                    <label>Prix:</label>
                                    <input type="number" name="variations[{{ $index }}][price]"
                                        id="variation-price-{{ $index + 1 }}" class="form-control"
                                        style="width: 150px;"
                                        value="{{ $variation['price'] ?? $data['productData']->price }}">
                                </div>

                                <div class="d-flex flex-column align-items-center"><label>Qté dans le stock:</label>
                                    <input type="number" name="variations[{{ $index }}][quantity_in_stock]"
                                        id="variation-quantity-in-stock-{{ $index + 1 }}" class="form-control"
                                        style="width: 150px;" value="{{ $variation['quantity_in_stock'] }}">
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <label style="margin-bottom: 9px;">Active:</label>
                                    <div class="d-flex">

                                        <div class="form-check" style="padding-left: 0px;"><label
                                                class="form-check-label" style="margin-left: 8px;">Oui</label><input
                                                class="form-check-input"
                                                id="variation-active-yes-{{ $index + 1 }}" type="radio"
                                                name="variations[{{ $index }}][is_active]" value="1"
                                                style="margin-left: 5px;"
                                                {{ $variation['is_active'] === 1 ? 'checked' : '' }}>
                                        </div>

                                        <div class="form-check" style="margin-left: 20px;"><label
                                                class="form-check-label">Non</label><input class="form-check-input"
                                                id="variation-active-no-{{ $index + 1 }}" type="radio"
                                                name="variations[{{ $index }}][is_active]" value="0"
                                                {{ $variation['is_active'] === 0 ? 'checked' : '' }}>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <span class="btn btn-danger btn-sm" id="delete-variation-{{ $index + 1 }}">
                                <i class="fas fa-trash"></i>
                            </span>

                        </div>
                    @endforeach

                </div>



            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary mt-3" style="width: 30%;font-size: large;">
                    Modifier
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>

        <script src="{{ asset('js/myScripts/products/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/products/edit/product_informations.js') }}"></script>
        <script src="{{ asset('js/myScripts/products/edit/product_variations.js') }}"></script>

    </x-slot>

</x-dashboard.master>
