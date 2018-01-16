@extends('website.layouts.default-nobg')

@section('page-title')
    News
@endsection

@section('content')

    @if(count($newsitems) == 0)

        <div class="row">

            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default news__card">
                    <div class="panel-body">
                        <p>
                            &nbsp;
                        </p>
                        <p style="text-align: center">
                            <strong>
                                There are currently no news articles.
                            </strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>

    @endif

    @foreach($newsitems as $index => $newsitem)

        @if ($index % 3 == 0)

            <div class="row">

                @endif

                <div class="col-md-4">

                    <a class="news__href" href="{{ $newsitem->url() }}">

                        <div class="panel panel-default news__card">

                            <div class="panel-body">

                                <p>
                                    <strong>
                                        {{ $newsitem->title }}
                                    </strong>
                                    <br/>
                                    <em>
                                        Published {{ Carbon::parse($newsitem->published_at)->diffForHumans() }}
                                    </em>
                                </p>

                                <p>
                                    {{ $newsitem->content }}
                                </p>

                            </div>

                        </div>

                    </a>

                </div>

                @if ($index %3 == 2 || $index + 1 == count($newsitems))

            </div>

        @endif

    @endforeach

@endsection
