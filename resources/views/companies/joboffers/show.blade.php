@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $joboffer->company->name }}: {{ $joboffer->title }}
@endsection

@section('content')

    <div class="company__row">

        <div class="row">

            <div class="col-md-5 col-xs-6">

                <div class="company__row__image">

                    <div style="{{ ($joboffer->company->image ? "background-image: url(".$joboffer->company->image->generateImagePath(600, null).");" : '') }}">

                    </div>

                </div>

            </div>

            <div class="col-md-7 col-xs-6 company__row__excerpt">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <h3>{{ $joboffer->title }}</h3>

                        Posted on {{ date_format($joboffer->created_at, 'd-m-Y') }} for <a href="{{ route('companies::show', ['id' => $joboffer->company->id]) }}" target="_blank">{{ $joboffer->company->name }}</a>.

                        <hr>

                        {!! Markdown::convertToHtml($joboffer->description) !!}

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection