@extends('website.layouts.panel')

@section('page-title')
    Withdrawal Administration
@endsection

@section('panel-title')
    Generate new withdrawal
@endsection

@section('panel-body')

    <form method="post" action="{{ route("omnomcom::withdrawal::add") }}">

        {!! csrf_field() !!}

        <p style="text-align: center;">
            There are currently <strong>{{ WithdrawalController::openOrderlinesTotal() }}</strong> unpaid orderlines for
            a grand total of
            <strong>&euro;{{ number_format(WithdrawalController::openOrderlinesSum(), 2, ',', '.') }}</strong>.
        </p>

        <hr>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label for="date">Withdrawal date:</label>
                    <input type="text" class="form-control datetime-picker" id="date" name="date"
                           placeholder="Can be changed later" required>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="name">Maximum amount per user:</label>
                    <div class="input-group">
                        <span class="input-group-addon">&euro;</span>
                        <input type="number" min="0" class="form-control" id="max" name="max">
                        <span class="input-group-addon">,<sup>00</sup></span>
                    </div>
                </div>

            </div>

        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("omnomcom::withdrawal::list") }}" class="btn btn-default pull-right">Cancel</a>

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