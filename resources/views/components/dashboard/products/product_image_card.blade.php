<div class="d-flex flex-column align-items-center justify-content-around"
    style="width: 25%; border: solid 2px darkgrey; border-radius: 10px; padding: 10px">

    <div class="d-flex align-items-center justify-content-between" style="width: 100%">
        <label for="">image {{ $imageNumber }}</label>
        <span class="btn btn-danger btn-sm" id="delete-product-image-{{ $imageNumber }}">
            <i class="fas fa-trash"></i>
        </span>
    </div>


    <img src="{{ asset('storage/' . $imagePath) }}" class="product-image" style="width: 100%; height: 250px; margin: 10px 0"
        id="product-image-{{ $imageNumber }}">

    <input type="file" name="product_image_{{ $imageNumber }}" class="form-control" />

    <div>
        <label for="default-product-image-{{ $imageNumber }}">image par défaut: </label>
        <input type="radio" name="is_default" id="default-product-image-{{ $imageNumber }}"
            value="product_image_{{ $imageNumber }}"
            {{ $isDefault === 1 ? 'checked' : '' }}
            {{ $isDisabled === 1 ? 'disabled' : '' }}
            >
    </div>

    @error('product_image_{{ $imageNumber }}')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
