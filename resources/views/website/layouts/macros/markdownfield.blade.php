<textarea id="markdownfield-{{ $name }}" name="{{ $name }}"
          {!! isset($placeholder) && $placeholder !== null ? sprintf('placeholder="%s"', $placeholder) : null !!}
>{!! isset($value) && $value !== null ? $value : null !!}</textarea>

@push('javascript')

    <script>
        var simplemde = new SimpleMDE({
            element: $("#markdownfield-{{ $name }}")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "image", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
    </script>

@endpush