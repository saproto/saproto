@extends('website.layouts.default-nobg')

@section('page-title')
    Courses
@endsection

@section('content')

    <h2 class="courses__title">{{ Proto\Models\Study::find(config('proto.mainstudy'))->name }} @if(Auth::user()->can('board')) <a href="{{ route("course::add") }}">(add)</a> @endif</h2>

    @if (count($mainCourses) > 0)

        <div class="row">

        @foreach($mainCourses as $key=>$courses)

            <div class="col-md-4 col-xs-12">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Year {{ ceil($key/4) }}, quartile {{ $key % 4 }}
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

        @endforeach

        </div>

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

@endsection