@if($user->bank != null)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            SEPA direct withdrawal
        </div>

        <div class="card-body">

            <p class="card-text text-center">
                You have issued us an authorisation for:<br>
                <strong class="mr-5">{{ iban_to_human_format($user->bank->iban) }}</strong>{{ iban_to_human_format($user->bank->bic) }}
            </p>

            <table class="table table-borderless table-sm text-muted mb-0">
                <tbody>
                <tr>
                    <th>Type</th>
                    <td>{{ ($user->bank->is_first ? "New" : "Recurring") }}</td>
                </tr>
                <tr>
                    <th>Issued on</th>
                    <td>{{ $user->bank->created_at }}</td>
                </tr>
                <tr>
                    <th>Authorisation reference</th>
                    <td>{{ $user->bank->machtigingid }}</td>
                </tr>
                <tr>
                    <th>Creditor identifier</th>
                    <td>{{ config('proto.sepa_info')->creditor_id }}</td>
                </tr>
                </tbody>
            </table>

        </div>

        <div class="card-footer">

            <div class="btn-group btn-block" role="group" >

                @if(!$user->member)

                    <a class="btn btn-outline-danger btn-block" data-toggle="modal"
                            data-target="#bank-modal-cancel">
                        Cancel authorization
                    </a>

                @endif

                <a class="btn btn-outline-primary btn-block" href="{{ route("user::bank::edit") }}">
                    Update authorization
                </a>

            </div>

        </div>

    </div>

@else

    <a type="submit" class="btn btn-outline-primary btn-block" href="{{ route("user::bank::add") }}">
        Issue SEPA direct withdrawal authorisation
    </a>

@endif

@if($user->bank != null)
    <div id="bank-modal-cancel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancel withdrawal authorization</h4>
                </div>
                <div class="modal-body">

                    @if($user->hasUnpaidOrderlines())
                        <p style="color: red;">
                            You have unpaid orderlines. You cannot revoke your authorization until you have settled all
                            your
                            purhcases with Proto. You can await the next withdrawal, or head over to your
                            <a href="{{ route("omnomcom::orders::list") }}">purchase history</a> to pay manually via
                            iDeal.
                        </p>
                        <hr>
                    @endif

                    <p>
                        This action will cancel your current automatic withdrawal authorization. Everything bought
                        up until now will still be withdrawn from this bank account, but no more purchases can be
                        made using this authorization.
                    </p>

                    <p>
                        After all outstanding balance with this authorization has been paid, the authorization will
                        be permanently deleted. If you wish to make purchases in the future, you can always add a
                        new authorization.
                    </p>

                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('user::bank::delete') }}">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Keep my authorization active
                        </button>
                        <button type="submit"
                                class="btn btn-danger" {{ $user->hasUnpaidOrderlines() ? 'disabled' : '' }}>
                            Cancel my authorization
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif