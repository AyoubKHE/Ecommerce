<div class="d-flex flex-column" style="margin-right: 30px" id="option-card-{{ $optionNumber }}">
    @if ($optionId !== null)
        <input type="hidden" name="option-{{ $optionNumber }}-id-in-database" value="{{ $optionId }}">
    @endif

    <label for="" style="padding-left: 50px" id="label-option-{{ $optionNumber }}">valeur {{ $optionNumber }}:</label>
    <div class="d-flex align-items-center" style="gap: 10px">
        <input type="text" id="option-{{ $optionNumber }}" name="option_{{ $optionNumber }}" class="form-control" style="width: 150px" value="{{ $inputValue }}">
        <span class="btn btn-danger btn-sm" id="delete-option-{{ $optionNumber }}">
            <i class="fas fa-trash"></i>
        </span>
    </div>
</div>
