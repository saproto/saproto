<div class="card mb-3">
    <div class="card-header">
        Songs
    </div>
    <div class="card-body">
        <ul>
            @foreach($songTypes as $songCategory)
                <li>
                   <b> {{ $songCategory->name }} ({{$songCategory->songs_count}})</b><br>
                    <ul>
                        @foreach($songCategory->songs as $song)
                            <li>
                                {{ $song->title}}
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>