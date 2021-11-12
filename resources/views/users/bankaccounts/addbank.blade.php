@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ ($new ? 'Add' : 'Update') }} a withdrawal authorization for {{ $user->name }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="POST" id="iban__form"
                  action="{{ ($new ? route('user::bank::add', ['id' => $user->id]) : route('user::bank::edit', ['id' => $user->id])) }}">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        @if(Session::get('wizard'))
                            @include('users.registerwizard_macro')
                        @endif

                        @if($user->id != Auth::id())

                            <p>
                                Sorry, but due to accountability issues you can only add authorizations for yourself.
                                If {{ $user->name }} really wants to pay via automatic withdrawal, they should authorize
                                so themselves.
                            </p>

                        @else

                            @if (!$new)

                                <div class="card mb-3">

                                    <div class="card-header bg-dark text-white">
                                        <strong>Your current authorization</strong>
                                    </div>

                                    <div class="card-body">

                                        <p class="card-text text-center">
                                            <strong>{{ iban_to_human_format($user->bank->iban) }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ iban_to_human_format($user->bank->bic) }}
                                        </p>

                                        <p class="card-text text-center">
                                            <sub>
                                                {{ ($user->bank->is_first ? "First time" : "Recurring") }}
                                                authorization issued on {{ $user->bank->created_at }}.<br>
                                                Authorization ID: {{ $user->bank->machtigingid }}
                                            </sub>
                                        </p>

                                    </div>

                                </div>

                                <div class="card mb-3">

                                    <div class="card-header bg-danger text-white">
                                        <strong>Attention</strong>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                            You already have a bank authorization active. Updating your authorization
                                            will remove this authorization from the system. If an automatic withdrawal
                                            is already being processed right now, it may still be withdrawn using this
                                            authorization.
                                        </p>
                                    </div>

                                </div>

                                <hr>

                            @endif

                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="iban">IBAN Bank Account Number</label>
                                <input type="text" class="form-control" id="iban" name="iban"
                                       placeholder="NL42INGB0013371337" style="text-transform: uppercase;">
                            </div>

                            <p>
                                <span id="iban__message">Please enter your IBAN above.</span>
                            </p>

                            <hr>

                            <div class="form-group">
                                <label for="bic">Bank BIC Code</label>
                                <input type="text" class="form-control" id="bic" name="bic" placeholder="" disabled
                                       style="text-transform: uppercase;">
                            </div>

                            <p>
                                <span id="bic__message">Enter your IBAN first.</span>
                            </p>

                            <hr>

                            <p>

                                <strong>Authorization Statement</strong>

                            </p>

                            <p>

                                You hereby legally authorize Study Association Proto until further notice to charge to
                                your bank account
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

                    </div>

                    <div class="card-footer">

                        <button type="button" id="iban__submit" class="btn btn-success float-end" disabled>
                            I have read the authorization statement and agree with it.
                        </button>

                        <a href="{{ route('user::dashboard') }}" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        $('body').on('keyup', '#iban', function () {

            $("#iban").val($("#iban").val().replace(' ', ''));

            if ($("#iban").val().length >= 15) {

                $.ajax({
                    url: '{{ route('api::verify_iban') }}',
                    data: {
                        'iban': $('#iban').val()
                    },
                    method: 'get',
                    dataType: 'json',
                    success: function (data) {
                        update_iban_form(data)
                    },
                    error: function () {
                        iban_message('black', "We could not automatically verify your IBAN.");
                        bic_message('red', 'Please enter your BIC.');
                        $("#bic").val('');
                        $("#bic").prop('disabled', false);
                    }
                });

            } else {
                iban_message('black', "Please enter your IBAN above.");
                bic_message('black', 'Enter your IBAN first.');
                $("#bic").prop('disabled', true);
                $("#bic").val('');
                $("#iban__submit").prop('disabled', true);
            }

        });

        $('body').on('keyup', '#bic', function () {

            if ($("#bic").val().length >= 8) {
                $("#iban__submit").prop('disabled', false);
            } else {
                $("#iban__submit").prop('disabled', true);
            }

        });

        $('body').on('click', '#iban__submit', function () {

            $("#iban__submit").prop('disabled', true);

            if ($("#bic").val().length >= 8) {

                $.ajax({
                    url: '{{ route('api::verify_iban') }}',
                    data: {
                        'iban': $('#iban').val(),
                        'bic': $('#bic').val()
                    },
                    method: 'get',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === true) {
                            $("#bic").prop('disabled', false);
                            $("#iban__form").submit();
                        } else {
                            update_iban_form(data)
                        }
                    },
                    error: function () {
                        $("#bic").prop('disabled', false);
                        $("#iban__form").submit();
                    }
                });

            } else {
                bic_message('red', 'Please enter your BIC.');
                $("#bic").prop('disabled', false);
            }

        });

        function iban_message(color, text) {
            $("#iban__message").css('color', color).html(text);
        }

        function bic_message(color, text) {
            $("#bic__message").css('color', color).html(text);
        }

        function update_iban_form(data) {
            if (data.status === false) {
                iban_message('red', data.message)
                bic_message('red', data.message);
                $("#bic").val('');
                $("#iban__submit").prop('disabled', true);
            } else if (data.bic !== "") {
                iban_message('green', "Your IBAN is valid!");
                bic_message('green', 'We found your BIC for you!');
                $("#bic").val(data.bic);
                $("#iban").val(data.iban);
                $("#bic").prop('disabled', true);
                $("#iban__submit").prop('disabled', false);
            } else {
                iban_message('green', "Your IBAN is valid!");
                bic_message('red', 'We could not find your BIC. Please enter your it manually.');
                $("#iban").val(data.iban);
                $("#bic").val('');
                $("#bic").prop('disabled', false);
            }
        }

    </script>

@endpush