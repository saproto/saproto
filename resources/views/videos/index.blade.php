@extends('website.layouts.default')

@section('page-title')
    Videos Admin
@endsection

@section('content')

    <form class="form-inline" style="text-align: center;" method="post" action="{{ route('video::admin::add') }}">

        {!! csrf_field(); !!}

        <div class="form-group">
            <label>YouTube video ID:</label>
            <input type="text" class="form-control" name="youtube_id" placeholder="M11SvDtPBhA">
        </div>

        <button type="submit" class="btn btn-success">Add video</button>

    </form>

    <hr>

    @if (count($videos) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Length</th>
                <th>Event</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($videos as $video)

                <tr>
                    <td>{{ $video->id }}</td>
                    <td><a href="{{$video->getYouTubeUrl()}}">{{ $video->title }}</a></td>
                    <td>{{ date('d-m-Y', $video->getUnixTimeStamp()) }}</td>
                    <td>{{ $video->getHumanDuration() }}</td>
                    <td>
                        @if ($video->event)
                            <a href="{{ route('event::show',['id'=>$video->event->getPublicId()]) }}">
                                {{  sprintf("%s (%s)",$video->event->title,date('d-m-Y', $video->event->start)) }}
                            </a>
                        @else
                            <i style="color: lightgray">none</i>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('video::view', ['id' => $video->id]) }}" role="button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('video::admin::edit', ['id' => $video->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           onclick="return confirm('Delete this video: {{ $video->title }}?')"
                           href="{{ route('video::admin::delete', ['id' => $video->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are currently no videos.
        </p>

    @endif

@endsection