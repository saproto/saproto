@extends('website.home.shared')

@section('greeting')

    <strong>Hi, {{ Auth::user()->calling_name }}</strong><br>
    @if($message != null) {!! $message->message !!} @else Nice to see you back! @endif

@endsection

@section('left-column')

    <div class="row justify-content-center">

        <div class="col-xl-4 col-md-12">

            @include('website.layouts.macros.upcomingevents', ['n' => 6])

        </div>

        <div class="col-xl-4 col-md-12">

            @if($dinnerform)

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white"><i class="fas fa-utensils fa-fw me-2"></i> Dinner Form</div>
                    <div class="card-body">

                        @include('dinnerform.dinnerform_block', ['dinnerform'=> $dinnerform])

                    </div>

                </div>

            @endif

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

            <div class="card mb-3">
                <div class="card-header bg-dark text-white"><i class="fas fa-newspaper fa-fw me-2"></i> News</div>
                <div class="card-body">

                    @if(count($newsitems) > 0)

                        @foreach($newsitems as $index => $newsitem)

                            @include('website.layouts.macros.card-bg-image', [
                            'url' => $newsitem->url,
                            'img' => $newsitem->featuredImage ? $newsitem->featuredImage->getSmallUrl() : null,
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

        @if(Proto\Models\Newsletter::showTextOnHomepage())

            <div class="col-xl-4 col-md-12">

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-bullhorn fa-fw me-2"></i> Weekly update
                    </div>
                    <div class="card-body">
                        {!! Markdown::convertToHtml(Proto\Models\Newsletter::text()) !!}
                    </div>
                </div>

            </div>

        @endif

    </div>

@endsection

@section('right-column')

    @php($leaderboard = Proto\Models\Leaderboard::where('featured', true)->first())

    @if($leaderboard)

        <div class="card mb-3">

            <div class="card-header bg-dark" data-bs-toggle="collapse"
                 data-bs-target="#collapse-leaderboard-{{ $leaderboard->id }}">
                <i class="fa {{ $leaderboard->icon }}"></i> {{ $leaderboard->name }} Leaderboard
            </div>

            @if(count($leaderboard->entries) > 0)
                <table class="table table-sm mb-0">
                    @foreach($leaderboard->entries()->orderBy('points', 'DESC')->limit(5)->get() as $entry)
                        <tr>
                            <td class="ps-3 place-{{ $loop->index+1 }}" style="max-width: 50px">
                                <i class="fas fa-sm fa-fw {{ $loop->index == 0 ? 'fa-crown' : 'fa-hashtag' }}"></i>
                                {{ $loop->index+1 }}
                            </td>
                            <td>{{ $entry->user->name }}</td>
                            <td class="pe-4"><i class="fa {{ $leaderboard->icon }}"></i> {{ $entry->points }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <hr>
                <p class="text-muted text-center pt-3">There are no entries yet.</p>
            @endif

            <div class="p-3">
                <a href="{{ route('leaderboards::index') }}" class="btn btn-info btn-block">Go to leaderboards</a>
            </div>

        </div>
    @endif

    @parent
@endsection
