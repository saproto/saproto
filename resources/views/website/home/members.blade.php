@extends('website.home.shared')

@section('greeting')

    <strong>Hi {{ Auth::user()->calling_name }},</strong><br>
    @if($message != null) {!! $message->message !!} @else Nice to see you back! @endif

@endsection

@section('left-column')

    <div class="col-xl-4 col-md-12">

        @include('website.home.cards.featuredevents', ['n' => 6])

        @include('website.home.cards.leaderboards')

        @if (count($birthdays) > 0)

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-birthday-cake fa-fw me-2"></i> Birthdays
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

    </div>

    <div class="col-xl-4 col-md-12">

        @include('website.home.cards.upcomingevents', ['n' => 6])

    </div>

    <div class="col-xl-4 col-md-12">

        @if(count($dinnerforms)>0)

            <div class="card mb-3">

                <div class="card-header bg-dark text-white"><i class="fas fa-utensils fa-fw me-2"></i> Dinnerform</div>
                <div class="card-body">
                    @foreach($dinnerforms as $dinnerform)
                        @include('dinnerform.includes.dinnerform-block', ['dinnerform'=> $dinnerform])
                    @endforeach
                </div>

            </div>

        @endif

        <div class="card mb-3">
                <div class="card-header bg-dark text-white"><i class="fas fa-newspaper fa-fw me-2"></i> News</div>
                <div class="card-body">

                    @if(count($newsitems) > 0)

                        @foreach($newsitems as $index => $newsitem)
                        <div style="max-height: 300px">
                            @include('website.home.cards.card-bg-image', [
                            'height' => $newsitem->is_weekly ? 80 : 120,
                            'url' => $newsitem->url,
                            'img' => $newsitem->featuredImage ? $newsitem->featuredImage->generateImagePath(600,300) : null,
                            'html' => sprintf('<strong>%s</strong><br><em>Published %s</em>', $newsitem->title, Carbon::parse($newsitem->published_at)->diffForHumans()),
                            'leftborder' => 'info'
                            ])
                        </div>

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


        @if(isset($videos) && count($videos) > 0)

            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fab fa-youtube fa-fw me-2"></i> Recent videos
                </div>
                <div class="card-body">

                    @foreach($videos as $video)

                        @include('videos.includes.video_block', [
                            'video' => $video,
                            'photo_pop' => false
                        ])

                    @endforeach

                </div>
            </div>

        @endif

    </div>

@endsection

@section('right-column')

    @include('website.home.cards.recentalbums', ['n' => 4])

    @parent
@endsection
