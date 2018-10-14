@extends('website.layouts.panel')

@section('page-title')

    @if($new) Menu Admin @endif

@endsection

@section('panel-title')

    @if($new) Add new menu item @else Edit menu item @endif

@endsection



@section('panel-body')

    <form method="post"
          action="{{ ($new ? route("menu::add") : route("menu::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="menuname">Menu name:</label>
            <input type="text" class="form-control" id="menuname" name="menuname"
                   placeholder="About Proto" value="{{ $item->menuname or '' }}" required>
        </div>

        <div class="form-group">
            <label for="parent">Parent:</label>
            <select class="form-control" name="parent" id="parent">
                <option @if($new || $item->parent == null) selected @endif value="0">No parent</option>
                @foreach($topMenuItems as $topMenuItem)
                    <option @if(!$new && $topMenuItem->id == $item->parent) selected
                            @endif value="{{ $topMenuItem->id }}"
                            @if(!$new && $topMenuItem->id == $item->id) disabled @endif>{{ $topMenuItem->menuname }}</option>
                @endforeach
            </select>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_member_only"
                       @if(isset($item->is_member_only) && $item->is_member_only) checked @endif>
                <i class="fas fa-lock" aria-hidden="true"></i> Members only
            </label>
        </div>

        <div class="form-group">
            <label for="page_id">Target page:</label>
            <select class="form-control" name="page_id" id="page_id">
                <option @if($new) selected @endif disabled>Select a page...</option>
                <option disabled>---</option>
                <option @if(!$new && $item->pageId == null) selected @endif value="0">Other URL</option>
                <option disabled>---</option>
                @foreach($pages as $page)
                    <option @if(!$new && $page->id == $item->pageId) selected
                            @endif value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" @if($new || !$item->pageId == null) style="display: none;" @endif id="menu__otherUrl">
            <label for="url">Other URL:</label>
            <input type="text" class="form-control" id="url" name="url"
                   placeholder="http://www.proto.utwente.nl/" value="{{ $item->url or '' }}">
        </div>

        <div class="form-group" @if($new || !$item->pageId == null) style="display: none;"
             @endif id="menu__otherUrlRoute">
            <label for="url">Existing Route:</label>
            <select class="form-control" id="route">
                <option disabled selected>Select a route...</option>
                @foreach($routes as $route)
                    @if (
                        $route->getName() &&
                        strpos($route->uri(), '{') === false &&
                        strpos(implode("|",$route->methods()), 'GET') >= 0
                    )
                        <?php
                        $url = 'https://' .
                            ($route->domain() == null ? config('app-proto.primary-domain') : $route->domain()) .
                            '/' .
                            ($route->uri() == '/' ? '' : $route->uri());
                        ?>
                        <option value="{{ $route->getName() }}">
                            {{ $url }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("menu::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script>
        $("#page_id").change(function () {
            if ($(this).val() == 0) {
                $("#menu__otherUrl").show(0);
                $("#menu__otherUrlRoute").show(0);
            } else {
                $("#menu__otherUrl").hide(0);
                $("#menu__otherUrlRoute").hide(0);
            }
        });

        $("#route").change(function () {
            $("#url").val("(route) "+$(this).val());
        });
    </script>

@endsection