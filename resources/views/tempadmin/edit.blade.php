@extends('website.layouts.panel')

@section('page-title')

    Temp Admin Admin

@endsection

@section('panel-title')

    @if($new) New temp admin @else Edit temp admin @endif

@endsection



@section('panel-body')

    <form method="post"
          action="{{ ($new ? route("tempadmin::add") : route("tempadmin::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="menuname">User:</label>
            @if($new)
                <div class="input-group" style="width: 100%;">
                    <select class="form-control user-search" name="user_id" required></select>
                </div>
            @else
                <div class="input-group">
                    <strong>{{ $item->user->name }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="url">Start at:</label>
            <input type="datetime" class="form-control" id="start_at" name="start_at" value="{{ $new ? Carbon::now() : $item->start_at }}">
        </div>

        <div class="form-group">
            <label for="url">End at:</label>
            <input type="datetime" class="form-control" id="end_at" name="end_at" value="{{ $new ? Carbon::tomorrow() : $item->end_at }}">
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("tempadmin::index") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection