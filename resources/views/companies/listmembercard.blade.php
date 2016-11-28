@extends('website.layouts.default-nobg')

@section('page-title')
    Proto Membercard
@endsection

@section('content')

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

                            <a href="{{ route('membercard::show', ['id' => $company->id]) }}">Learn more about this
                                company</a> or <a href="{{$company->url}}" target="_blank">visit their website!</a>

                            <hr>

                            {!! Markdown::convertToHtml($company->membercard_excerpt) !!}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

@endsection