<div>
    @php $uniqueInputID = (isset($option) ? $option['id'] : '0') . '-' . uniqid(); @endphp

    <input type="hidden" class="form-control" name="options[{{ $uniqueInputID }}][id]"
        value="{{ isset($option) ? $option['id'] : '' }}" />

    <div class="row">

        <div class="col-md-5 col-12">
            <div class="mb-1">
                <label class="form-label" for="offer-option__name">Name</label>
                <input type="text" class="form-control" id="offer-option__name"
                    name="options[{{ $uniqueInputID }}][name]" value="{{ isset($option) ? $option['name'] : '' }}" />
            </div>
        </div>

        <div class="col-md-5 col-12">
            <div class="mb-1">
                <label class="form-label" for="offer-option__percentage">Percentage</label>
                <input type="number" class="form-control" min="0" max="100" id="offer-option__percentage"
                    name="options[{{ $uniqueInputID }}][percentage]"
                    value="{{ isset($option) ? $option['percentage'] : '' }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-12">
            <div class="mb-1">
                <label class="form-label" for="offer-option__balance">Balance</label>
                <input type="text" class="form-control numeral-mask" id="offer-option__balance"
                    name="options[{{ $uniqueInputID }}][balance]"
                    value="{{ isset($option) ? $option['balance'] : '' }}" />
            </div>
        </div>

        <div class="col-md-5 col-12">
            <div class="mb-1">
                <label class="form-label" for="offer-option__days">Days</label>
                <input type="text" class="form-control numeral-mask" id="offer-option__days"
                    name="options[{{ $uniqueInputID }}][days]" value="{{ isset($option) ? $option['days'] : '' }}" />
            </div>
        </div>

        <div class="col-md-2 col-12">
            @php $canDelete = !isset($option) || count($option->activeOfferSubscriptions) == 0; @endphp
            <button class="btn btn-outline-danger text-nowrap px-1 mt-2 {{ $canDelete ? '' : 'd-none' }} delete-button"
                data-repeater-delete type="button">
                <i data-feather="x" class="me-25"></i>
                <span>Delete</span>
            </button>
        </div>
    </div>
</div>
