<p>

    <strong>
        {{ $object->title }}
    </strong>

</p>

<p>
    {!! Markdown::convertToHtml($object->content) !!}
</p>

<div class="search__card__bottomfade"></div>