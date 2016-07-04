@extends('website.layouts.panel')

@section('page-title')
    Page Admin
@endsection

@section('panel-title')
    {{ ($item == null ? "Create new page." : "Edit page " . $item->title .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($item == null ? route("page::add") : route("page::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="title">Page:</label>
            <input type="text" class="form-control" id="title" name="title"
                   placeholder="About Proto" value="{{ $item->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" class="form-control datetime-picker" id="slug" name="slug" placeholder="about-proto"
                   value="{{ $item->slug or '' }}" required>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="members_only" @if(isset($item->members_only) && $item->members_only) checked @endif>
                This page is for members only.
            </label>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("page::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent



@endsection