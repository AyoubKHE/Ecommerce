<table class="table table-striped text-nowrap my-3">

    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Valeurs</th>
        </tr>
    </thead>

    <tbody>

        @if (count($productsAttributesData->items()) == 0)
            <tr>
                <td colspan="9" style="height: 200px; padding-top: 90px; text-align: center; font-weight: 700">
                    Aucun Attribut n'a été trouvée.
                </td>
            </tr>
        @else
            @foreach ($productsAttributesData->items() as $attributeData)
                <tr>

                    <td class="attribute_data">{{ $attributeData->id }}</td>
                    <td class="attribute_data">{{ $attributeData->name }}</td>
                    <td class="attribute_data">{{ $attributeData->options }}</td>

                    <td class="project-actions text-right d-flex justify-content-evenly">
                        <a class="btn btn-primary btn-sm" style="width: 100px"
                            href="{{ route('products-attributes.show', $attributeData->id) }}">
                            <i class="fas fa-folder">
                            </i>
                            Afficher
                        </a>
                        <a class="btn btn-info btn-sm" style="width: 100px"
                            href="{{ route('products-attributes.edit', $attributeData->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Modifier
                        </a>
                        <form action="{{ route('products-attributes.destroy', $attributeData->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width: 100px"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet attribut ?');">
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
{{ $productsAttributesData->links() }}
