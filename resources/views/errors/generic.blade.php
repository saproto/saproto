@extends('website.layouts.default')

@section('page-title')
    Something went horribly wrong. :(
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">

            <h3>
                Hey {{ (Auth::check() ? Auth::user()->name_first : 'there') }}!
            </h3>

            <p>
                <strong>
                    We encountered an error while trying to process your request.
                </strong>
            </p>

            <p>
                We're very sorry, but something went horribly wrong while we tried to do what you requested. Don't
                worry, this sometimes happens. We make use of an automatic error-logging system, so your issue has been
                recorded, will be investigated and usually solved. If, despite all this, you're still looking to ask
                somebody what the heck just went wrong, you can always contact the <a href="{{ route('developers') }}">webmasters</a>
                of this website.
            </p>

        </div>

        <div class="col-md-4" style="text-align: center;">

            <img src="{{ asset('images/application/exception.png') }}">

        </div>

    </div>

@endsection