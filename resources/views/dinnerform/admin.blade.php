@extends('website.layouts.redesign.generic')

@section('page-title')
    Dinner Form Admin
@endsection

@section('container')
    <div class="row">
        <div class="col-xl-6">

            @include('dinnerform.admin_includes.dinnerform-details')

        </div>
        <div class="col-xl-4 offset-xl-2">

            @include('dinnerform.admin_includes.dinnerform-list')

        </div>
    </div>
@endsection