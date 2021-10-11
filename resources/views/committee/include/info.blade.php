@if ($committee->trashed())
    <div class="alert alert-danger text-center" role="alert">
        This {{ $committee->is_society ? 'society' : 'committee' }} is archived! Members will not be able to see it.
    </div>
@elseif (!$committee->public)
    <div class="alert alert-info text-center" role="alert">
        This is a hidden {{ $committee->is_society ? 'society' : 'committee' }}!
    </div>
@endif

@if(Auth::check() && $committee->allow_anonymous_email)
    <a href="{{ route("committee::anonymousmail", ["id" => $committee->getPublicId()]) }}"
       class="btn btn-block btn-info mb-3">
        <i class="fas fa-envelope-open fa-fw"></i> Send this @if($committee->is_society) society @else committee @endif an anonymous e-mail
    </a>
@endif

<div class="card mb-3">

    @if($committee->image)
        <img class="card-img-top" src="{{ $committee->image->generateImagePath(800, 300) }}" width="100%">
    @endif

    @if(Auth::check() && ($committee->isMember(Auth::user()) || Auth::user()->can('board') || $committee->allow_anonymous_email))

        <div class="card-header bg-dark">

            <div class="row justify-content-end">

                @if($committee->isMember(Auth::user()))
                    <div class="col-8">

                        <a href="{{ route('committee::toggle_helper_reminder', ['slug'=>$committee->slug]) }}"
                           class="btn btn-block btn-{{ $committee->wantsToReceiveHelperReminder(Auth::user()) ? 'danger' : 'primary' }}">
                            <i class="fas fa-{{ $committee->wantsToReceiveHelperReminder(Auth::user()) ? 'ban' : 'check' }} fa-fw"></i>
                            {{ $committee->wantsToReceiveHelperReminder(Auth::user()) ? 'Don\'t get' : 'Get' }} helper reminders
                        </a>

                    </div>
                @endif

                @if(Auth::user()->can('board'))
                    <div class="col-4">
                        @if($committee->trashed())
                            <a href="{{ route("committee::restore", ["id" => $committee->id]) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-undo fa-fw"></i> Restore
                            </a>
                        @else
                            <a href="{{ route("committee::edit", ["id" => $committee->id]) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-edit fa-fw"></i> Edit
                            </a>
                        @endif
                    </div>
                @endif

            </div>

        </div>

    @endif

    <div class="card-body">

        <h5 class="card-title">@yield('page-title')</h5>

        <p class="card-text">

            {!! Markdown::convertToHtml($committee->description) !!}

        </p>

        <a href="mailto:{{ $committee->slug . "@" . config('proto.emaildomain') }}" class="card-link text-info">
            E-mail them at {{ $committee->slug . "@" . config('proto.emaildomain') }}
        </a>

    </div>

</div>