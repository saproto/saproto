@extends('website.layouts.default-nobg')

@section('page-title')
    Courses
@endsection

@section('content')

    <h2 class="courses__title">{{ Proto\Models\Study::find(config('proto.mainstudy'))->name }} @if(Auth::user()->can('board')) <a href="{{ route("course::add") }}">(add)</a> @endif</h2>

    <div class="courses__container">

        @if (count($mainCourses) > 0)

            <?php $i = 0; ?>

            @foreach($mainCourses as $key=>$courses)

                @if($i % 4 == 0) <div class="row courses__row-eq-height"> @endif

                    <div class="col-md-3 col-xs-12">

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                Year {{ ceil($key/4) }}, quartile {{ (($key - 1) % 4) + 1 }}
                            </div>

                            <div class="panel-body">
                                @foreach($courses as $course)
                                    <p>
                                        <a href="{!! $course->page->getUrl() !!}">{{ $course->page->title }}</a>

                                        @if(Auth::user()->can('board'))
                                            <a href="{{ route('course::delete', ['id' => $course->id]) }}">(delete)</a>
                                        @endif
                                    </p>
                                @endforeach
                            </div>

                        </div>

                    </div>

                    @if($i % 4 == 3) </div> @endif

                <?php $i++; ?>

            @endforeach

            @if($i < 4) </div> @endif

        @else

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <p style="text-align: center;">
                                There are currently no courses for this study.
                                @if(Auth::user()->can('board')) <a href="{{ route('course::add') }}">Create a new course.</a> @endif
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    </div>

    @if (count($otherCourses) > 0)

    <h2 class="courses__title">Other studies @if(Auth::user()->can('board')) <a href="{{ route("course::add") }}">(add)</a> @endif</h2>

    <div class="courses__container">

            <?php $i = 0; ?>

            @foreach($otherCourses as $key=>$courses)

                @if($i % 4 == 0) <div class="row courses__row-eq-height"> @endif

                    <div class="col-md-3 col-xs-12">

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                {{ Proto\Models\Study::find($key)->name }}
                            </div>

                            <div class="panel-body">
                                @foreach($courses as $course)
                                    <p>
                                        <a href="{!! $course->page->getUrl() !!}">{{ $course->page->title }}</a>

                                        @if(Auth::user()->can('board'))
                                            <a href="{{ route('course::delete', ['id' => $course->id]) }}">(delete)</a>
                                        @endif
                                    </p>
                                @endforeach
                            </div>

                        </div>

                    </div>

                    @if($i % 4 == 3) </div> @endif

                <?php $i++; ?>

            @endforeach

                @if($i < 4) </div> @endif

            </div>

    @endif

@endsection
