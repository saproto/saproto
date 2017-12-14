<p>
    <strong>{{ $object->title }}</strong>
</p>

<p>{{ date('d M Y, H:i', $object->start) }} -

    @if (($object->end - $object->start) < 3600 * 24)
        {{ date('H:i', $object->end) }}
    @else
        {{ date('d M, H:i', $object->end) }}
    @endif
</p>

<p>
    @ {{ $object->location }}
</p>

@if ($object->activity)
    @if ( $object->activity->canSubscribe())
        <p>
            <i>Sign-up required</i><br>
            {{ $object->activity->freeSpots() }} places available
        </p>
    @else
        <p style="opacity: 0.5;">
            <i>Sign-up closed</i>
        </p>
    @endif
@else
    <p style="opacity: 0.5;">
        <i>No sign-up required</i>
    </p>
@endif

@if ($object->image)

    <img src="{{ $object->image->generateImagePath(125,150) }}"
         class="search__card__photo"/>

@endif