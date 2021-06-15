@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Create new e-mail
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            @include('emailadmin.admin_includes.email-edit')

        </div>

        <div class="col-md-3">

            @include('emailadmin.admin_includes.variables')

            @include('emailadmin.admin_includes.attachments')

            @include('emailadmin.admin_includes.recipients')

        </div>

    </div>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        $("#destinationEvent").on('click', function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', false);
        });
        $("#destinationLists").on('click', function () {
            $("#listSelect").prop('disabled', false);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationMembers").on('click', function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationUsers").on('click', function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationActiveMembers").on('click', function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
    </script>

@endpush