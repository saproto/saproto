@extends('website.layouts.default-nobg')

@section('page-title')
    Boards
@endsection

@section('content')

    @foreach($data as $key => $board)
        <div class="col-md-4 col-xs-6">

        <a href="{{ route('board::show', ['id' => $board->id]) }}" class="committee-link">
            <div class="committee"
                 style="{{ ($board->image ? "background-image: url(".$board->image->generateImagePath(450, 300).");" : '') }}">
                <div class="committee-name">
                    {{ $board->edition }}
                </div>
            </div>
        </a>

    </div>
    @endforeach

@endsection

