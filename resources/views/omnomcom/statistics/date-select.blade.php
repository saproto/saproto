@extends('website.layouts.redesign.dashboard')

@section('page-title')
    OmNomCom statistics
@endsection

@section('container')

    <div class="row justify-content-center mb-3">

        <div class="col-md-3">

            <form method="post" action="{{ route("omnomcom::products::statistics") }}">

                {!! csrf_field() !!}

                <div class="card">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <p class="card-text">
                            Select the dates for which you want to generate OmNomCom statistics:
                        </p>

                        <hr>

                        <label for="date">Start date:</label>
                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'start',
                            'format' => 'datetime'
                        ])

                        <label for="name">End date:</label>
                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'end',
                            'format' => 'datetime'
                        ])

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection