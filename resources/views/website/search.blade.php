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
                               placeholder="Enter year search term here and hit enter...">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($data) == 0 && $term != null)

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

                                    @if ($object->photo)

                                        <img src="{{ $object->photo->generateImagePath(125,150) }}"
                                             class="search__card__photo"/>

                                    @endif

                                    <p>
                                        <strong>
                                            {{ $object->name }}
                                        </strong>
                                    </p>

                                    <p>
                                        Member
                                        @if(date('U', strtotime($object->member->created_at)) > 0)
                                            since {{ date('F \'y', strtotime($object->member->created_at)) }}.
                                        @else
                                            since <strong>forever</strong>!
                                        @endif
                                    </p>

                                    <p>
                                        &nbsp;
                                    </p>

                                @elseif($object instanceof Proto\Models\Page)

                                    <p>

                                        <strong>
                                            {{ $object->title }}
                                        </strong>

                                    </p>

                                    <p>
                                        {!! Markdown::convertToHtml($object->content) !!}
                                    </p>

                                    <div class="search__card__bottomfade"></div>

                                @elseif($object instanceof Proto\Models\Committee)

                                    <p>
                                        <strong>{{ $object->name }}</strong>
                                    </p>

                                    <p>
                                        Committee of {{ $object->users->count() }} people.
                                    </p>

                                    @if ($object->image)

                                        <img src="{{ $object->image->generateImagePath(125,150) }}"
                                             class="search__card__photo"/>

                                    @endif

                                @elseif($object instanceof Proto\Models\Event)

                                    <p>
                                        <strong>{{ $object->title }}</strong>
                                    </p>

                                    <p>{{ date('d M Y, H:i', $object->start) }} -

                                        @if (($object->end - $object->start) < 3600 * 24)
                                            {{ date('H:i', $object->end) }}
                                        @else
                                            {{ date('d M, H:i', $object->end) }}
                                        @endif
                                    </p>

                                    <p>
                                        @ {{ $object->location }}
                                    </p>

                                    @if ($object->activity)
                                        @if ( $object->activity->canSubscribe())
                                            <p>
                                                <i>Sign-up required</i><br>
                                                {{ $object->activity->freeSpots() }} places available
                                            </p>
                                        @else
                                            <p style="opacity: 0.5;">
                                                <i>Sign-up closed</i>
                                            </p>
                                        @endif
                                    @else
                                        <p style="opacity: 0.5;">
                                            <i>No sign-up required</i>
                                        </p>
                                    @endif

                                    @if ($object->image)

                                        <img src="{{ $object->image->generateImagePath(125,150) }}"
                                             class="search__card__photo"/>

                                    @endif

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
