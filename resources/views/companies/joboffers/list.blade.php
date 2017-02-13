@extends('website.layouts.default-nobg')

@section('page-title')
    Creative Technology Job offers
@endsection

@section('content')

    @if(count($companies) > 0)

    @foreach($companies as $key => $company)

        <div class="company__row">

            <div class="row">

                <div class="col-md-5 col-xs-6">

                    <div class="company__row__image">

                        <div style="{{ ($company->image ? "background-image: url(".$company->image->generateImagePath(600, null).");" : '') }}">

                        </div>

                    </div>

                </div>

                <div class="col-md-7 col-xs-6 company__row__excerpt">

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <h3>{{ $company->name }}</h3>

                            <a href="{{ route('companies::show', ['id' => $company->id]) }}">Learn more about this
                                company</a> or <a href="{{$company->url}}" target="_blank">visit their website!</a>

                            <hr>

                            <p>This company is currently looking to fill these positions:</p>
                            <ul>
                            @foreach($company->joboffers as $joboffer)
                                <li><a href="{{ route("joboffers::show", ['id' => $joboffer->id]) }}">{{ $joboffer->title }}</a></li>
                            @endforeach
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

    @else

        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        There are currently no job offers. Please check back soon! :)
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection