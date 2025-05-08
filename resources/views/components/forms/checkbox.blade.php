<div class="form-check">
    <input
        class="form-check-input {{ $input_class_name ?? '' }}"
        type="{{ $type ?? 'checkbox' }}"
        value="{{ $value ?? '1' }}"
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        @checked(old($name, $checked ?? false))
        @disabled($disabled ?? false)
        @required($required ?? false)
    />
    <label class="form-check-label" for="{{ $id ?? $name }}">
        {!! $label !!}
    </label>
</div>
