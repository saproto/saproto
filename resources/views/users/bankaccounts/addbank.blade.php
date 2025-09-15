@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $new ? 'Add' : 'Update' }} a withdrawal authorization for
    {{ $user->name }}
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form
                method="POST"
                id="iban-form"
                action="{{ $new ? route('user::bank::store', ['id' => $user->id]) : route('user::bank::update', ['id' => $user->id]) }}"
            >
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">
                        @if (Session::get('wizard'))
                            @include('users.registerwizard_macro')
                        @endif

                        @if ($user->id != Auth::id())
                            <p>
                                Sorry, but due to accountability issues you can
                                only add authorizations for yourself. If
                                {{ $user->name }} really wants to pay via
                                automatic withdrawal, they should authorize so
                                themselves.
                            </p>
                        @else
                            @if (! $new)
                                <div class="card mb-3">
                                    <div class="card-header bg-dark text-white">
                                        <strong>
                                            Your current authorization
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text text-center">
                                            <strong>
                                                {{ iban_to_human_format($user->bank->iban) }}
                                            </strong>
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ iban_to_human_format($user->bank->bic) }}
                                        </p>

                                        <p class="card-text text-center">
                                            <sub>
                                                authorization issued on
                                                {{ $user->bank->created_at }}.
                                                <br />
                                                Authorization ID:
                                                {{ $user->bank->machtigingid }}
                                            </sub>
                                        </p>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div
                                        class="card-header bg-danger text-white"
                                    >
                                        <strong>Attention</strong>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                            You already have a bank
                                            authorization active. Updating your
                                            authorization will remove this
                                            authorization from the system. If an
                                            automatic withdrawal is already
                                            being processed right now, it may
                                            still be withdrawn using this
                                            authorization.
                                        </p>
                                    </div>
                                </div>

                                <hr />
                            @endif

                            @csrf
                            <div class="form-group">
                                <label for="iban">
                                    IBAN Bank Account Number
                                </label>
                                <input
                                    type="text"
                                    class="form-control text-uppercase"
                                    id="iban"
                                    name="iban"
                                    placeholder="NL42INGB0013371337"
                                />
                            </div>

                            <p>
                                <span id="iban-message">
                                    Please enter your IBAN above.
                                </span>
                            </p>

                            <hr />

                            <div class="form-group">
                                <label for="bic">Bank BIC Code</label>
                                <input
                                    type="text"
                                    class="form-control text-uppercase"
                                    id="bic"
                                    name="bic"
                                    placeholder=""
                                />
                            </div>

                            <!-- <p>
                                <span id="bic-message">Enter your IBAN first.</span>
                             -->

                            <hr />

                            <p>
                                <strong>Authorization Statement</strong>
                            </p>

                            <p>
                                You hereby legally authorize Study Association
                                Proto until further notice to charge to your
                                bank account any costs you incur with the
                                association. These include but are not limited
                                to:
                            </p>

                            <ul>
                                <li>Orders from the OmNomCom store</li>
                                <li>Participation in activities</li>
                                <li>
                                    Other Proto related activities and products
                                    such as merchandise and printing
                                </li>
                                <li>Your membership fee</li>
                            </ul>

                            <p>
                                (Some of these may only applicable to members of
                                the association.)
                            </p>
                        @endif
                    </div>

                    <div class="card-footer">
                        <button
                            type="button"
                            id="iban-submit"
                            class="btn btn-success float-end"
                            disabled
                        >
                            I have read the authorization statement and agree
                            with it.
                        </button>

                        <a
                            href="{{ route('user::dashboard::show') }}"
                            class="btn btn-default"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('javascript')
    <script
        type="text/javascript"
        src="https://unpkg.com/iban-to-bic@latest/dist/iban-to-bic.js"
    ></script>
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        window.addEventListener('load', () => {
            const iban = document.getElementById('iban')
            const bic_field = document.getElementById('bic')

            iban.addEventListener('keyup', () => {
                iban.value = iban.value.replace(' ', '')
                if (iban.value.length >= 15) {
                    let bic = window.ibanToBic.ibanToBic(iban.value)
                    if (bic) {
                        bic_field.value = bic
                    }
                }
            })
        })
    </script>
@endpush
