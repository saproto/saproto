@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $committee->name }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-{{ (Auth::check() ? '7' : '6 col-md-offset-6') }}">

            <div class="panel panel-default container-panel">

                <div class="panel-body">

                    {!! $committee->description !!}

                    <hr>

                    If you want, you can e-mail them at
                    <a href="mailto:{{ $committee->slug . "@" . config('proto.emaildomain') }}">
                        {{ $committee->slug . "@" . config('proto.emaildomain') }}
                    </a>.

                </div>

                @if(Auth::check() && Auth::user()->can('board'))

                    <div class="panel-footer clearfix">
                        <a href="{{ route("committee::edit", ["id" => $committee->id]) }}" class="btn btn-default">
                            Edit
                        </a>
                    </div>

                @endif

            </div>

        </div>

        @if(Auth::check())

            <div class="col-md-5">

                @if(!$committee->public)
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-info">
                            This committee is hidden!
                        </a>
                    </div>
                    <br>
                @endif

                @include('committee.members-list')

            </div>

        @endif

    </div>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .committee-seperator {
            margin: 10px 0;
        }

        @if($committee->image)
        #header {
            background-image: url('{{ $committee->image->generatePath() }}');
        }
        @endif

    </style>

@endsection