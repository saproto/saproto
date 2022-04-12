<div class="card mb-3">

    <div class="card-header bg-dark text-white">Membership center for <strong>{{ $user->name }}</strong></div>

    <div class="card-body">

        <ul class="list-group mb-3">

            <li class="list-group-item list-group-item-dark">
                Membership actions
            </li>

            @if($user->is_member)
                <a href="#" class="list-group-item text-danger" data-bs-toggle="modal" data-bs-target="#removeMembership">
                    End membership
                </a>
                <a href="#" class="list-group-item text-warning" data-bs-toggle="modal" data-bs-target="#setMembershipType">
                    Change membership type
                </a>
                <a href="{{ route('membercard::download', ['id' => $user->id]) }}" target="_blank"
                   class="list-group-item">
                    Preview membership card
                </a>
                <a href="#" id="print-card" data-id="{{ $user->id }}" class="list-group-item">
                    Print membership card<br>
                    @if($user->member->card_printed_on)
                        (Last printed: {{ $user->member->card_printed_on }})
                    @else
                        (Never printed before)
                    @endif
                </a>
                <a href="#" id="print-card-overlay" data-id="{{ $user->id }}" class="list-group-item">
                    Print opener overlay
                </a>
            @else
                <li class="list-group-item">
                    Not a member
                </li>
                @if($user->address&&$user->completed_profile&&$user->signed_membership_form)
                    <li class="list-group-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Has complete profile
                    </li>
                    <a href="#" class="list-group-item text-warning" data-bs-toggle="modal" data-bs-target="#addMembership">
                        Make member
                    </a>
                @else
                    <li class="list-group-item">
                        <i class="fas fa-times-circle text-danger"></i>
                        Has not completed profile yet
                    </li>
                @endif
            @endif

        </ul>

        @if($user->is_member)
            <ul class="list-group mb-3">

                <li class="list-group-item list-group-item-dark">
                    Current Membership
                </li>
                <li class="table-responsiv list-group-item">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>Since</td>
                                <td>Type</td>
                                <td class="text-center">Form</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }}
                                </td>
                                <td>
                                    @if($user->member->is_lifelong)
                                        Lifelong <i class="fas fa-clock"></i>
                                    @elseif($user->member->is_honorary)
                                        Honorary <i class="fas fa-trophy"></i>
                                    @elseif($user->member->is_donor)
                                        Donor <i class="fas fa-hand-holding-usd"></i>
                                    @elseif($user->member->is_pet)
                                        Pet <i class="fas fa-paw"></i>
                                    @else
                                        Regular
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->member->membershipForm)
                                        <a class="ms-2" href="{{ route('memberform::download::signed', ['id' => $user->member->membership_form_id]) }}">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <i class="fa fa-file-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="No digital membership form, check the physical archive."></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>

            </ul>
        @endif

        @if($memberships['pending']->count() > 0)
            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-dark">
                    Pending Membership(s)
                </li>
                <li class="table-responsive list-group-item">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>
                                    Since
                                </td>
                                <td>
                                    Actions
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memberships['pending'] as $membership)
                                <tr>
                                    <td>
                                        {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }}
                                    </td>
                                    @if($membership->membershipForm)
                                        <td>
                                            <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="text-decoration-none">
                                                <i class="fas fa-download fa-fw me-2 text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#remove-member-form" data-memberform-id="{{ $membership->membership_form_id }}" class="text-decoration-none">
                                                <i class="fas fa-trash fa-fw me-2 text-danger" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
            </ul>
        @endif

        @if($memberships['previous']->count() > 0)
            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-dark">
                    Previous Membership(s)
                </li>
                <li class="table-responsive list-group-item">
                    <table class="w-100">
                        <thead>
                        <tr>
                            <td>
                                From
                            </td>
                            <td>
                                Until
                            </td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($memberships['previous'] as $membership)
                            <tr>
                                <td>
                                    {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($membership->deleted_at)) }}
                                </td>
                                @if($membership->membershipForm)
                                    <td>
                                        <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="text-decoration-none">
                                            <i class="fas fa-download fa-fw me-2 text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#remove-member-form data-memberform-id="{{ $membership->membership_form_id }}" class="text-decoration-none">
                                            <i class="fas fa-trash fa-fw me-2 text-danger" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </li>
            </ul>
        @endif

    </div>

</div>

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        function req(e, url) {
            get(url, { 'id': e.target.getAttribute('data-id') })
            .then(data => {
                if (data.includes('Exception')) throw data
                alert(data)
            })
            .catch(err => {
                console.error(err)
                alert("Something went wrong while requesting the print.")
            })
        }

        document.getElementById('print-card').addEventListener('click', e => {
            if (confirm('please confirm you want to print a membership card.')) {
                req(e, '{{ route('membercard::print') }}')
            }
        })

        document.getElementById('print-card-overlay').addEventListener('click', e => {
            if (confirm("Please confirm you have the right member card loaded.")) {
                req(e, '{{ route('membercard::printoverlay') }}')
            }
        })

    </script>

@endpush