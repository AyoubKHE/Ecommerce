@php
    // dd($data);
@endphp

<div class="container" style="width: 70%">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="text-align: center">{{ $data['productData']->name }}</h2>
        <div class="btn-container d-flex gap-1" style="padding-left: 100px">
            <div>
                <a class="btn btn-primary" href="{{ route('products.edit', $data['productData']->id) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Modifier
                </a>
            </div>

            <form action="{{ route('products.destroy', $data['productData']->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                    <i class="fas fa-trash">
                    </i>
                    Supprimer
                </button>
            </form>
            {{-- <a class="btn btn-danger">Supprimer</a> --}}
        </div>
    </div>


    <img src="{{ asset('storage/' . $data['product_images']['default']->image_path) }}" alt="Image de du produit"
        class="category-image w-100 border border-1 rounded" style="height: 400px">

    <div class="image-container gap-3" style="display: flex">
        @foreach ($data['product_images']['other_images'] as $product_image)
            <img src="{{ asset('storage/' . $product_image->image_path) }}" class="product-image"
                style="width: {{ 100 / count($data['product_images']['other_images']) }}%; height: 200px">
        @endforeach
    </div>

    <div class="details d-flex">
        <div style="width: 50%">
            <p>
                <strong>Active:</strong>
                <small
                    style="background-color: {{ $data['productData']->is_active === 1 ? 'green' : 'red' }}; color: white">
                    {{ $data['productData']->is_active === 1 ? 'Oui' : 'Non' }}
                </small>
            </p>
            <p><strong>Prix:</strong> {{ $data['productData']->price }} DA</p>
            <p><strong>Marque:</strong> {{ $data['productData']->brand_name }}</p>
            <p><strong>Créé le:</strong> {{ $data['productData']->created_at }}</p>
            <p><strong>Modifié le:</strong> {{ $data['productData']->updated_at }}</p>
            <p><strong>Ajouté par:</strong> {{ $data['productData']->added_by_username }}</p>
        </div>
        <div style="width: 70%">
            <h4>Description</h2>
                <p>{{ $data['productData']->description }}</p>
        </div>

    </div>

    <div class="card" style="margin-bottom: 50px">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title" style="margin-top: 7px">Les catégories de ce produit</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped text-nowrap my-3">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Active</th>
                        <th>Quantité de<br>produits</th>
                        <th>Quantité de<br>produits actifs</th>
                        <th>crée le</th>
                        <th>mis à jour le</th>
                        <th>Ajouté par</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data['relatedCategoriesData']->all() as $related_category)
                        <tr>
                            <td class="product_category_data">{{ $related_category->product_category_id }}</td>
                            <td class="product_category_data">{{ $related_category->product_category_name }}</td>
                            <td class="product_category_data"
                                style="background-color: {{ $related_category->is_active === 1 ? 'green' : 'red' }}; color: white; text-align: center">
                                {{ $related_category->is_active === 1 ? 'Oui' : 'Non' }}
                            </td>
                            <td class="product_category_data">
                                {{ $related_category->product_category_quantity_of_products }}</td>
                            <td class="product_category_data">
                                {{ $related_category->product_category_quantity_of_active_products }}</td>
                            <td class="product_category_data">{{ $related_category->product_category_created_at }}</td>
                            <td class="product_category_data">{{ $related_category->product_category_updated_at }}</td>
                            <td class="product_category_data">
                                {{ $related_category->product_category_added_by_username }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title" style="margin-top: 7px">Les variations de ce produit</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped text-nowrap my-3">
                <thead>
                    <tr>
                        <th>Id</th>
                        @foreach ($data['productVariations']['usedAttributes'] as $used_attribute)
                            <th>{{ $used_attribute }}</th>
                        @endforeach
                        <th>Prix (DA)</th>
                        <th>Quantité dans<br>le stock</th>
                        <th>Active</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data['productVariations']['variations'] as $product_variation)
                        <tr>
                            <td class="product_variation_data">{{ $product_variation["id"] }}</td>
                            @foreach ($product_variation['options'] as $option)
                                <td class="product_variation_data">{{ $option["value"] }}</td>
                            @endforeach
                            <td class="product_variation_data">{{ $product_variation["price"] ?? $data['productData']->price }}</td>
                            <td class="product_variation_data">{{ $product_variation["quantity_in_stock"] }}</td>

                            <td class="product_variation_data"
                                style="background-color: {{ $product_variation["is_active"] === 1 ? 'green' : 'red' }}; color: white; text-align: center">
                                {{ $related_category->is_active === 1 ? 'Oui' : 'Non' }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
