@extends('website.layouts.panel')

@section('page-title')
    Link UT Account
@endsection

@section('panel-title')
    Link University of Twente account for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route('user::edu::add', ['id'=> $user->id]) }}" class="form-horizontal">

        {!! csrf_field() !!}

        <p>
            Using this form you can link a University of Twente (UTwente) account to your Proto account. By doing so can
            log-in to your Proto account using your UTwente credentials and we can use your UTwente account to link
            additional information to your Proto account. Your UTwente username is your student-, employee- or external
            number you use to log-in to - among other things - eduroam, Osiris and BlackBoard.
        </p>

        <p>
            <strong>Important!</strong> We only use your UTwente password once to verify with the official University of
            Twente authentication service that you are indeed the owner of the UTwente account. Your UTwente password is
            not stored and will be inaccessible by S.A. Proto at all times.
        </p>

        <hr>

        <div class="form-group">
            <label for="start" class="col-sm-2 control-label">Username</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
        </div>

        <div class="form-group">
            <label for="end" class="col-sm-2 control-label">Password</label>

            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="Link">
                <a href="{{ route('user::dashboard') }}" class="btn btn-default">Cancel</a>
            </div>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fas fa-clock-o",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
            },
            format: 'DD-MM-YYYY'
        });
    </script>

@endsection