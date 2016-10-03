<div class="panel panel-default">

    <div class="panel-heading"><strong>Delete your account</strong></div>

    <div class="panel-body">
        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">

                <a type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal-user-delete">
                    Deactivate Account
                </a>

            </div>
        </div>
    </div>

    <div class="panel-footer">

    </div>

</div>

<!-- Modal for deleting automatic withdrawal. //-->
<div id="modal-user-delete" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Closing account for {{ $user->name }}.</h4>
            </div>
            <div class="modal-body">

                <p>
                    <strong>Warning! Read the following carefully before continuing.</strong>
                </p>

                <p>
                    You are about to deactivate your account. Every user of this website that doesn't have an active
                    membership can deactivate their account. By deactivating your account, your account will be marked
                    as deleted in the database and all data associated with your account will be deleted. The following
                    data associated with your account will NOT be deleted:
                </p>

                <ul>
                    <li>
                        Your name and e-mail address.<br>
                        (As stated in the Rules and Regulations, article 28 sub 3.)
                    </li>
                    <li>
                        Your committee participation, if any.<bR>
                        (As stated in the Rules and Regulations, article 28 sub 3.)
                    </li>
                    <li>
                        Your purchases (OmNomCom history) and activity participation, if any.<br>
                        (As required for the financial administration.)
                    </li>
                </ul>

                <p>
                    Closing your account means that your account cannot be accessed anymore. If you participated in a
                    committee, this may still show up on the committee page to registered members.
                </p>

            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('user::delete', ['id' => $user->id]) }}">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Keep my account.
                    </button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you REALLY sure?');">
                        YES! Delete my account!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>