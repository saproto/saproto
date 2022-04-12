@if (!$user->is_member)

    <button type="submit" class="btn btn-outline-danger btn-block mb-3" data-toggle="modal" data-target="#modal-user-delete">
        Close your Proto account
    </button>

    <!-- Modal for deleting automatic withdrawal. //-->
    <div id="modal-user-delete" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog">

            <form method="POST" action="{{ route('user::delete') }}">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Close account for {{ $user->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <p>
                            <strong>Warning! Read the following carefully before continuing.</strong>
                        </p>

                        <p>
                            You are about to close your account. Every user of this website that doesn't have an active
                            membership can close their account. By closing your account, your account will be marked as
                            deleted in the database and all data associated with your account will be deleted. The following
                            data associated with your account will however NOT be deleted:
                        </p>

                        <ul>
                            <li>
                                Your name.<br>
                                (As stated in the Privacy Policy, section Specific Usage, for historical purposes.)
                            </li>
                            <li>
                                Your association participation (committees, activities etc.), if any.<br>
                                (As stated in the Privacy Policy, section Specific Usage, for historical purposes.)
                            </li>
                            <li>
                                Your purchases, if any.<br>
                                (As required for the financial administration.)
                            </li>
                        </ul>

                        <p>
                            Closing your account means that your account cannot be accessed anymore. If you participated in
                            a committee, this may still show up on the committee page to registered members.
                        </p>

                        <p>
                            To close your account, please confirm your current account password below.
                            (<a href="{{ route("login::resetpass") }}" target="_blank">Forgot your password?</a>)
                        </p>

                        <input class="form-control" type="password" name="password" placeholder="Your current password.">
                        <br>
                        <p>
                            <strong>Note:</strong> If you still have open payments, you <strong>cannot</strong> close your account! You will first have to pay off your expenses.
                        </p>
                    </div>

                    <div class="modal-footer">
                            {!! csrf_field() !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Keep my account.
                            </button>
                            @if(Auth::user()->hasUnpaidOrderlines())
                            <button type="submit" class="btn btn-danger">
                                Pay off my unpaid orderlines!
                            </button>
                            @else

                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you REALLY sure?');">
                                YES! Delete my account!
                            </button>
                            @endif
                    </div>

                </div>

            </form>

        </div>

    </div>

@endif