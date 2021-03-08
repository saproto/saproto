@extends('website.layouts.redesign.generic')

@section('page-title')
    Front-end Injections
@endsection

@section('container')

    <div class="row">

        <div class="col-md-8 col-xl-6">
            @include('frontendinjections.admin_includes.inject-details')
        </div>

        <div class="col-md-4" style="max-width: 300px">
            @include('frontendinjections.admin_includes.inject-list')
        </div>

    </div>

@endsection