@extends('website.layouts.default-nobg')

@section('page-title')
    Committees
@endsection

@section('content')

    @foreach($data as $key => $committee)

        @if($key % 3 == 0)
            <div class="row">
                @endif

                <div class="col-md-4 col-xs-6">

                    <a href="{{ route('committee::show', ['id' => $committee->id]) }}" class="committee-link">
                        <div class="committee"
                             style="{{ ($committee->image ? "background-image: url(".$committee->image->generatePath().");" : '') }}">
                            <div class="committee-name">
                                {{ $committee->name }}
                            </div>
                            @if(!$committee->public)
                                <div class="committee-hidden">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            @endif
                        </div>
                    </a>

                </div>

                @if($key % 3 == 2)
            </div>
        @endif

    @endforeach

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .committee {
            position: relative;
            width: 100%;
            height: 200px;

            background-color: #666;
            background: linear-gradient(to bottom right, #333, #666);
            background-size: cover;
            background-position: center center;

            margin-bottom: 30px;
        }

        .committee-name {
            position: absolute;
            bottom: 0;

            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 30px;
        }

        .committee-link:hover {
            text-decoration: none;
        }

        .committee-hidden {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;

            opacity: 0.2;

            line-height: 150px;
            text-align: center;
            font-size: 120px;

            color: #fff;
        }

        .committee-hidden:hover {
            text-decoration: none;
        }

    </style>

@endsection