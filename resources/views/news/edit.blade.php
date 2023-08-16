@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if($new)
        Create news!
    @else
        Edit news article {{ $item->title }}
    @endif
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="post"
                  action="@if($new) {{ route("news::add") }} @else {{ route("news::edit", ['id' => $item->id]) }} @endif"
                  enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Revolutionary new activity!" value="{{ $item->title ?? '' }}" required>
                        </div>

                        @include('components.forms.datetimepicker', [
                            'name' => 'published_at',
                            'label' => 'Publish at:',
                            'placeholder' => $item ? strtotime($item->published_at) : strtotime(Carbon::now())
                        ])

                        <div class="form-group">
                            <label for="editor">Content</label>
                            @include('components.forms.markdownfield', [
                                'name' => 'content',
                                'placeholder' => 'Text goes here.',
                                'value' => $item ? $item->content : null
                            ])
                        </div>

                    </div>

                    <div class="card-footer">

                        <a href="{{ route("news::list") }}" class="btn btn-default">Cancel</a>

                        <button type="submit" name="weekly" class="btn btn-warning float-end">Send as weekly</button>
                        <button type="submit" name="newsitem" class="btn btn-success float-end">Save as newsitem</button>
                    </div>

                </div>

            </form>

        </div>

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    Activities in the newsitem
                </div>

                @php
                    $events=[];
                @endphp

                @if (count($events) > 0)

                    <table class="table table-sm table-hover">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td>Event</td>
                            <td>When</td>
                            <td></td>
                            <td></td>

                        </tr>

                        </thead>

                        @foreach($events as $event)

                            <tr class="{{ $event->include_in_newsletter ? '' : 'opacity-50' }}">

                                <td>{{ $event->title }}</td>
                                <td>{{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}</td>
                                <td>
                                    <i class="fas fa-{{ ($event->include_in_newsletter ? 'check' : 'times') }}"
                                       aria-hidden="true"></i>
                                </td>
                                <td>
                                    <a href="{{ route('newsletter::toggle', ['id' => $event->id]) }}">
                                        Toggle
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </table>

                @else

                    <div class="card-body">
                        <p class="card-text text-center">
                            There are no upcoming events. Seriously. Go fix that {{ Auth::user()->calling_name }}.
                        </p>
                    </div>

                @endif

            </div>

        </div>

        @if(!$new)

            <div class="col-md-3">

                <form method="post" action="{{ route("news::image", ["id" => $item->id]) }}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="card mb-3">

                        @if($item->featuredImage)
                            <img src="{!! $item->featuredImage->generateImagePath(700,null) !!}" width="100%;"
                                 class="card-img-top">
                        @endif

                        <div class="card-body">

                            <div class="custom-file">
                                <input id="featured-image" type="file" class="form-control" name="image">
                                <label for="featured-image" class="form-label">Upload featured image</label>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-block">
                                Replace featured image
                            </button>
                        </div>

                    </div>

                </form>


            </div>

        @endif

    </div>

@endsection