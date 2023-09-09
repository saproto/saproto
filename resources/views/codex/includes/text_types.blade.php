<div class="card mb-3">
    <div class="card-header">
        Text types
    </div>
    <div class="card-body">
        <ul>
            @foreach($textTypes as $textType)
                <li>
                    <b>{{ $textType->type }} ({{$textType->texts_count }})<br></b>
                    <ul>
                    @foreach($textType->texts as $text)
                        <li>
                        {{ $text->name}}
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>