@extends('website.layouts.panel')

@section('page-title')
    Complete membership profile
@endsection

@section('panel-title')
    Complete membership profile
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('user::memberprofile::complete') }}">

        @include('users.registerwizard_macro')

        {!! csrf_field() !!}

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="birthdate" class="control-label">Birthdate</label>
                    <input type="text" class="form-control datetime-picker" id="birthdate" name="birthdate"
                           placeholder="2011-04-20" required>
                    <sup>Cannot be changed afterwards</sup>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="control-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+31534894423" required>
                    <sup>Can only be updated, not removed</sup>
                </div>
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-outline-primary pull-right">Complete profile</button>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "far fa-clock",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
            },
            format: 'YYYY-MM-DD'
        });
    </script>

@endsection
