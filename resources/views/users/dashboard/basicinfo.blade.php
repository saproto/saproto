<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Basic information</strong>
    </div>
    <div class="panel-body">

        <div class="form-horizontal">

            <div class="form-group">
                <label for="name" class="col-sm-5 control-label">Name</label>
                <div class="col-sm-7 control-label" style="text-align: left;">{{ $user->name }}</div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-5 control-label">Calling name</label>
                <div class="col-sm-7 control-label" style="text-align: left;">{{ $user->calling_name }}</div>
            </div>

            @if($user->did_study_create)

                <p style="text-align: center;" title="Is this incorrect? Let the board know.">
                    <sup>
                        You are studying or have studied CreaTe.
                    </sup>
                </p>

            @endif

            @if($user->hasCompletedProfile())

                <hr>

                <p style="text-align: center;"><i>Member profile:</i></p>

                @if($user->birthdate)
                    <div class="form-group">
                        <label for="birthdate" class="col-sm-5 control-label">Birthday</label>

                        <div class="col-sm-7 control-label" style="text-align: left;">
                            {{ date('F j, Y', strtotime($user->birthdate)) }}
                        </div>
                    </div>
                @endif
                
            @endif


        </div>

    </div>

    <div class="panel-footer">

        @if($user->hasCompletedProfile() && !$user->member)
            <a href="{{ route('user::memberprofile::clear') }}" class="btn btn-warning" style="width: 100%;">
                Clear my member profile
            </a>
        @endif

        @if(!$user->hasCompletedProfile())
            <a href="{{ route('user::memberprofile::complete') }}" class="btn btn-success" style="width: 100%;">
                Complete my member profile
            </a>
        @endif

    </div>

</div>



@section('javascript')

    @parent

    @if(!$user->birthdate)

        <script type="text/javascript">
            // Initializes datetimepickers for consistent options
            $('.datetime-picker').datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    next: "fa fa-chevron-right",
                    previous: "fa fa-chevron-left"
                },
                format: 'YYYY-MM-DD'
            });
        </script>

    @endif

@endsection