@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if($new) Add new menu item @else Edit menu item @endif
@endsection

@section('container')

    <form method="post"
          action="{{ ($new ? route("menu::add") : route("menu::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row justify-content-center">

            <div class="col-md-3">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="menuname">Menu name:</label>
                            <input type="text" class="form-control" id="menuname" name="menuname"
                                   placeholder="About Proto" value="{{ $item->menuname ?? '' }}" required>
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
                                <option {{ $new ? 'selected' : '' }} disabled>Select a page...</option>
                                <option disabled>---</option>
                                <option {{ !($new && isset($item->pageId)) ? 'selected' : '' }} value="0">Other URL</option>
                                <option disabled>---</option>
                                @foreach($pages as $page)
                                    <option {{ !$new && $page->id == $item->pageId ? 'selected' : '' }} value="{{ $page->id }}">
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="menu-other-url" class="{{$new || isset($item->pageId) ? 'd-none' : ''}}">

                            <div class="form-group">
                                <label for="url">Other URL:</label>
                                <input type="text" class="form-control" id="url" name="url"
                                       placeholder="http://www.proto.utwente.nl/" value="{{ $item->url ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="route">Existing Route:</label>
                                <select class="form-control" id="route">
                                    <option disabled selected>Select a route...</option>
                                    @foreach($routes as $route)
                                        @if (
                                            $route->getName() &&
                                            strpos($route->uri(), '{') === false &&
                                            strpos(implode("|",$route->methods()), 'GET') >= 0
                                        )
                                            @php
                                            $url = 'https://' .
                                                ($route->domain() == null ? config('app-proto.primary-domain') : $route->domain()) .
                                                '/' .
                                                ($route->uri() == '/' ? '' : $route->uri());
                                            @endphp
                                            <option value="{{ $route->getName() }}">
                                                {{ $url }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-end">Submit</button>

                        <a href="{{ route("menu::list") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        const otherUrlFields = document.getElementById('menu-other-url')
        document.getElementById('page_id').addEventListener('change', e => {
            if (e.target.value === '0') otherUrlFields.classList.remove('d-none')
            else otherUrlFields.classList.add('d-none')
        })

        document.getElementById('route').addEventListener('change', e => {
            document.getElementById('url').value = '(route)' + e.target.value
        })
    </script>

@endpush