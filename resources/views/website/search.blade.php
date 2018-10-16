@extends('website.layouts.redesign.generic')

@section('page-title')
    Search
    @if ($term != null & strlen($term) > 0)
        results for {{ $term }}
    @endif
@endsection

@section('container')

    <div class="row justify-content-center">

        @if (count($users) + count($committees) + count($pages) + count($events) == 0)

            <div class="col-md-4 col-sm-6 col-xs-10">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center">
                            Your search has returned no results.
                        </p>
                    </div>
                </div>
            </div>

        @endif

        @if (count($users) > 0)

            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        Proto members
                    </div>
                    <div class="card-body">

                        @foreach($users as $user)

                            @include('users.includes.usercard', [
                                'user' => $user['object'],
                                'subtitle' => sprintf('<em>Member since %s</em>',
                                 date('U', strtotime($user['object']->member->created_at)) > 0 ? date('F Y', strtotime($user['object']->member->created_at)) : 'forever!')
                                ])

                        @endforeach

                    </div>
                </div>

            </div>

        @endif

            @if (count($committees) > 0)

                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header">
                            Committees
                        </div>
                        <div class="card-body">

                            @foreach($committees as $committee)

                                @include('website.layouts.macros.card-bg-image', [
                                            'url' => route('committee::show', ['id' => $committee['object']->getPublicId()]),
                                            'img' => $committee['object']->image->generateImagePath(450, 300),
                                            'html' => !$committee['object']->public ? sprintf('<i class="fas fa-lock"></i>&nbsp;&nbsp;%s', $committee['object']->name) : sprintf('<strong>%s</strong>', $committee['object']->name),
                                            'height' => '120',
                                            'classes' => !$committee['object']->public ? ['committee__hidden'] : null,
                                            'photo_pop' => true
                                ])

                            @endforeach

                        </div>
                    </div>

                </div>

            @endif

            @if (count($events) > 0)

                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header">
                            Proto members
                        </div>
                        <div class="card-body">

                            @foreach($events as $event)

                                @include('event.display_includes.event_block', [
                                    'event'=> $event['object']
                                ])

                            @endforeach

                        </div>
                    </div>

                </div>

            @endif

        @if (count($pages) > 0)

            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        Pages
                    </div>
                    <div class="card-body">

                        @foreach($pages as $page)

                            @include('website.layouts.macros.card-bg-image', [
                                'url' => route("page::show", ["slug" => $page['object']->slug]),
                                'img' => $page['object']->featuredImage ? $page['object']->featuredImage->generateImagePath(300, 200) : null,
                                'photo_pop' => true,
                                'html' => $page['object']->title,
                                'height' => 100,
                                'leftborder' => 'info'
                            ])

                        @endforeach

                    </div>
                </div>

            </div>

        @endif

    </div>

@endsection
