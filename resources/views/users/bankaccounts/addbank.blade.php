@extends('website.layouts.panel')

@section('page-title')
    Bank authorization for {{ $user->name }}
@endsection

@section('panel-title')
    {{ ($new ? 'Add' : 'Update') }} a withdrawal authorization for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="POST"
          action="{{ ($new ? route('user::bank::add', ['id' => $user->id]) : route('user::bank::edit', ['id' => $user->id])) }}">

        @if($user->id != Auth::id())

            <p>
                Sorry, but due to accountability issues you can only add authorizations for yourself.
                If {{ $user->name }} really wants to pay via automatic withdrawal, they should authorize
                so themselves.
            </p>

        @else

            @if (!$new)

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Your current authorization</strong></div>
                    <div class="panel-body">

                        <p style="text-align: center">
                            <strong>{{ iban_to_human_format($user->bank->iban) }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ iban_to_human_format($user->bank->bic) }}<br>
                        </p>

                        <p style="text-align: center">
                            <sub>
                                {{ ($user->bank->is_first ? "First time" : "Recurring") }}
                                authorization issued on {{ $user->bank->created_at }}.<br>
                                Authorization ID: {{ $user->bank->machtigingid }}
                            </sub>
                        </p>

                    </div>
                </div>

                <p>

                    <strong>Attention!</strong>

                </p>

                <p>

                    You already have a bank authorization active. Updating your authorization
                    will remove this authorization from the system. If an automatic withdrawal is already being
                    processed right now, it may still be withdrawn using this authorization.

                </p>

                <hr>

            @endif

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

                <strong>Authorization Statement</strong>

            </p>

            <p>

                You hereby legally authorize Study Association Proto until further notice to charge to your bank account
                any costs you incur with the association. These include but are not limited to:

            </p>

            <ul>
                <li>Orders from the OmNomCom store</li>
                <li>Participation in activities</li>
                <li>Other Proto related activities and products such as merchandise and printing</li>
                <li>Your membership fee</li>
            </ul>

            <p>

                (Some of these may only applicable to members of the association.)

            </p>

        @endif

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success"
                    @if($user->id != Auth::id())
                    disabled
                    @endif
            >
                I have read the authorization statement and agree with it.
            </button>

            <a href="{{ route('user::dashboard', ['id' => $user->id]) }}" type="button"
               class="btn btn-default pull-right"
               data-dismiss="modal">
                Cancel
            </a>

    </form>

@endsection
