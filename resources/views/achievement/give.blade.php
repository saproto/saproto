@extends('website.layouts.panel')

@section('page-title')
    Achievement Administration
@endsection

@section('panel-title')
    Give an Achievement
@endsection

@section('panel-body')

    <form method="post"
          action="{{ route("achievement::give", ['id' => $achievement->id]) }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="id">to user:</label>
            <input type="text" class="form-control" id="id" name="id" placeholder="681" required>
        </div>

        <hr>

        <strong>Achievement to give:</strong>
        <li class="list-group-item achievement">

            <img src="{{ $achievement->img_file_id }}" alt="{{ $achievement->name }} icon"/>
            <div>
                <strong>{{ $achievement->name }}</strong>
                <p>{{ $achievement->desc }}</p>
            </div>

        </li>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Give</button>

            <a href="{{ route("achievement::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .achievement img, .achievement div {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .achievement {
            overflow: hidden;
            word-wrap: break-word;
        }

    </style>

@endsection