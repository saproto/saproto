<tr style="{{ $override->active() ? '' : 'opacity: 0.5;' }}">

    <td>
        @foreach($override->getFixtures() as $fixture)
            {{ $fixture->name }}<br>
        @endforeach
    </td>
    <td>
                                    <span style="color: red;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->red() }}
                                    </span>
    </td>
    <td>
                                    <span style="color: green;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->green() }}
                                    </span>
    </td>
    <td>
                                    <span style="color: blue;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->blue() }}
                                    </span>
    </td>
    <td>
        <i class="fas fa-sun" aria-hidden="true"></i>
        {{ $override->brightness() }}
    </td>
    <td>
        Start: {{ date('l F j Y, H:i', $override->start) }}<br>
        End: {{ date('l F j Y, H:i', $override->end) }}
    </td>
    <td>
        <a class="btn btn-xs btn-default me-2"
           href="{{ route('dmx::override::edit', ['id' => $override->id]) }}">
            <i class="fas fa-edit"></i>
        </a>
        <a class="btn btn-xs btn-danger"
           href="{{ route('dmx::override::delete', ['id' => $override->id]) }}">
            <i class="fas fa-trash"></i>
        </a>
    </td>

</tr>