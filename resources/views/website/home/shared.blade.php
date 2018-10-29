@extends('website.layouts.redesign.generic')

@section('page-title')
    Homepage
@endsection

@section('container')

    @if(count($companies) > 0)

        <div class="card mb-3">
            <div class="card-body pb-0">
                <div class="row justify-content-center align-items-center">

                    @foreach($companies as $i => $company)

                        <div class="col-2 mb-3 text-center align-items-center">
                            <a href="{{ route('companies::show', ['id' => $company->id]) }}">
                                <img src="{{ $company->image->generateImagePath(null, 50) }}">
                            </a>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>

    @endif

    <div class="row">

        <div class="col-xl-9 col-md-12">

            <div class="card text-white mb-3 border-0" style="height: 250px;
            @if($header)
                    background-image: url({{ $header->image->generateImagePath(1500, 400) }});
                    background-size: cover; background-position: center center;
                    text-shadow: 0 0 10px #000;
            @else
                    background-color: var(--primary);
                    height: 150px !important;
            @endif">
                @if($header && $header->user)
                    <small class="ellipsis text-right pr-3 pt-2">
                        @if (Auth::check() && Auth::user()->member && $header->user->member)
                            Photo by <a href="{{ route('user::profile', ['id' => $header->user->id]) }}"
                                        class="text-white">
                                {{ $header->user->name }}</a>
                        @else
                            Photo by {{ $header->user->name }}
                        @endif
                    </small>
                @endif
                <div class="card-body"
                     style="text-align: left; vertical-align: bottom; font-size: 30px; display: flex;">
                    <p class="card-text ellipsis px-1" style="align-self: flex-end;">
                        @section('greeting')
                        @show
                    </p>
                </div>
            </div>

            @section('left-column')
            @show

        </div>

        <div class="col-xl-3 col-md-12">

            @include('website.layouts.macros.recentalbums', ['n' => 4])

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">Proto.ink articles</div>
                <div class="card-body">
                    <ul id="protoink" class="list-group mb-3">
                        <li class="list-group-item ">Loading articles...</li>
                    </ul>
                    <a href="https://www.proto.ink" class="btn btn-info btn-block">Visit Proto.ink</a>
                </div>
            </div>

        </div>

    </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="application/javascript">

        $(document).ready(function () {

            $.ajax({
                type: 'GET',
                url: '{{ route('api::protoink') }}?max=4',
                dataType: 'json',
                success: function (data) {

                    $("#protoink").html("");

                    if (data.length < 1) {
                        $("#protoink").html("<li class='list-group-item'>Could not load articles.</a>");
                    }

                    for (i in data) {
                        var item = data[i];
                        $("#protoink").append("<a href='" + item.link.replace('http://', 'https://') + "' class='list-group-item leftborder leftborder-info' style='text-decoration: none !important;'>" + item.title + "</a>");
                    }

                },
                error: function (xhr, textStatus, errorThrown) {
                    $("#protoink").html('<p style="text-align: center">Something went wrong loading the ProtoInk articles!<p>');
                }
            });

        });

    </script>

@endsection
