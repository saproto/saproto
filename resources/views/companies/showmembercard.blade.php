@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $company->name }}
@endsection

@section('content')

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

                        <a href="{{$company->url}}" target="_blank">Visit {{ $company->name }}'s website!</a>

                        <hr>

                        {!! Markdown::convertToHtml($company->membercard_long) !!}

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection