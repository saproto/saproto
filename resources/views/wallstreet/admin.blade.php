@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Wallstreet Admin
@endsection

@section('container')
    <div class="row">
        <div class="col-xl-4">

            @include('wallstreet.admin_includes.wallstreetdrink-details')

            @if($currentDrink)
                @include('wallstreet.admin_includes.wallstreetdrink-product-list')
            @endif
        </div>
        <div class="col-xl-8">

            @include('wallstreet.admin_includes.wallstreetdrink-list')

        </div>
    </div>
@endsection