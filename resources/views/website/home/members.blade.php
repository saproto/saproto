@extends('website.home.shared')

@section('greeting')

    <h1>
        <strong>Hi, {{ Auth::user()->name_first }}</strong>
    </h1>
    <h3>
        Nice to see you back!
    </h3>

@endsection

@section('visitor-specific')

    <div class="col-md-8">

        @if($message != null)

        <div class="panel panel-default">

            <div class="panel-body" style="padding: 30px;">

                <h3>{{ $message->message }}</h3>

            </div>

        </div>

        @endif

        <div class="panel panel-default">

            <div class="panel-body" style="padding: 30px;">

                <p>
                    Welcome to the new Proto website. You should find most of what you had on the old website around
                    here somewhere, and the final missing features are coming soon. Should you miss something, do let us
                    know!
                </p>

            </div>

        </div>

    </div>

@endsection