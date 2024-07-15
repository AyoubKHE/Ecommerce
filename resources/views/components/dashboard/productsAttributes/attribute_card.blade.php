<div class="d-flex flex-column" style="margin-right: 30px" id="attribute-card-{{ $attributeNumber }}">
    @if ($attributeId !== null)
        <input type="hidden" name="attribute-{{ $attributeNumber }}-id-in-database" value="{{ $attributeId }}">
    @endif

    <div class="d-flex align-items-center" style="gap: 10px">
        <input type="text" id="attribute-{{ $attributeNumber }}" name="attribute_{{ $attributeNumber }}" class="form-control" style="width: 150px" value="{{ $inputValue }}">
        <span class="btn btn-danger btn-sm" id="delete-attribute-{{ $attributeNumber }}">
            <i class="fas fa-trash"></i>
        </span>
    </div>
</div>
