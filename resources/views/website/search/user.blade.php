@if ($object->photo)

    <img src="{{ $object->photo->generateImagePath(125,150) }}"
         class="search__card__photo"/>

@endif

<p>
    <strong>
        {{ $object->name }}
    </strong>
</p>

<p>
    Member
    @if(date('U', strtotime($object->member->created_at)) > 0)
        since {{ date('F \'y', strtotime($object->member->created_at)) }}.
    @else
        since <strong>forever</strong>!
    @endif
</p>

<p>
    &nbsp;
</p>