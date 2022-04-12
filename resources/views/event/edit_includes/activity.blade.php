<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Sign-up details
    </div>

    @if ($event != null)

        <form method="post" action="{{ route('event::addsignup', ['id'=>$event->id]) }}">

            {!! csrf_field() !!}

            <div class="card-body">

                @if(!$event->activity)

                    <p class="card-text text-center">
                        No sign-up details are currently configured.
                    </p>

                    <hr>

                @endif

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="signup_start">Sign-up start:</label>
                            @include('website.layouts.macros.datetimepicker',[
                                'name' => 'registration_start',
                                'format' => 'datetime',
                                'placeholder' => $event->activity ? $event->activity->registration_start : null
                            ])
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="signup_end">Sign-up end:</label>
                            @include('website.layouts.macros.datetimepicker',[
                                'name' => 'registration_end',
                                'format' => 'datetime',
                                'placeholder' => $event->activity ? $event->activity->registration_end : null
                            ])
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="signout_end">Sign-out end:</label>
                            @include('website.layouts.macros.datetimepicker',[
                                'name' => 'deregistration_end',
                                'format' => 'datetime',
                                'placeholder' => $event->activity ? $event->activity->deregistration_end : null
                            ])
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label for="price">Participation cost:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">&euro;</span>
                            </div>
                            <input type="text" class="form-control" id="price" name="price"
                                   value="{{ ($event->activity ? $event->activity->price : '0') }}"
                                   placeholder="15"
                                   require>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label for="no_show_fee">
                            <i class="fas fa-question-circle mr-2" data-toggle="tooltip" data-placement="top" data-html="true"
                               title="Input only the additional no show fee."></i>
                            No show fee:
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">&euro;</span>
                            </div>
                            <input type="text" class="form-control" id="no_show_fee" name="no_show_fee"
                                   value="{{ ($event->activity ? $event->activity->no_show_fee : '0') }}"
                                   placeholder="15"
                                   required>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label for="participants">
                            <i class="fas fa-question-circle mr-2" data-toggle="tooltip" data-placement="top" data-html="true"
                               title="Use -1 for unlimited.<br>Use 0 for helpers only."></i>
                            Participant limit:
                        </label>
                        <input type="number" class="form-control" id="participants"
                               name="participants" min="-1" required
                               value="{{ ($event->activity ? $event->activity->participants : '') }}">
                    </div>

                        <div class="checkbox col-6">
                            <label>
                                <input type="checkbox" name="hide_participants"
                                        {{ ($event->activity && $event->activity->hide_participants ? 'checked' : '') }}>
                                        Hide participants.
                                        <i class="fas fa-question-circle mr-2" data-toggle="tooltip" data-placement="top" data-html="true" title="This will hide who participates in this event for members!"></i>
                            </label>
                        </div>
                    </div>
            </div>

            <div class="card-footer">

                <div class="row justify-content-center">

                    <div class="col-6">
                        <input type="submit" class="btn btn-success btn-block" value="Save sign-up details">
                    </div>

                    @if($event->activity)
                        <div class="col-6">
                            <a href="{{ route('event::deletesignup', ['id'=>$event->id]) }}"
                               class="btn btn-danger btn-block">
                                Remove sign-up
                            </a>
                        </div>
                    @endif

                </div>

            </div>

        </form>

    @else

        <div class="card-body">

            <p class="card-text text-center">
                You must save this event before being able to add sign-up details.
            </p>

        </div>

    @endif

</div>