@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $committee->name }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-{{ (Auth::check() ? '8' : '8 col-md-offset-2') }}">

            <div class="panel panel-default container-panel">

                <div class="panel-body">

                    {!! $committee->description !!}

                    <hr>

                    If you want, you can e-mail them at
                    <a href="mailto:{{ $committee->slug }}@proto.utwente.nl">
                        {{ $committee->slug }}@proto.utwente.nl
                    </a>
                    .

                </div>

                @if(Auth::check() && Auth::user()->can('board'))

                    <div class="panel-footer clearfix">
                        <a href="{{ route("committee::toggle", ["id" => $committee->id]) }}"
                           class="btn btn-danger pull-right">
                            Hide / Show
                        </a>
                        &nbsp;
                        <a href="{{ route("committee::edit", ["id" => $committee->id]) }}" class="btn btn-default">
                            Edit
                        </a>
                        <br>

                    </div>
                    
                @endif

            </div>

        </div>

        @if(Auth::check())

            <div class="col-md-4">

                @if(!$committee->public)
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-info">
                            This committee is hidden!
                        </a>
                    </div>
                    <br>
                @endif

                @foreach($members['editions'] as $edition)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $committee->name }}
                            <strong>{{ $edition[0]->pivot->edition }}</strong>
                        </div>
                        <div class="panel-body">
                            @foreach($edition as $i => $member)
                                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                                <br>
                                {{ $member->pivot->role }}
                                @if ($member->pivot->end)
                                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                                @else
                                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                                @endif
                                @if($i != count($edition) - 1)
                                    <hr class="committee-seperator">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if(count($members['members']['current']) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">Current members</strong>
                        </div>
                        <div class="panel-body">
                            @foreach($members['members']['current'] as $i => $member)
                                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                                <br>
                                {{ ($member->pivot->role ? $member->pivot->role : 'General Member') }}
                                @if ($member->pivot->end)
                                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                                @else
                                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                                @endif
                                @if($i != count($members['members']['current']) - 1)
                                    <hr class="committee-seperator">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(count($members['members']['past']) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">Past members</strong>
                        </div>
                        <div class="panel-body">
                            @foreach($members['members']['past'] as $i => $member)
                                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                                <br>
                                {{ ($member->pivot->role ? $member->pivot->role : 'General Member') }}
                                @if ($member->pivot->end)
                                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                                @else
                                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                                @endif
                                @if($i != count($members['members']['past']) - 1)
                                    <hr class="committee-seperator">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

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

    </style>

@endsection