<x-dashboard.master>

    <form action="{{ route('brands.update', $data['brandData']['id']) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container my-3 py-3">

            <h2 class="text-center">modifer la catégorie: {{ $data['brandData']['name'] }}</h2>

            <input type="hidden" name="id" value="{{ $data['brandData']['id'] }}">

            <label for="" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control"
                value="{{ $data['brandData']['name'] }}" />
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ $data['brandData']['description'] }}</textarea>
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
                        value="1" {{ $data['brandData']['is_active'] === 1 ? 'checked' : '' }}
                        style="margin-left: 5px;" />
                </div>
                <div class="form-check" style="margin-left: 25px">
                    <label class="form-check-label" for="category-active-no">Non</label>
                    <input class="form-check-input" id="category-active-no" type="radio" name="is_active"
                        value="0" {{ $data['brandData']['is_active'] === 0 ? 'checked' : '' }}>

                </div>

            </div>
            <div style="border: solid 1px darkgrey; padding: 5px; border-radius: 5px;">
                <strong style="color: red">NB:</strong>
                <p style="color: #be0000; margin-bottom: 0">Veuillez être conscient que la désactivation d'une marque
                    entraînera automatiquement la désactivation de tous les produits associés à cette
                    marque.</p>
            </div>

            <br>

            <div style="text-align: right">
                <button type="submit" class="btn btn-primary mt-3">
                    Modifier
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>

    </x-slot>

</x-dashboard.master>
