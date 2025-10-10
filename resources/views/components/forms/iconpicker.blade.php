<div class="form-group">
    @isset($label)
        <label for="iconpicker-{{ $name }}">{{ $label }}</label>
    @endisset

    <div class="input-group iconpicker-wrapper mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text selected-icon h-100"></span>
        </div>
        <input
            id="iconpicker-{{ $name }}"
            type="text"
            name="{{ $name }}"
            class="form-control iconpicker rounded-2"
            value="{{ $placeholder ?? '' }}"
        />
    </div>
</div>
