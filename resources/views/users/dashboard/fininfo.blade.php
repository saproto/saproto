<div class="panel panel-default">
    <div class="panel-heading"><strong>Your financial details</strong></div>
    <div class="panel-body">

        <!-- Authorization information //-->

        @if($user->bank != null)

            <p style="text-align: center">
                <strong>{{ iban_to_human_format($user->bank->iban) }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ iban_to_human_format($user->bank->bic) }}
                <br>
            </p>

            <p style="text-align: center">
                <sub>
                    {{ ($user->bank->is_first ? "First time" : "Recurring") }}
                    authorization issued on {{ $user->bank->created_at }}.<br>
                    Authorization ID: {{ $user->bank->machtigingid }}
                </sub>
            </p>

        @else

            <p style="text-align: center; font-style: italic;">
                There is currently no active authorization.
            </p>

        @endif

    </div>

    <div class="panel-footer">

        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">

                @if(!$user->bank)

                    <a type="submit" class="btn btn-success"
                       href="{{ route("user::bank::add") }}">
                        Authorize for automatic withdrawal
                    </a>

                @else

                    @if(!$user->member)

                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                data-target="#bank-modal-cancel">
                            Cancel authorization
                        </button>

                    @else

                        <a type="submit" class="btn btn-success"
                           href="{{ route("user::bank::edit") }}">
                            Update your bank authorization
                        </a>

                    @endif

                @endif

            </div>
        </div>

    </div>

</div>