@extends('website.layouts.content')

@section('container')

    <div id="container" class="container container-nobg">

        <div class="col-md-6 col-md-offset-3 col-xs-12 col-xs-offset-0">

            @include('website.announcements')

            <div class="panel panel-default">
                <div class="panel-heading">
                    @section('panel-title')
                    @show
                </div>
                <div class="panel-body clearfix">
                    @section('panel-body')
                    @show
                </div>
                <div class="panel-footer clearfix">
                    @section('panel-footer')
                    @show
                </div>
            </div>

        </div>

    </div>

@endsection
