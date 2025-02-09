@extends('website.layouts.redesign.generic')

@section('page-title')
    Committees
@endsection

@section('container')
    {{-- Active societies or committees --}}
    @php
        $active = $data->filter(function ($item) {
            return $item->is_active;
        });
    @endphp

    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Active
            {{ $society ? 'societies' : 'committees' }}
        </div>
        <div class="card-body">
            <div class="row" id="committee__list">
                @foreach ($active as $key => $committee)
                    <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
                        @include('committee.include.committee_block', ['committee' => $committee, 'photo_pop' => false])
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Inactive societies or committees --}}
    @php
        $inactive = $data->filter(function ($item) {
            return ! $item->is_active;
        });
    @endphp

    @if ($inactive->count() > 0)
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">
                Inactive
                {{ $society ? 'societies' : 'committees' }}
            </div>
            <div class="card-body">
                <div class="row" id="committee__list_inactive">
                    @foreach ($inactive as $key => $committee)
                        <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
                            @include('committee.include.committee_block', ['committee' => $committee, 'photo_pop' => false])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
