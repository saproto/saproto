<textarea id="markdownfield-{{ $name }}" name="{{ $name }}"
          {!! isset($placeholder) ? sprintf('placeholder="%s"', $placeholder) : null !!}
>{!! $value ?? null !!}</textarea>

@push('javascript')

    <script nonce="{{ csp_nonce() }}">
        new EasyMDE({
            element: $("#markdownfield-{{ $name }}")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "image", "link", "quote", "table", "code", "|", "preview"],
            autoDownloadFontAwesome: false
        });

        $('.editor-statusbar').each(function() {
            if ($(this).find(".md-ref").length === 0)
                $(this).prepend("<a class='md-ref float-start' target='_blank' href='https://www.markdownguide.org/basic-syntax/'>markdown syntax</a>");
        });
    </script>

@endpush