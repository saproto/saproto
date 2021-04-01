@extends('website.home.shared')

@section('greeting')

    <strong>Hi, {{ Auth::user()->calling_name }}</strong><br>
    @if($message != null) {{ $message->message }} @else Nice to see you back! @endif

@endsection

@section('left-column')

    <div class="row justify-content-center">

        <div class="col-xl-4 col-md-12">

            @include('website.layouts.macros.upcomingevents', ['n' => 6])

        </div>

        <div class="col-xl-4 col-md-12">

            @if($dinnerform)

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white"><i class="fas fa-utensils fa-fw mr-2"></i> Dinner Form</div>
                    <div class="card-body">

                        @include('dinnerform.dinnerform_block', ['dinnerform'=> $dinnerform])

                    </div>

                </div>

            @endif

            @if (count($birthdays) > 0)

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-birthday-cake fa-fw mr-2"></i> Birthdays
                    </div>
                    <div class="card-body">

                        @foreach($birthdays as $key => $user)

                            @php($emojies = ['🎉', '🎈', '🎂', '🎊'])

                            @include('users.includes.usercard', [
                                'user' => $user,
                                'subtitle' => sprintf('<em>has their birthday today!</em> %s',
                                $emojies[array_rand($emojies)])
                            ])

                        @endforeach

                    </div>
                </div>

            @endif

            <div class="card mb-3">
                <div class="card-header bg-dark text-white"><i class="fas fa-newspaper fa-fw mr-2"></i> News</div>
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

                        <p class="card-text text-center mt-2 mb-4">
                            No recent news. It's
                            <a href="https://en.wikipedia.org/wiki/Silly_season" target="_blank">cucumber time</a>. 😴
                        </p>

                    @endif

                    <a href="{{ route("news::list") }}" class="btn btn-info btn-block">View older news</a>
                </div>
            </div>

        </div>

        @if(Newsletter::showTextOnHomepage())

            <div class="col-xl-4 col-md-12">

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-bullhorn fa-fw mr-2"></i> Weekly update
                    </div>
                    <div class="card-body">
                        {!! Markdown::convertToHtml(Newsletter::text()) !!}
                    </div>
                </div>

            </div>

        @endif

    </div>

    <style>
        #cookie-monster img {
            transition: transform 500ms;
            transform: translate(-10px, 7px) rotate(20deg);
        }

        #cookie-monster:hover img {
            transform: rotate(20deg) scale(1.2);
        }
    </style>

    <a id="cookie-monster" href="https://www.proto.utwente.nl/events/x24eBQbO8PmGWPky">
        <img src="/images/omnomcom/cookiemonster_seasonal/pixels.png" alt="pixelated cookiemonster" class="fixed-bottom" width="80px">
    </a>

@endsection
