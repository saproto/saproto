<form class="form-horizontal" method="post" action="{{ route("user::dashboard") }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Your account
        </div>

        <div class="card-body">

            <table class="table table-borderless table-sm mb-0">

                <tbody>

                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }} ({{{ $user->calling_name }}})</td>
                </tr>

                <tr>
                    <th>E-mail</th>
                    <td>
                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                               value="{{ $user->email }}" required>
                    </td>
                </tr>

                @if($user->did_study_create || $user->did_study_itech)
                    <tr>
                        <th>Studies attended</th>
                        <td>
                        <span class="badge badge-pill badge-{{ $user->did_study_create ? 'primary' : 'dark' }} text-white"
                              data-toggle="tooltip" data-placement="bottom"
                              title="Is this incorrect? Let the board know.">
                            <i class="fas fa-{{ $user->did_study_create ? 'check-' : null }}square fa-fw"></i>
                            Creative Technology
                        </span>
                            <span class="badge badge-pill badge-{{ $user->did_study_itech ? 'primary' : 'dark' }} text-white"
                                  data-toggle="tooltip" data-placement="bottom"
                                  title="Is this incorrect? Let the board know.">
                            <i class="fas fa-{{ $user->did_study_itech ? 'check-' : null }}square fa-fw"></i>
                            Interaction Technology
                        </span>
                        </td>
                    </tr>
                @endif

                @if($user->birthdate)
                    <tr>
                        <th>Birthdate</th>
                        <td>
                            {{ date('F j, Y', strtotime($user->birthdate)) }}
                            @if($user->member)
                                <div class="form-group form-check">
                                    <input name="show_birthday" type="checkbox" class="form-check-input"
                                           id="dashboard__check__birthdate" {{ ($user->show_birthday == 1 ? 'checked' : '') }}>
                                    <label class="form-check-label" for="dashboard__check__birthdate">Show to
                                        members</label>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endif

                <tr>
                    <th>University account</th>
                    <td>
                        @if ($user->edu_username)
                            {{ $user->utwente_username ? $user->utwente_username : $user->edu_username }}
                            <a class="badge badge-pill badge-danger float-right"
                               href="{{ route('user::edu::delete') }}">
                                <i class="fas fa-unlink fa-fw"></i>
                            </a>
                        @else
                            Not linked
                            <a class="badge badge-pill badge-primary float-right" href="{{ route('user::edu::add') }}">
                                <i class="fas fa-user-plus fa-fw"></i>
                            </a>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>
                        Address
                    </th>
                    <td>

                        @if($user->address)
                            {{ $user->address->street }} {{ $user->address->number }}
                            @if($user->member)
                                <a class="badge badge-pill badge-primary float-right"
                                   href="{{ route('user::address::edit') }}">
                                    <i class="far fa-edit fa-fw"></i>
                                </a>
                            @else
                                <a class="badge badge-pill badge-primary float-right ml-2"
                                   href="{{ route('user::address::edit') }}">
                                    <i class="far fa-edit fa-fw"></i>
                                </a>
                                <a class="badge badge-pill badge-danger float-right"
                                   href="{{ route('user::address::delete') }}">
                                    <i class="fas fa-eraser fa-fw"></i>
                                </a>
                            @endif
                            <br>
                            {{ $user->address->zipcode }} {{ $user->address->city }} ({{ $user->address->country }})
                            <br>
                            <p class="text-muted">
                                @if($user->address_visible)
                                    <i class="fas fa-user-friends fa-fw mr-2"></i> Visible to members
                                @else
                                    <i class="fas fa-user-lock fa-fw mr-2"></i> Visible to the board
                                @endif
                                <a class="badge badge-pill badge-primary float-right"
                                   href="{{ route('user::address::togglehidden') }}">
                                    @if($user->address_visible)
                                        Hide from members.
                                    @else
                                        Make visible to members.
                                    @endif
                                </a>
                            </p>
                        @else
                            <a href="{{ route('user::address::add') }}">
                                Let us know your address
                            </a>
                        @endif

                    </td>
                </tr>

                @if($user->phone)
                    <tr>
                        <th>Phone</th>
                        <td>

                            <input type="phone" class="mb-1 form-control form-control-sm" id="phone" name="phone"
                                   value="{{ $user->phone }}">
                            <div class="form-group form-check">
                                <input name="show_birthday" type="checkbox" class="form-check-input"
                                       id="dashboard__check__phoneshow" {{ ($user->phone_visible == 1 ? 'checked' : '') }}>
                                <label class="form-check-label" for="dashboard__check__phoneshow">Show to
                                    members</label>
                                <br>
                                <input name="show_birthday" type="checkbox" class="form-check-input"
                                       id="dashboard__check__phonesms" {{ ($user->receive_sms == 1 ? 'checked' : '') }}>
                                <label class="form-check-label" for="dashboard__check__phonesms">Receive
                                    messages</label>
                            </div>

                        </td>
                    </tr>
                @endif

                <tr>
                    <th>Homepage</th>
                    <td>
                        <input type="text" class="form-control form-control-sm" id="website" name="website"
                               value="{{ $user->website }}">
                    </td>
                </tr>


                @if($user->member)

                    <tr>
                        <th>OmNomCom</th>
                        <td>

                            <div class="form-group form-check">
                                <input name="show_omnomcom_total" type="checkbox" class="form-check-input"
                                       id="dashboard__check__omnomtot" {{ ($user->show_omnomcom_total == 1 ? 'checked' : '') }}>
                                <label class="form-check-label" for="dashboard__check__omnomtot">After checkout, show
                                    how much I've spent today.</label>
                            </div>

                        </td>
                    </tr>

                @endif

                </tbody>
            </table>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-outline-info btn-block">
                Update account
            </button>

            @if($user->hasCompletedProfile() && !$user->member)
                <a href="{{ route('user::memberprofile::clear') }}" class="btn btn-outline-danger btn-block mt-3">
                    Clear information required only for members
                </a>
            @endif

            @if(!$user->hasCompletedProfile())
                <a href="{{ route('user::memberprofile::complete') }}" class="btn btn-outline-info btn-block mt-3">
                    Complete profile for membership
                </a>
            @endif

        </div>

    </div>

</form>