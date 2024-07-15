<table class="table table-striped text-nowrap my-3">

    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Active</th>
            <th>Marque</th>
            <th>Prix (DA)</th>
            <th>note</th>
            <th>Créé le</th>
            <th>Mis à jour le</th>
            <th>Ajouté par</th>

        </tr>
    </thead>

    <tbody>

        @if (count($productsData->items()) == 0)
            <tr>
                <td colspan="9" style="height: 200px; padding-top: 90px; text-align: center; font-weight: 700">
                    Aucun produit n'a été trouvée.
                </td>
            </tr>
        @else
            @foreach ($productsData->items() as $productData)
                <tr>

                    <td class="product_data">{{ $productData->id }}</td>
                    <td class="product_data">{{ Str::substr($productData->name, 0, 20) }}</td>
                    {{-- <td class="product_category_data">{{ $product_category->description }}</td> --}}
                    <td class="product_category_data"
                        style="background-color: {{ $productData->is_active === 1 ? '#198754' : 'red' }}; color: white; text-align: center">
                        {{ $productData->is_active === 1 ? 'Oui' : 'Non' }}
                    </td>
                    <td class="product_data">{{ $productData->brand_name }}</td>
                    <td class="product_data">{{ $productData->price }}</td>
                    <td class="product_data">{{ $productData->rating }}</td>
                    <td class="product_data">{{ $productData->created_at }}</td>
                    <td class="product_data">{{ $productData->updated_at }}</td>
                    <td class="product_data">{{ $productData->added_by_username }}</td>

                    <td class="project-actions text-right d-flex justify-content-evenly">
                        <a class="btn btn-primary btn-sm" style="width: 100px"
                            href="{{ route('products.show', $productData->id) }}">
                            <i class="fas fa-folder">
                            </i>
                            Afficher
                        </a>
                        <a class="btn btn-info btn-sm" style="width: 100px"
                            href="{{ route('products.edit', $productData->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Modifier
                        </a>
                        <form action="{{ route('products.destroy', $productData->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width: 100px"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                <i class="fas fa-trash">
                                </i>
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif


    </tbody>

</table>
{{ $productsData->links() }}
