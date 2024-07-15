<table class="table table-striped text-nowrap my-3">
    @php
        // dd($linksData);
    @endphp
    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Active</th>
            <th>Quantité de<br>produits</th>
            <th>Créé le</th>
            <th>Mis à jour le</th>
            <th>Ajouté par</th>

        </tr>
    </thead>

    <tbody>

        @if (count($brandsData->items()) == 0)
            <tr>
                <td colspan="9" style="height: 200px; padding-top: 90px; text-align: center; font-weight: 700">
                    Aucune marque n'a été trouvée.
                </td>
            </tr>
        @else
            @foreach ($brandsData->items() as $brand)
                <tr>

                    <td class="brand_data">{{ $brand->id }}</td>
                    <td class="brand_data">{{ $brand->name }}</td>
                    <td class="brand_data"
                        style="background-color: {{ $brand->is_active === 1 ? '#198754' : 'red' }}; color: white; text-align: center">
                        {{ $brand->is_active === 1 ? 'Oui' : 'Non' }}
                    </td>
                    <td class="brand_data">{{ $brand->quantity_of_products }}</td>
                    <td class="brand_data">{{ $brand->created_at }}</td>
                    <td class="brand_data">{{ $brand->updated_at }}</td>
                    <td class="brand_data">{{ $brand->added_by_username }}</td>

                    <td class="project-actions text-right d-flex justify-content-evenly">
                        <a class="btn btn-primary btn-sm" style="width: 100px"
                            href="{{ route('brands.show', $brand->id) }}">
                            <i class="fas fa-folder">
                            </i>
                            Afficher
                        </a>
                        <a class="btn btn-info btn-sm" style="width: 100px"
                            href="{{ route('brands.edit', $brand->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Modifier
                        </a>
                        {{-- probleme with csrf token and ajax request --}}
                        <form action="{{ route('brands.destroy', $brand->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width: 100px"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?');">
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
{{ $brandsData->links() }}
{{-- @if (count($linksData) > 0)
    @if (count($linksData['links']) > 1)
        <nav aria-label="Page navigation example">
            <div>
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link {{ $linksData['currentPage'] === 1 ? 'disabled' : '' }}"
                            href={{ 'http://127.0.0.1:8000/products-categories?page=' . $linksData['currentPage'] - 1 }}>Précédent</a>
                    </li>

                    @foreach ($linksData['links'] as $key => $link)
                        <li class="page-item">
                            <a class="page-link {{ $key === $linksData['currentPage'] ? 'active' : '' }}"
                            href="{{ $link }}">{{ $key }}
                            </a>
                        </li>
                    @endforeach

                    <li class="page-item">
                        <a class="page-link {{ $linksData['currentPage'] === $linksData['lastPage'] ? 'disabled' : '' }}"
                            href={{ 'http://127.0.0.1:8000/products-categories?page=' . $linksData['currentPage'] + 1 }}>Suivant</a>
                    </li>

                </ul>
            </div>
        </nav>
    @endif
@endif --}}
