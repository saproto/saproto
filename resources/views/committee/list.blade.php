@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    Committees
@endsection

@section('container')

    <div class="card mb-3">

        <div class="card-header bg-dark text-white text-center">
            Committees of S.A. Proto
        </div>

        <div class="card-body">

            <div class="row" id="committee__list">

                @foreach($data as $key => $committee)

                    <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">

                        @include('website.layouts.macros.card-bg-image', [
                                    'url' => route('committee::show', ['id' => $committee->getPublicId()]),
                                    'img' => $committee->image->generateImagePath(450, 300),
                                    'html' => !$committee->public ? sprintf('<i class="fa fa-lock"></i>&nbsp;&nbsp;%s', $committee->name) : sprintf('<strong>%s</strong>', $committee->name),
                                    'height' => '120',
                                    'classes' => !$committee->public ? ['committee__hidden'] : null,
                                    'photo_pop' => true
                        ])

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .committee__hidden {
            opacity: 0.5;
        }

    </style>

@endsection
