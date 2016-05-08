@extends('website.layouts.panel')

@section('page-title')
    Narrowcasting Admin
@endsection

@section('panel-title')
    {{ ($item == null ? "Create new campaign." : "Edit campaign " . $item->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($item == null ? route("narrowcasting::add") : route("narrowcasting::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Campaign name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Lightsaber Building in the SmartXp" value="{{ $item->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="campaign_start">Campaign start:</label>
            <input type="text" class="form-control datetime-picker" id="campaign_start" name="campaign_start"
                   value="{{ ($item ? date('d-m-Y H:i', $item->campaign_start) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="campaign_end">Campaign end:</label>
            <input type="text" class="form-control datetime-picker" id="campaign_end" name="campaign_end"
                   value="{{ ($item ? date('d-m-Y H:i', $item->campaign_end) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="slide_duration">Slide duration in seconds:</label>
            <input type="text" class="form-control" id="slide_duration" name="slide_duration"
                   value="{{ $item->slide_duration or '30' }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image file:</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        @if($item != null)

            <label>Current image:</label>
            <img src="{{ route("file::get", ['id' => $item->image->id]) }}" style="width: 100%">

        @endif

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("narrowcasting::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection