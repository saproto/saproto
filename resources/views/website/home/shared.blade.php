@extends('website.layouts.content')

@section('page-title')
    Homepage
@endsection

@section('header')

    <div id="header" class="main__header">

        <div class="container">

            @section('greeting')
            @show

        </div>
    </div>

@endsection

@section('container')

    @if(count($companies) > 0)

        <div class="row homepage__companyrow">

            <div class="homepage__companyrow__inner">

                @foreach($companies as $company)

                    <a href="{{ route('companies::show', ['id' => $company->id]) }}">
                        <img class="homepage__companyimage"
                             src="{{ $company->image->generateImagePath(null, 50) }}">
                    </a>

                @endforeach

            </div>

        </div>

    @endif

    <div class="container" style="margin-top: 30px;">

        @include('kickin.notice')

        @section('visitor-specific')
        @show

        <hr>

        <h1 style="text-align: center; color: #fff; margin: 30px;">
            Recent <img src="{{ asset('images/application/protoink.png') }}" alt="/Proto/.Ink" width="160"> articles
        </h1>

        <div class="row" id="protoink">
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

                    if (data.length < 1) {
                        $("#protoink").html('<p style="text-align: center">Something went wrong loading the ProtoInk articles!<p>');
                    }

                    for (i in data) {
                        var item = data[i];
                        $("#protoink").append("<div class='col-md-6 col-xs-12'><div class='protoink__article' style='background-image: url(\"" + item.thumbnail.replace('http://', 'https://') + "\");'><a target='_blank' href='" + item.link.replace('http://', 'https://') + "' class='protoink__title'>" + item.title + "</a></div></div>")
                    }

                },
                error: function (xhr, textStatus, errorThrown) {
                    $("#protoink").html('<p style="text-align: center">Something went wrong loading the ProtoInk articles!<p>');
                }
            });

        });

    </script>

@endsection
