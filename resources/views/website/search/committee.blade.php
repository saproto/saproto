<p>
    <strong>{{ $object->name }}</strong>
</p>

<p>
    Committee of {{ $object->users->count() }} people.
</p>

@if ($object->image)

    <img src="{{ $object->image->generateImagePath(125,150) }}"
         class="search__card__photo"/>

@endif