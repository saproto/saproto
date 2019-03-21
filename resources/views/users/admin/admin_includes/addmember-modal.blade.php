<div class="modal fade" id="addMembership" tabindex="-1" role="dialog" aria-labelledby="addMembershipLabel">
    <div class="modal-dialog" role="document">
        <form action="{{ route("user::member::add", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Make member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul>
                        @if($user->utwente_username == null)
                            <li style="color: red;">
                                <strong>
                                    {{ $user->calling_name }} has no University of Twente account linked to their user
                                    account. Please kindly ask the user to - if they are a student - link their UTwente
                                    account!
                                </strong>
                            </li>
                        @endif

                        @if (!$user->hasCompletedProfile())
                            <li style="color: red;">
                                <strong>
                                    {{ $user->calling_name }} has not yet completed their membership profile. Please ask
                                    them to complete their membership profile before making them a member.
                                </strong>
                            </li>
                        @endif
                        @if (!$user->address)
                            <li style="color: red;">
                                <strong>
                                    {{ $user->calling_name }} does not have an address linked to their account. Please
                                    ask them to register an address before making them a member.
                                </strong>
                            </li>
                        @endif
                        @if (!$user->bank)
                            <li style="color: red;">
                                <strong>
                                    {{ $user->calling_name }} does not have a current bank authorization. This is
                                    required for membership. Please ask them to enter a bank authorization before making
                                    them a member.
                                </strong>
                            </li>
                        @endif
                    </ul>

                    <p>You are about to make {{ $user->name }} a member.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    @if ($user->address && $user->bank && $user->hasCompletedProfile())
                        <button type="submit" class="btn btn-success"
                                onClick="return confirm('Did this user sign the membership form?')">Make member
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>