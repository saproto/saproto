@extends('website.default.panel')

@section('page-title')
    Bank authorization for {{ $user->name }}
@endsection

@section('panel-title')
    Add a withdrawal authorization for {{ $user->name }}
@endsection

@section('panel-body')

    @if($user->id != Auth::id())

        <p>
            Sorry, but due to accountability issues you can only add authorizations for yourself.
            If {{ $user->name }} really wants to pay via automatic withdrawal, they should configure
            so
            themselves.
        </p>

    @else

        <form method="POST" action="{{ route('user::bank::add', ['id' => $user->id]) }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="iban">Account IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban"
                       placeholder="NL42INGB0013371337">
            </div>
            <div class="form-group">
                <label for="bic">Account BIC</label>
                <input type="text" class="form-control" id="bic" name="bic" placeholder="INGBNL2A">
            </div>

            <p>

                <strong>Important stuff</strong>

            </p>

            <p>

                << Insert all kinds of important stuff. >>

            </p>

            <hr>

            <button type="submit" class="btn btn-success"
                    @if($user->id != Auth::id())
                    disabled
                    @endif
            >
                I have read all the important stuff and agree with it.
            </button>

            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                Cancel
            </button>
        </form>

    @endif

@endsection
