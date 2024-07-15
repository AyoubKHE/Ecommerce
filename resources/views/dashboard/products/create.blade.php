<x-dashboard.master>

    <h2 class="text-center">Ajouter un produit</h2>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container py-3">

            <div id="product-informations-form">
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
                        <label class="form-check-label" style="margin-left: 8px" for="product-active-yes"> Oui </label>
                        <input class="form-check-input" id="product-active-yes" type="radio" name="is_active"
                            value="1" checked style="margin-left: 5px;" />
                    </div>
                    <div class="form-check" style="margin-left: 25px">
                        <label class="form-check-label" for="product-active-no">Non</label>
                        <input class="form-check-input" id="product-active-no" type="radio" name="is_active"
                            value="0" />
                    </div>
                </div>
                <br>

                <div class="d-flex align-items-center">
                    <label for="" class="form-label m-0">Marque:</label>
                    <select name="brand_name" id="" style="margin-left: 10px; width: 1202px"
                        class="form-select h-25" id="inputGroupSelect01">
                        @foreach ($data['brandsNames'] as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <br>

                <label for="" class="form-label">Prix:</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" />
                @error('price')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror


                <div class="card" style="margin-top: 50px; margin-bottom: 30px">
                    <h3 class="card-title" style="text-align: center">Les catégories</h3>
                    <div class="card-body p-0"
                        style="overflow-y: scroll; height: {{ count($data['productCategoriesData']) * 50 }}; max-height: 400px">
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
                                @foreach ($data['productCategoriesData']->all() as $product_category_view)
                                    <tr>
                                        <td class="product_category_data">{{ $product_category_view->id }}</td>
                                        <td class="product_category_data">{{ $product_category_view->name }}</td>
                                        <td class="product_category_data">
                                            {{ $product_category_view->added_by_username }}
                                        </td>
                                        <td class="product_category_data">
                                            {{ $product_category_view->quantity_of_products }}</td>
                                        <td class="product_category_data">
                                            {{ $product_category_view->quantity_of_active_products }}</td>
                                        <td class="product_category_data">{{ $product_category_view->created_at }}</td>
                                        <td class="product_category_data">{{ $product_category_view->updated_at }}</td>

                                        <td class="product_category_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="related_yes_{{ $product_category_view->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="related_yes_{{ $product_category_view->id }}"
                                                        type="radio"
                                                        name="is_related_{{ $product_category_view->id }}"
                                                        value="1" style="margin-left: 5px;" />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="related_no_{{ $product_category_view->id }}">No</label>
                                                    <input class="form-check-input"
                                                        id="related_no_{{ $product_category_view->id }}"
                                                        type="radio"
                                                        name="is_related_{{ $product_category_view->id }}"
                                                        value="0" checked>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="product_category_data">
                                            <div class="d-flex" style="gap: 10px">
                                                <div class="form-check" style="padding-left: 0">
                                                    <label class="form-check-label" style="margin-left: 8px"
                                                        for="active_yes_{{ $product_category_view->id }}">Yes</label>
                                                    <input class="form-check-input"
                                                        id="active_yes_{{ $product_category_view->id }}"
                                                        type="radio"
                                                        name="related_categories[{{ $product_category_view->id }}]"
                                                        value="1" style="margin-left: 5px;" disabled checked />
                                                </div>
                                                <div class="form-check" style="margin-left: 25px">
                                                    <label class="form-check-label"
                                                        for="active_no_{{ $product_category_view->id }}">No</label>
                                                    <input class="form-check-input"
                                                        id="active_no_{{ $product_category_view->id }}"
                                                        type="radio"
                                                        name="related_categories[{{ $product_category_view->id }}]"
                                                        value="0" disabled>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <div style="border: solid 1px darkgrey; padding: 5px; border-radius: 5px;">
                    <strong style="color: red">NB:</strong>
                    <p style="color: #be0000; margin-bottom: 0">
                    <h4>
                        Astuce pour une meilleure organisation des produits
                    </h4>
                    Lors de l'ajout d'un produit au système, il faut lier le produit uniquement aux
                    catégories enfants spécifiques plutôt qu'à toutes les catégories parentes et enfants.
                    <br>
                    <br>
                    Par exemple, si vous avez la catégorie "Homme" qui contient une sous-catégorie "Chemise Homme"
                    elle-même contenant une sous-catégorie "Chemise Homme Classique", il est recommandé de lier le
                    produit uniquement à la sous-catégorie "Chemise Homme Classique" et non aux catégories "Homme" et
                    "Chemise Homme".
                    <br>
                    <br>
                    Cependant, s'il existe une autre catégorie comme "Soldes" qui n'a pas de relation avec les
                    catégories précédentes, vous pouvez lier le produit à la fois à "Chemise Homme Classique" et à
                    "Soldes".
                    <br>
                    <br>
                    Pourquoi ?
                    <ul>
                        <li> Plus de pertinence : Classer un produit dans sa catégorie enfant permet une recherche et
                            une navigation plus précises pour les utilisateurs.
                        </li>
                        <li>
                            Moins de redondance : Inutile d'associer un produit à sa catégorie parente si il est déjà
                            englobée par la catégorie enfant.
                        </li>
                        <li>
                            Meilleure organisation : Cela contribue à une structure claire et cohérente de votre
                            catalogue de produits.
                        </li>
                    </ul>



                    </p>
                </div> --}}

                <br>
                <br>

                <label for="" class="form-label">Image(s) du produit</label>
                <div class="d-flex align-items-center gap-3">

                    @php
                        $imagePath = 'empty_image.png';
                        $isDefault = 0;
                    @endphp

                    @for ($i = 1; $i <= 4; $i++)
                        <x-dashboard.products.product_image_card :image-number="$i" :image-path="$imagePath" :is-default="$isDefault"
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

                    </div>

                </div>

                <div style="text-align: center; margin-bottom: 20px">
                    <a type="button" class="btn btn-success" id="add-new-variation-btn">
                        Ajouter une nouvelle variation
                    </a>
                </div>

                <div id="variations-container">

                </div>


            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary mt-3" style="width: 30%;font-size: large;">
                    Ajouter
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>
        <script src="{{ asset('js/myScripts/products/commonLogic.js') }}"></script>
        <script src="{{ asset('js/myScripts/products/create/product_informations.js') }}"></script>
        <script src="{{ asset('js/myScripts/products/create/product_variations.js') }}"></script>
    </x-slot>

</x-dashboard.master>
