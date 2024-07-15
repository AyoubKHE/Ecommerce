<x-dashboard.master>

    <form action="{{ route('products-attributes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container py-3">

            <h2 class="text-center">Ajouter un attribut</h2>

            <label for="" class="form-label">Nom:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Description:</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Valeurs:</label>

            <div class="d-flex align-items-center flex-wrap" id="options-container">

                @php
                    $inputValue = "";
                @endphp

                @for ($i = 1; $i <= 5; $i++)
                    <x-dashboard.productsAttributes.option_card :option-number="$i" :input-value="$inputValue" :option-id="null"/>
                @endfor

                <span class="btn btn-success btn-sm" id="add-new-option" style="margin-top: 23px; border-radius: 15px">
                    <i class="fas fa-plus"></i>
                </span>

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
        <script src="{{ asset('js/myScripts/products_attributes/create.js') }}"></script>
    </x-slot>

</x-dashboard.master>
