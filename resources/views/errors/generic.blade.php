@extends('website.layouts.default')

@section('page-title')
    Houston, we have a problem.
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">

            <h3>
                Hey {{ (Auth::check() ? Auth::user()->calling_name : 'there') }}!
            </h3>

            <p>
                We're very sorry, but something went wrong while we tried to do what you requested. Don't
                worry, this happens sometimes! This is the generated error message: <code>{{ $message }}</code>
            </p>

            <p>
                @if($reported)
                    <strong>The problem has been recorded and the developers have been notified.</strong> We think the
                    problem has to do with the website itself, so trying to repeat whatever you did that got you this
                    page probably won't solve anything. The best thing you can do is wait for the problem to be
                    resolved. If you're still looking to ask somebody what the heck just went wrong, you can always
                    contact the <a href="{{ route('developers') }}">developers</a> of this website.
                @elseif($statuscode == 404)
                    It appears you have been trying to access a page and/or database entry that did not exist. If you
                    typed in the URL manually chances are you made a mistake. If you were redirected here from another
                    website, the website you came from is probably outdated. If the latter is the case, please do notify
                    the owner of that website of the issue. If you see this page while navigation this website, please
                    try to do again whatever you did that got you here. <strong>If the problem persists, please notify
                        the <a href="{{ route('developers') }}">developers</a> of this website and tell them what went
                        wrong.</strong>
                @elseif($statuscode == 403)
                    If looks like you did something you were not allowed to do. If this is true, stop doing this! If you
                    believe you are entitled to do whatever you tried to do, please
                    @if (!Auth::check())
                        log-in and
                    @endif
                    check on the bottom of your dashboard whether you have the right elevated authorisation to do
                    whatever you tried to do. If you're missing authorisation, please contact the <a
                            href="mailto:board@{{ config('proto.emaildomain') }}">board</a> to see if you can get access
                    to it. If you seem to have the right authorisation, please let the <a
                            href="{{ route('developers') }}">developers</a> know.
                @else
                    Something went wrong. We're not quite sure what, but for some reason <strong>the issue has not
                        been reported to the developers.</strong> Please consult the error message in red on top of this
                    page and send it to the <a href="{{ route('developers') }}">developers</a> along with a description
                    of what you were doing when this error popped up.
                @endif
            </p>

        </div>

        <div class="col-md-4" style="text-align: center;">

            <img src="{{ asset('images/application/exception.png') }}">

        </div>

    </div>

@endsection