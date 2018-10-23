@extends('website.home.shared')

@section('greeting')

    <strong>Hi, {{ Auth::user()->calling_name }}</strong><br>
    @if($message != null) {{ $message->message }} @else Nice to see you back! @endif

@endsection

@section('left-column')

    <div class="row justify-content-center">

        <div class="col-xl-4 col-md-12">

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">News</div>
                <div class="card-body">

                    @if(count($newsitems) > 0)


                        @foreach($newsitems as $index => $newsitem)

                            @include('website.layouts.macros.card-bg-image', [
                            'url' => $newsitem->url(),
                            'img' => $newsitem->featuredImage ? $newsitem->featuredImage->generateImagePath(300,200) : null,
                            'html' => sprintf('<strong>%s</strong><br><em>Published %s</em>', $newsitem->title, Carbon::parse($newsitem->published_at)->diffForHumans()),
                            'leftborder' => 'info'
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

        @if (count($birthdays) > 0)

            <div class="col-xl-4 col-md-12">

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">Birthdays</div>
                    <div class="card-body">

                        @foreach($birthdays as $key => $user)

                            @include('users.includes.usercard', [
                                'user' => $user,
                                'subtitle' => '<em>has their birthday today! <i class="fas fa-birthday-cake"></i></em>'
                            ])

                        @endforeach

                    </div>
                </div>

            </div>

        @endif

    </div>

@endsection
