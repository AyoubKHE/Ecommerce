<x-dashboard.master>

    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container py-3">

            <h2 class="text-center">Ajouter une marque</h2>

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
                    <input class="form-check-input" id="category-active-yes" type="radio" name="is_active" value="1"
                        checked style="margin-left: 5px;" />
                </div>
                <div class="form-check" style="margin-left: 25px">
                    <label class="form-check-label" for="category-active-no">No</label>
                    <input class="form-check-input" id="category-active-no" type="radio" name="is_active" value="0" />
                </div>
            </div>

            <br>

            <div style="text-align: right">
                <button type="submit" class="btn btn-primary mt-3">
                    Ajouter
                </button>
            </div>

        </div>
    </form>

    <x-slot:js>
        
    </x-slot>

</x-dashboard.master>
