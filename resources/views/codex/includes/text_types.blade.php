<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Text types
        @if(!isset($edit))
            <a href="{{ route('codex::add-text-type') }}" class="btn btn-info badge">
                New Text Type
            </a>
        @endif
    </div>
    <div class="card-body">
        <ul>
            @foreach($textTypes as $textType)
                <li>
                    <a class="text-reset" data-bs-toggle="collapse" data-bs-target=".collapse-text{{ $textType->id }}">
                        <b>{{ $textType->type }} ({{$textType->texts_count }})<br></b>
                    </a>
                    <div class="collapse collapse-text{{ $textType->id }}">
                        <ul>
                        @foreach($textType->texts as $text)
                            <li>
                            {{ $text->name}}
                            @if(isset($edit) && $edit)
                                <div class="form-check d-inline-flex">
                                    <input class="form-check-input" type="checkbox" name="textids[]" value="{{$text->id}}">
                                </div>
                            @endif
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>