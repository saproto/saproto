@extends('website.layouts.default')

@section('content')

    <div class="col-md-4 col-md-offset-4 col-xs-12 col-xs-offset-0">

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

    @parent

@endsection