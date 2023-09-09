<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Songs
        @if(!isset($edit))
            <a href="{{ route('codex::add-song') }}" class="btn btn-info badge">
                New Song
            </a>
        @endif
    </div>
    <div class="card-body">
        <ul>
            @foreach($songTypes as $songCategory)
                <li>
                    <a class="text-reset" data-bs-toggle="collapse" data-bs-target=".collapse-song{{ $songCategory->id }}">
                        <b> {{ $songCategory->name }} ({{$songCategory->songs_count}})</b><br>
                    </a>
                    <div class="collapse collapse-song{{  $songCategory->id }}">
                        <ul>
                            @foreach($songCategory->songs as $song)
                                <li>
                                    {{ $song->title}}
                                    @if(isset($edit) && $edit)
                                        <div class="form-check d-inline-flex">
                                            <input class="form-check-input" type="checkbox" name="songids[]" value="{{$song->id}}">
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