<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Basic information</strong>
    </div>
    <div class="panel-body">

        <div class="form-horizontal">

            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Name</label>

                <div class="col-sm-8 control-label" style="text-align: left;">{{ $user->name }}</div>
            </div>

            <div class="form-group">
                <label for="gender" class="col-sm-4 control-label">Bio Gender</label>

                <div class="col-sm-8 control-label" style="text-align: left;">
                    @if($user->gender == 1)
                        Male
                    @elseif($user->gender == 2)
                        Female
                    @elseif($user->gender == 0)
                        Unknown
                    @elseif($user->gender == 9)
                        Not applicable
                    @else
                        Invalid gender value
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="birthdate" class="col-sm-4 control-label">Birthday</label>

                <div class="col-sm-8 control-label"
                     style="text-align: left;">{{ date('F j, Y', strtotime($user->birthdate)) }}</div>
            </div>

            <div class="form-group">
                <label for="nationality" class="col-sm-4 control-label">Nationality</label>

                <div class="col-sm-8 control-label" style="text-align: left;">{{ $user->nationality }}</div>
            </div>

        </div>

    </div>

    <div class="panel-footer">

    </div>

</div>