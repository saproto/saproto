@extends('website.layouts.redesign.dashboard')

@section('page-title')
    IsAlfredThere.nl
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-3">

            <form method="post" action="{{ route("minisites::isalfredthere::admin") }}">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body where_is_alfred">

                        <p>
                            @if($status->status == 'there')
                                You are there!
                            @elseif($status->status == 'away')
                                You'll be back at {{ $status->back }}.
                            @else
                                Your whereabouts are currently not known.
                            @endif
                        </p>

                        <hr>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="where_is_alfred" id="where_is_alfred_1"
                                   value="there" onchange="toggleAlfredSelectDiv()" required {{ $status->status == 'there' ? 'checked' : '' }}>
                            <label class="form-check-label" for="where_is_alfred_1">
                                I'm there!
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="where_is_alfred" id="where_is_alfred_2"
                                   value="away" onchange="toggleAlfredSelectDiv()" required  {{ $status->status == 'away' ? 'checked' : '' }}>
                            <label class="form-check-label" for="where_is_alfred_2">
                                I'll be back in a while!
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="where_is_alfred" id="where_is_alfred_3"
                                   value="unknown" onchange="toggleAlfredSelectDiv()" required {{ $status->status == 'unknown' ? 'checked' : '' }}>
                            <label class="form-check-label" for="where_is_alfred_3">
                                I'd like to reset my whereabouts!
                            </label>
                        </div>

                        <div id="alfred_date_select" style="{{ $status->status == 'away' ? '' : 'display: none;' }}">

                            <hr>

                            I'll be back around:

                            @include('website.layouts.macros.datetimepicker',[
                                'name' => 'back',
                                'format' => 'datetime',
                                'placeholder' => $status->status == 'away' ? strtotime($status->back) : strtotime('tomorrow 09:00')
                            ])

                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-end ms-3">Save!</button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        function toggleAlfredSelectDiv() {
            let status = $('.where_is_alfred input[type="radio"]:checked').val();
            if (status === 'away') {
                $("#alfred_date_select").show();
                $("#datetimepicker-back").prop('required', true);
            } else {
                $("#alfred_date_select").hide();
                $("#datetimepicker-back").prop('required', false);
            }
        }
    </script>

@endsection