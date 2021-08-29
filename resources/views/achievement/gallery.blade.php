@extends('website.layouts.redesign.generic')

@section('page-title')
    Achievement Overview
@endsection

@section('container')

    <div id="achievement-accordion">

        <?php $stars = 1; ?>

        @foreach(['common' => $common, 'uncommon' => $uncommon, 'rare' => $rare, 'epic' => $epic, 'legendary' => $legendary] as $tier => $achievements)

            <div class="card mb-3 achievement-{{ $tier }}" name="achievement-{{ $tier }}">

                <div class="card-header text-white" data-toggle="collapse"
                     data-target="#collapse-achievement-{{ $tier }}"
                     style="cursor: pointer;">

                    @for($i = 0; $i < 5; $i++)
                        @if ($i >= $achievements[0]->numberOfStars())
                            <i class="far fa-star"></i>
                        @else
                            <i class="fas fa-star"></i>
                        @endif
                    @endfor

                    <span class="text-capitalize ml-3">
                    <strong>{{ $tier }}</strong>
                </span>

                </div>

                <div class="card-body collapse {{ ($tier == 'common' ? 'show' : '') }}"
                     id="collapse-achievement-{{ $tier }}" data-parent="#achievement-accordion">

                    <div class="row">

                        @if(count($achievements) > 0)

                            @foreach($achievements as $achievement)

                                <div class="col-xl-4 col-md-6 col-sm-12">

                                    @include('achievement.includes.achievement_include', [
                                    'achievement' => $achievement
                                    ])

                                </div>

                            @endforeach

                        @endif

                        <?php $stars++; ?>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endsection

@push('stylesheet')

    <style type="text/css">
        #main {
            overflow-x: hidden;
        }
    </style>

@endpush