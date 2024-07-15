<table class="table table-striped text-nowrap my-3">
    @php
        // dd($linksData);
    @endphp
    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            {{-- <th>description</th> --}}
            <th>Active</th>
            <th>Quantité de<br>sous catégories</th>
            <th>Quantité de<br>produits</th>
            <th>Quantité de<br>produits actifs</th>
            {{-- <th>Créé le</th>
            <th>Mis à jour le</th> --}}
            <th>Catégorie<br>de base</th>
            <th>Ajouté par</th>

        </tr>
    </thead>

    <tbody>

        @if (count($productsCategoriesData) == 0)
            <tr>
                <td colspan="9" style="height: 200px; padding-top: 90px; text-align: center; font-weight: 700">
                    Aucune catégorie n'a été trouvée.
                </td>
            </tr>
        @else
            @foreach ($productsCategoriesData as $product_category)
                <tr>

                    <td class="product_category_data">{{ $product_category->id }}</td>
                    <td class="product_category_data">{{ $product_category->name }}</td>
                    {{-- <td class="product_category_data">{{ $product_category->description }}</td> --}}
                    <td class="product_category_data"
                        style="background-color: {{ $product_category->is_active === 1 ? '#198754' : 'red' }}; color: white; text-align: center">
                        {{ $product_category->is_active === 1 ? 'Oui' : 'Non' }}
                    </td>
                    <td class="product_category_data">{{ $product_category->subCategoriesCount }}</td>
                    <td class="product_category_data">{{ $product_category->productsCount }}</td>
                    <td class="product_category_data">{{ $product_category->activeProductsCount }}</td>
                    {{-- <td class="product_category_data">{{ $product_category->created_at }}</td>
                    <td class="product_category_data">{{ $product_category->updated_at }}</td> --}}
                    <td class="product_category_data">
                        {{ $product_category->base_category_name === null ? 'N/A' : $product_category->base_category_name }}
                    </td>
                    <td class="product_category_data">{{ $product_category->added_by_username }}</td>

                    <td class="project-actions text-right d-flex justify-content-evenly">
                        <a class="btn btn-primary btn-sm" style="width: 100px"
                            href="{{ route('products-categories.show', $product_category->id) }}">
                            <i class="fas fa-folder">
                            </i>
                            Afficher
                        </a>
                        <a class="btn btn-info btn-sm" style="width: 100px"
                            href="{{ route('products-categories.edit', $product_category->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Modifier
                        </a>
                        {{-- probleme with csrf token and ajax request --}}
                        <form action="{{ route('products-categories.destroy', $product_category->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width: 100px"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
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
{{-- {{ $productsCategoriesData->links() }} --}}
@if (count($linksData['links']) > 1)
    <nav aria-label="Page navigation example">
        <div>
            <ul class="pagination justify-content-end">

                <li class="page-item">
                    <a class="page-link {{ $linksData['currentPage'] == 1 ? 'disabled' : '' }}"
                        href={{ 'http://127.0.0.1:8000/products-categories?page=' . $linksData['currentPage'] - 1 }}><<</a>
                </li>

                @foreach ($linksData['links'] as $key => $link)
                    <li class="page-item">
                        <a class="page-link {{ $key + 1 == $linksData['currentPage'] ? 'active' : '' }}"
                            href="{{ $link }}">{{ $key + 1 }}
                        </a>
                    </li>
                @endforeach

                <li class="page-item">
                    <a class="page-link {{ $linksData['currentPage'] == $linksData['lastPage'] ? 'disabled' : '' }}"
                        href={{ 'http://127.0.0.1:8000/products-categories?page=' . $linksData['currentPage'] + 1 }}>>></a>
                </li>

            </ul>
        </div>
    </nav>
@endif
