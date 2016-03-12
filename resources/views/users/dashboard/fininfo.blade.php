<div class="panel panel-default">
    <div class="panel-heading"><strong>Your financial details</strong></div>
    <div class="panel-body">

        <!-- Authorization information //-->

        @if($user->bank != null)

            <div class="panel panel-default">
                <div class="panel-heading">
                    Authorization for withdrawal
                </div>
                <div class="panel-body">

                    <p style="text-align: center">
                        <strong>{{ $user->bank->iban }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bank->bic }}<br>
                    </p>

                    <p style="text-align: center">
                        <sub>
                            {{ ($user->bank->withdrawal_type == "FRST" ? "First time" : "Recurring") }}
                            authorization issued on {{ $user->bank->created_at }}.<br>
                            Authorization ID: {{ $user->bank->machtigingid }}
                        </sub>
                    </p>

                    <div class="clear-fix"></div>

                </div>

                <div class="panel-footer">
                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-danger" data-toggle="modal"
                                    data-target="#bank-modal-cancel">
                                Cancel authorization
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        @else

            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <a type="submit" class="btn btn-success"
                       href="{{ route("user::bank::add", ["id"=>$user->id]) }}">
                        Authorize for automatic withdrawal
                    </a>
                </div>
            </div>

        @endif

    </div>
</div>