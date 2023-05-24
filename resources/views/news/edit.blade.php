@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if($new)
        Create new news article
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

                        <button type="submit" class="btn btn-success float-end">
                            Submit
                        </button>

                        <a href="{{ route("news::list") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </form>

        </div>

        @if(!$new)

            <div class="col-md-3">

                <form method="post" action="{{ route("news::image", ["id" => $item->id]) }}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="card mb-3">

                        @if($item->featuredImage)
                            <img src="{!! $item->featuredImage->generateUrl() !!}" width="100%;"
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