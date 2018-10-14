@extends('website.home.shared')

@section('greeting')

    <strong>Hi, {{ Auth::user()->calling_name }}</strong><br>
    @if($message != null) {{ $message->message }} @else Nice to see you back! @endif

@endsection

@section('left-column')

    <div class="row">

        <div class="col-xl-4 col-md-12">

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">News</div>
                <div class="card-body">

                    @if(count($newsitems) > 0)


                        @foreach($newsitems as $index => $newsitem)

                            @include('website.layouts.macros.card-bg-image', [
                            'url' => $newsitem->url(),
                            'img' => $newsitem->featuredImage ? $newsitem->featuredImage->generateImagePath(300,200) : null,
                            'html' => sprintf('<strong>%s</strong><br><em>Published %s</em>', $newsitem->title, Carbon::parse($newsitem->published_at)->diffForHumans())
                            ])

                        @endforeach

                    @else

                        <p>There is no news...</p>

                    @endif

                    <a href="{{ route("news::list") }}" class="btn btn-info btn-block">View older news</a>
                </div>
            </div>

        </div>

        <div class="col-xl-4 col-md-12">

            @include('website.layouts.macros.upcomingevents', ['n' => 5])

        </div>

        <div class="col-xl-4 col-md-12">

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">Birthdays</div>
                <div class="card-body">

                    @if (count($birthdays) > 0)

                        @foreach($birthdays as $key => $user)

                            <div class="member ellipsis">
                                <div class="member-picture"
                                     style="background-image:url('{!! $user->generatePhotoPath(100, 100) !!}');">
                                </div>
                                <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">{{ $user->name }}</a>
                            </div>

                        @endforeach

                    @endif

                </div>
            </div>

        </div>

    </div>

@endsection
