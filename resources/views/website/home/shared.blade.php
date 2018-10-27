@extends('website.layouts.redesign.generic')

@section('page-title')
    Homepage
@endsection

@section('container')

    <div class="row">

        <div class="col-xl-9 col-md-12">

            <div class="card text-white mb-3 border-0" style="height: 250px;
                    background-image: url({{ asset(sprintf('images/header/header%s.jpg', mt_rand(1,8))) }});
                    background-size: cover; background-position: center center;">
                <div class="card-body" style="text-align: left; vertical-align: bottom; font-size: 30px; display: flex;
                             text-shadow: 0 0 20px #000;">
                    <p class="card-text ellipsis" style="align-self: flex-end;">
                        @section('greeting')
                        @show
                    </p>
                </div>
            </div>

            @if(count($companies) > 0)

                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center;">

                            @foreach($companies as $company)

                                <a href="{{ route('companies::show', ['id' => $company->id]) }}" class="mr-5">
                                    <img src="{{ $company->image->generateImagePath(null, 50) }}">
                                </a>

                            @endforeach

                        </p>
                    </div>
                </div>

            @endif

            @section('left-column')
            @show

        </div>

        <div class="col-xl-3 col-md-12">

            @include('website.layouts.macros.recentalbums', ['n' => 4])

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">Proto.ink articles</div>
                <ul id="protoink" class="list-group list-group-flush">
                    <li class="list-group-item">Loading articles...</li>
                </ul>
                <div class="card-body">
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
                        $("#protoink").append("<a href='" + item.link.replace('http://', 'https://') + "' class='list-group-item' style='text-decoration: none !important;'>" + item.title + "</a>");
                    }

                },
                error: function (xhr, textStatus, errorThrown) {
                    $("#protoink").html('<p style="text-align: center">Something went wrong loading the ProtoInk articles!<p>');
                }
            });

        });

    </script>

@endsection
