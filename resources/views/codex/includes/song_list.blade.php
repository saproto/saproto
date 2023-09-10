<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Songs
        @if(!isset($edit))
            <div>
                <a href="{{ route('codex::add-song') }}" class="btn btn-info badge">
                    New Song
                </a>

                <a href="{{ route('codex::add-song') }}" class="btn btn-info badge">
                    New Song type
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
        <ul>
            @foreach($songTypes as $songCategory)
                <li>
                    <div class="d-inline-flex">
                        <a class="text-reset" data-bs-toggle="collapse" data-bs-target=".collapse-song{{ $songCategory->id }}">
                            <b> {{ $songCategory->name }} ({{$songCategory->songs_count}})</b> <a href="{{ route('codex::edit-song-category', ['id' => $songCategory->id]) }}" class="btn btn-info badge m-1">Edit</a></b>
                            <br>
                        </a>
                        @if(isset($edit) && $edit)
                            <div class="form-check d-inline-flex text-secondary">
                                <input class="form-check-input" type="checkbox" name="shuffleids[]" {{in_array($songCategory->id, $myShuffles)?"checked":""}} value="{{$songCategory->id}}"> shuffle category in export?
                            </div>
                        @endif
                    </div>
                    <div class="collapse collapse-song{{  $songCategory->id }}">
                        <ul>
                            @foreach($songCategory->songs as $song)
                                <li>
                                    @if(isset($edit) && $edit)
                                        <div class="form-check d-inline-flex">
                                            <input class="form-check-input" type="checkbox" name="songids[]" {{in_array($song->id, $mySongs)?"checked":""}} value="{{$song->id}}">
                                        </div>
                                    @endif

                                        {{ $song->title}}
                                        <a href="{{ route('codex::edit-song', ['id' => $song->id]) }}" class="btn btn-info badge m-1">Edit</a></b>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>