@extends('website.layouts.panel')

@section('page-title')
    OmNomCom statistics
@endsection

@section('panel-title')
    Show OmNomCom statistics
@endsection

@section('panel-body')

    <form method="post" action="{{ route("omnomcom::products::statistics") }}">

        {!! csrf_field() !!}

        <p style="text-align: center;">
            Select the dates for which you want to generate OmNomCom statistics:
        </p>

        <hr>

                <div class="form-group">
                    <label for="date">Start date:</label>
                    <input type="text" class="form-control datetime-picker" id="date" name="start" required>
                </div>


                <div class="form-group">
                    <label for="name">End date:</label>
                    <input type="text" class="form-control datetime-picker" id="date" name="end" required>
                </div>


        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

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
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>

@endsection