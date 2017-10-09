@extends('website.layouts.default-nobg')

@section('page-title')
    Dashboard for {{ $user->name }}
@endsection

@section('content')

    <h2 class="dashboard__divider">
        Personal information
    </h2>

    <div class="row">
        <div class="col-md-4">
            @include('users.dashboard.basicinfo')
            @include('users.dashboard.memberinfo')
            @include('users.dashboard.addressinfo')
            @include('users.dashboard.fininfo')
            @include('users.dashboard.allergies')
        </div>
        <div class="col-md-4">
            @include('users.dashboard.profilepic')
            @include('users.dashboard.account')
        </div>
        <div class="col-md-4">
            @include('users.dashboard.maillists')
        </div>
    </div>

    @if($user->bank != null)
        @include("users.dashboard.deletebank")
    @endif

    <h2 class="dashboard__divider">
        Study information
    </h2>

    <div class="row">
        <div class="col-md-4">
            @include('users.dashboard.utwenteinfo')
        </div>
        <div class="col-md-8">
            @include('users.dashboard.studyinfo')
        </div>
    </div>

    <h2 class="dashboard__divider">
        Account details
    </h2>

    <div class="row">
        <div class="col-md-5">
            @include('users.dashboard.2fa')
            @if (!$user->member)
                @include('users.dashboard.deleteaccount')
            @endif
            @if (count($user->roles) > 0)
                @include('users.dashboard.roleinfo')
            @endif
            @include('users.dashboard.personal_key')
        </div>
        <div class="col-md-7">
            @include('users.dashboard.cardinfo')
        </div>
    </div>

@endsection


@section('javascript')

    @parent
    <script type="text/javascript">

        angular.module('app', ['ngImgCrop'], function ($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        })
            .controller('Ctrl', function ($scope) {
                $scope.myImage = '';
                $scope.myCroppedImage = '';

                var handleFileSelect = function (evt) {
                    var file = evt.currentTarget.files[0];
                    var reader = new FileReader();
                    reader.onload = function (evt) {
                        $scope.$apply(function ($scope) {
                            $scope.myImage = evt.target.result;
                        });
                    };
                    reader.readAsDataURL(file);
                };
                angular.element(document.querySelector('#fileInput')).on('change', handleFileSelect);
            });
    </script>

@endsection

@section('stylesheet')

    @parent
    <style type="text/css">
        .cropArea {
            background: #E4E4E4;
            overflow: hidden;
            width: 100%;
            height: 300px;
        }
    </style>
@endsection
