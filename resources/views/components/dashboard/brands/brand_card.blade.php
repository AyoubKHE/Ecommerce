{{-- @php
    dd($data);
@endphp --}}

<div class="container" style="width: 70%">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="text-align: center">{{ $data['brandData']['name'] }}</h2>
        <div class="btn-container d-flex gap-1" style="padding-left: 100px">
            <div>
                <a class="btn btn-primary" href="{{ route('brands.edit', $data['brandData']['id']) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Modifier
                </a>
            </div>

            <form action="{{ route('brands.destroy', $data['brandData']['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?');">
                    <i class="fas fa-trash">
                    </i>
                    Supprimer
                </button>
            </form>
            {{-- <a class="btn btn-danger">Supprimer</a> --}}
        </div>
    </div>
    {{-- <img src="{{ asset('storage/' . $data['productCategoryData']["image_path"]) }}" alt="Image de la catégorie"
        class="category-image w-100 border border-1 rounded" style="height: 500px"> --}}
    <div class="details d-flex">
        <div style="width: 50%">
            <p>
                <strong>Active:</strong>
                <small
                    style="background-color: {{ $data['brandData']['is_active'] === 1 ? 'green' : 'red' }}; color: white">
                    {{ $data['brandData']['is_active'] === 1 ? 'Oui' : 'Non' }}
                </small>
            </p>
            <p><strong>Quantité de produits:</strong> {{ $data['brandData']['quantity_of_products'] }} </p>
            </p>
            <p><strong>Créé le:</strong> {{ $data['brandData']['created_at'] }}</p>
            <p><strong>Modifié le:</strong> {{ $data['brandData']['updated_at'] }}</p>
            <p><strong>Catégorie de base:</strong>
                {{ $data['brandData']['base_category_name'] === null ? 'N/A' : $data['brandData']['base_category_name'] }}
            </p>
            <p><strong>Ajouté par:</strong> {{ $data['brandData']['added_by_username'] }}</p>
        </div>
        <div style="width: 70%">
            <h4>Description</h2>
                <p>{{ $data['brandData']['description'] }}</p>
        </div>

    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title" style="margin-top: 7px">Les produits liée à cette marque</h3>
        </div>
        <div class="card-body p-0">
            @if (count($data['relatedProductsData']) === 0)
                <h6 class="text-center">Cette marque ne possède aucun produit</h6>
            @else
                <table class="table table-striped text-nowrap my-3">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Active</th>
                            <th>Note</th>
                            <th>Créé le</th>
                            <th>Mis à jour le</th>
                            <th>Ajouté par</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data['relatedProductsData']->all() as $related_product)
                            <tr>
                                <td class="related_product_data">{{ $related_product->id }}</td>
                                <td class="related_product_data">{{ $related_product->name }}</td>
                                <td class="related_product_data"
                                    style="background-color: {{ $related_product->is_active === 1 ? 'green' : 'red' }}; color: white; text-align: center">
                                    {{ $related_product->is_active === 1 ? 'Oui' : 'Non' }}
                                </td>
                                <td class="related_product_data">{{ $related_product->rating }}</td>
                                <td class="related_product_data">{{ $related_product->created_at }}</td>
                                <td class="related_product_data">{{ $related_product->updated_at }}</td>
                                <td class="related_product_data">{{ $related_product->added_by_username }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
