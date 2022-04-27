@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Protube Admin
@endsection

@section('container')

    <div id="connecting" class="text-center mt-5">
        <h3><i class='fas fa-spinner fa-spin me-2'></i> Connecting...</h3>
    </div>

    <div id="no_admin" class="text-center mt-5 d-none">
        <h3><i class="fas fa-exclamation-triangle me-2"></i> Could not connect to ProTube admin!</h3>
        Very probably something went wrong. Please log-out, log-in and try again.
    </div>

    <div id="connected">

        <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-6 col-md-6">

                @include('protube.admin_includes.protube_control')

                @include('protube.admin_includes.protopolis')

            </div>

            <div class="col-xl-4 col-lg-6 col-md-6">

                @include('protube.admin_includes.queue_mgmt')

            </div>

            <div class="col-xl-4 col-lg-6 col-md-6">

                @include('protube.admin_includes.soundboard')

                @include('protube.admin_includes.clients')

            </div>

        </div>

    </div>

@endsection

@include('protube.admin_includes.javascript')
@include('protube.admin_includes.stylesheet')
