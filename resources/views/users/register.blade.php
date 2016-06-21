@extends('website.layouts.panel')

@section('page-title')
    New Account Registration
@endsection

@section('panel-title')
    Registering a new account
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::register') }}">

        <p>
            Using this form you can register a new account on the S.A. Proto website. You can use this account to buy
            tickets for public Proto events and to do certain other stuff.
        </p>

        <p style="font-weight: bold;">
            Creating and having an account on the website does not make you a member of S.A. Proto and is free of
            charge.
        </p>

        <hr>

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="email" class="control-label">Your e-mail address:</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="j.doe@student.utwente.nl"
                   required>
            <p class="help-block">
                Your e-mail address will also be your username. Please enter a valid e-mail address as your password
                will be sent to this e-mail address. You can configure authentication with your University of Twente
                credentials later.
            </p>
        </div>

        <hr>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label for="name_first" class="control-label">First name</label>
                    <input type="text" class="form-control" id="name_first" name="name_first" placeholder="John"
                           required>
                </div>
                <div class="col-md-5">
                    <label for="name_last" class="control-label">Last name</label>
                    <input type="text" class="form-control" id="name_last" name="name_last" placeholder="Doe" required>
                </div>
                <div class="col-md-2">
                    <label for="name_initials" class="control-label">Initials</label>
                    <input type="text" class="form-control" id="name_initials" name="name_initials" placeholder="J."
                           required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label for="birthdate" class="control-label">Birthdate</label>
                    <input type="text" class="form-control datetime-picker" id="birthdate" name="birthdate"
                           placeholder="2011-04-20" required>
                </div>
                <div class="col-md-5">
                    <label for="gender" class="control-label">Biological gender</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="9">More complicated</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label for="nationality" class="control-label">Nationality</label>
                    <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Dutch"
                           required>
                </div>
                <div class="col-md-5">
                    <label for="phone" class="control-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+31534894423" required>
                </div>
            </div>
        </div>

        <hr>

        {!! Recaptcha::render() !!}

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success pull-right">COMPLETE REGISTRATION</button>

    </form>
@endsection

@section('javascript')

    @parent

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

@endsection