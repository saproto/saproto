@extends('website.layouts.default-nobg')

@section('page-title')
    Achievement Overview
@endsection

@section('content')

    <div class="col-md-3">

        <div class="panel panel-default container-panel fixNav">

            <div class="panel-body">

                <h4>Select tier:</h4>
                <button class="btn COMMON" style="width:100px;"
                        onclick="document.getElementById('divCommon').scrollIntoView();">Common
                </button>
                <br>
                <button class="btn UNCOMMON" style="width:100px;"
                        onclick="document.getElementById('divUncommon').scrollIntoView();">Uncommon
                </button>
                <br>
                <button class="btn RARE" style="width:100px;"
                        onclick="document.getElementById('divRare').scrollIntoView();">Rare
                </button>
                <br>
                <button class="btn EPIC" style="width:100px;"
                        onclick="document.getElementById('divEpic').scrollIntoView();">Epic
                </button>
                <br>
                <button class="btn LEGENDARY" style="width:100px;"
                        onclick="document.getElementById('divLegendary').scrollIntoView();">Legendary
                </button>

            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="panel panel-default container-panel" id="divCommon">

            <div class="panel-body">

                <ul class="achievement-list achievement-gallery">

                    <li class="achievement COMMON">
                        <div class="achievement-label">
                            <img src="{{ asset('images/achievements/common.svg') }}" alt="">
                        </div>
                        <div class="achievement-icon">
                            COMMON
                        </div>
                    </li>
                    <br><br>

                    @foreach($common as $achievement)

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                    <div class="achievement-data">
                                        <sub>Available since: {{ $achievement->created_at->format('d/m/Y') }}.</sub>
                                        @if(Auth::check() && Auth::user()->can("board"))
                                            <a class="del"
                                               href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">Edit</a>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <div class="panel panel-default container-panel" id="divUncommon">

            <div class="panel-body">

                <ul class="achievement-list achievement-gallery">

                    <li class="achievement UNCOMMON">
                        <div class="achievement-label">
                            <img src="{{ asset('images/achievements/uncommon.svg') }}" alt="">
                        </div>
                        <div class="achievement-icon">
                            UNCOMMON
                        </div>
                    </li>
                    <br><br>

                    @foreach($uncommon as $achievement)

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                    <div class="achievement-data">
                                        <sub>Available since: {{ $achievement->created_at->format('d/m/Y') }}.</sub>
                                        @if(Auth::check() && Auth::user()->can("board"))
                                            <a class="del"
                                               href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">Edit</a>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <div class="panel panel-default container-panel" id="divRare">

            <div class="panel-body">

                <ul class="achievement-list achievement-gallery">

                    <li class="achievement RARE">
                        <div class="achievement-label">
                            <img src="{{ asset('images/achievements/rare.svg') }}" alt="">
                        </div>
                        <div class="achievement-icon">
                            RARE
                        </div>
                    </li>
                    <br><br>

                    @foreach($rare as $achievement)

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                    <div class="achievement-data">
                                        <sub>Available since: {{ $achievement->created_at->format('d/m/Y') }}.</sub>
                                        @if(Auth::check() && Auth::user()->can("board"))
                                            <a class="del"
                                               href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">Edit</a>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <div class="panel panel-default container-panel" id="divEpic">

            <div class="panel-body">

                <ul class="achievement-list achievement-gallery">

                    <li class="achievement EPIC">
                        <div class="achievement-label">
                            <img src="{{ asset('images/achievements/epic.svg') }}" alt="">
                        </div>
                        <div class="achievement-icon">
                            EPIC
                        </div>
                    </li>
                    <br><br>

                    @foreach($epic as $achievement)

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                    <div class="achievement-data">
                                        <sub>Available since: {{ $achievement->created_at->format('d/m/Y') }}.</sub>
                                        @if(Auth::check() && Auth::user()->can("board"))
                                            <a class="del"
                                               href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">Edit</a>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <div class="panel panel-default container-panel" id="divLegendary">

            <div class="panel-body">

                <ul class="achievement-list achievement-gallery">

                    <li class="achievement LEGENDARY">
                        <div class="achievement-label">
                            <img src="{{ asset('images/achievements/legendary.svg') }}" alt="">
                        </div>
                        <div class="achievement-icon">
                            LEGENDARY
                        </div>
                    </li>
                    <br><br>

                    @foreach($legendary as $achievement)

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                    <div class="achievement-data">
                                        <sub>Available since: {{ $achievement->created_at->format('d/m/Y') }}.</sub>
                                        @if(Auth::check() && Auth::user()->can("board"))
                                            <a class="del"
                                               href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">Edit</a>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endsection