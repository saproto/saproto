@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $category->title }} Board Archive
@endsection

@section('container')
    <div class="row">
        <div class="card mb-3 mx-4 w-100">

            <div class="card-header bg-dark text-white">
                <span class="m-0 float-left"><i class="fas fa-archive text-white mr-2"></i>Archived {{$category->title}}</span>
                <a href="{{ route('feedback::index', ['category' => $category->url]) }}" class="float-end ml-3 px-2 py-1 badge badge-info">
                    <i class="fas fa-thumbs-up text-white mr-1"></i> View Public
                </a>
            </div>

            <div class="card-body">

                @if(count($data) > 0)

                    <div class="row">

                        @foreach($data as $key => $entry)

                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                                @include('feedbackboards.include.feedback', [
                                'feedback' => $entry,
                                'controls' => true,
                                ])

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

            @if($data->links() != "")
                <div class="card-footer">
                    {{ $data->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection