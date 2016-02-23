@extends('website.default.container')

@section('container')

    <div class="col-md-6 col-md-offset-3 col-xs-12 col-xs-offset-0">

        <div class="panel panel-default">
            <div class="panel-heading">
                @section('panel-title')
                    Panel Title
                @show
            </div>
            <div class="panel-body">
                @section('panel-body')
                    Content
                @show
            </div>
        </div>

    </div>

@endsection