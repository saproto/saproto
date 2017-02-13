@extends('website.layouts.default-nobg')

@section('page-title')
    Quote Corner
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 col-md-push-8">

            @include('quotecorner.newquote')

        </div>

        <div class="col-md-8 col-md-pull-4">

            <div class="panel panel-default container-panel">

                <div class="panel-body">

                    <div id="latest">

                        @if(count($data) > 0)
                            <?php $entry = $data[0] ?>
                            <h4 style="margin-top: 0;">
                                <a href="{{ route('user::profile', ['id' => $entry->user->id]) }}">{{ $entry->user->name }}</a>
                                <span class="timestamp">{{ $entry->created_at->format("j M Y, H:m")  }}</span>
                            </h4>
                            <div id="bigquote">
                                <div><h1>{!! $entry["quote"] !!}</h1></div>
                            </div>
                            @if (Auth::check() && Auth::user()->can("board"))
                                <a href="{{ route('quotes::delete', ['id' => $entry->id]) }}">Remove</a>
                            @endif
                        @else
                            <h2>No quotes available. Add some yourself!</h2>
                        @endif

                    </div>

                </div>

            </div>

            @if(count($data) > 1)

                <div class="panel panel-default container-panel">

                    <div class="panel-body">

                        <div id="quotes">

                            @foreach($data as $key => $entry)
                                @if($key > 1)
                                    <hr>
                                @endif
                                @if($key > 0)
                                    <div>
                                        <p>
                                            <a href="{{ route('user::profile', ['id' => $entry->user->id]) }}">{{ $entry->user->name }}</a>
                                            <span class="timestamp">{{ $entry->created_at->format("j M Y, H:m") }}</span>
                                        </p>
                                        <h4>{!! $entry["quote"] !!}</h4>
                                        @if (Auth::check() && Auth::user()->can("board"))
                                            <a href="{{ route('quotes::delete', ['id' => $entry->id]) }}">Remove</a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        #bigquote {
            font-size: 50px;
            position: relative;
        }

        #bigquote::before {
            content: "“";
            position: absolute;
            top: 0;
        }

        #bigquote::after {
            content: "”";
            position: absolute;
            bottom: 0;
        }

        #bigquote * {
            display: inline-block;
            word-wrap: break-word;
            padding-left: 20px;
            padding-bottom: 30px;
            padding-top: 10px;
            padding-right: 15px;
            max-width: 100%;
        }

        #bigquote div {
            max-width: calc(100% - 18px);
        }

        .timestamp {
            color: #ccc;
            margin-left: 5px;
            font-size: 12px;
        }

        h4 {
            word-wrap: break-word;
        }

    </style>

@endsection
