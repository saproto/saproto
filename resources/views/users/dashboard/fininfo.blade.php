<div class="panel panel-default">
    <div class="panel-heading"><strong>Your financial details</strong></div>
    <div class="panel-body">

        <!-- Authorization information //-->

        @if($user->bank != null)

            <p style="text-align: center">
                <strong>{{ $user->bank->iban }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bank->bic }}<br>
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

            @if($user->bank != null)

                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-danger" data-toggle="modal"
                            data-target="#bank-modal-cancel">
                        Cancel authorization
                    </button>
                </div>

            @else

                <a type="submit" class="btn btn-success"
                   href="{{ route("user::bank::add", ["id"=>$user->id]) }}">
                    Authorize for automatic withdrawal
                </a>

            @endif

        </div>
    </div>

</div>