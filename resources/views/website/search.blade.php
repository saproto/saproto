@extends('website.layouts.default-nobg')

@section('page-title')
    Search
    @if ($term != null & strlen($term) > 0)
        results for {{ $term }}
    @endif
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <form method="post" action="{{ route('search') }}">
                        {!! csrf_field() !!}
                        <input type="text" name="query" class="form-control"
                               placeholder="Enter your search term here and hit enter...">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($users) + count($committees) + count($pages) + count($events) == 0 && $term != null)

        <div class="row">

            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default search__card">
                    <div class="panel-body ">
                        <p>
                            &nbsp;
                        </p>
                        <p style="text-align: center">
                            <strong>
                                Your search returned no results.
                            </strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>

    @endif

    <?php $data = array_merge($users, $committees, $pages, $events); ?>

    @foreach($data as $index => $result)

        <?php $object = $result['object']; ?>

        @if ($index % 3 == 0)

            <div class="row">

        @endif

        <div class="col-md-4">

            <a class="search__href" href="{{ $result['href'] }}">

                <div class="panel panel-default search__card">

                    <div class="panel-body ">

                        @if($object instanceof Proto\Models\User)

                            @include('website.search.user')

                        @elseif($object instanceof Proto\Models\Page)

                            @include('website.search.page')

                        @elseif($object instanceof Proto\Models\Committee)

                            @include('website.search.committee')

                        @elseif($object instanceof Proto\Models\Event)

                            @include('website.search.event')

                        @else

                            Unknown object type

                        @endif

                    </div>

                </div>

            </a>

        </div>

        @if ($index %3 == 2 || $index + 1 == count($data))

            </div>

        @endif

    @endforeach

@endsection
