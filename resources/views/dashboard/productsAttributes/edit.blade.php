<x-dashboard.master>

    <form action="{{ route('products-attributes.update', $data['productAttributeData']['id']) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container my-3 py-3">

            <h2 class="text-center">modifer l'attribut: {{ $data['productAttributeData']['name'] }}</h2>

            <input type="hidden" name="id" value="{{ $data['productAttributeData']['id'] }}">

            <label for="" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control"
                value="{{ $data['productAttributeData']['name'] }}" />
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ $data['productAttributeData']['description'] }}</textarea>
            @error('description')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <br>

            <label for="" class="form-label">Valeurs:</label>

            <div class="d-flex align-items-center flex-wrap" id="options-container">

                @foreach ($data['attributeOptions']->all() as $key => $attributeOption)
                    <x-dashboard.productsAttributes.option_card :option-number="$key + 1" :input-value="$attributeOption->value" :option-id="$attributeOption->id"/>
                @endforeach

                {{-- @for ($i = 1; $i <= count($data['attributeOptions']); $i++)
                    <x-dashboard.productsAttributes.option_card :option-number="$i" :input-value="$inputValue" />
                @endfor --}}

                <span class="btn btn-success btn-sm" id="add-new-option" style="margin-top: 23px; border-radius: 15px">
                    <i class="fas fa-plus"></i>
                </span>

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
        <script src="{{ asset('js/myScripts/products_attributes/edit.js') }}"></script>
    </x-slot>

</x-dashboard.master>
