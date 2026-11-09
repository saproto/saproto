{{-- format-ignore-start --}}
<textarea
    class="markdownfield"
    id="markdownfield-{{ $name }}"
    name="{{ $name }}"
    {!! isset($placeholder) ? sprintf('placeholder="%s"', $placeholder) : null !!}
>
    {!! $value ?? null !!}
</textarea>
{{-- format-ignore-end --}}
