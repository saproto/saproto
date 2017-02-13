@extends('website.layouts.default-nobg')

@section('page-title')
    Dashboard for {{ $user->name }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5 col-xs-12">
            @include('users.dashboard.2fa')
            @include('users.dashboard.account')
        </div>
        <div class="col-md-4 col-xs-12">
            @include('users.dashboard.profilepic')
            @include('users.dashboard.addressinfo')
            @include('users.dashboard.fininfo')
            @include('users.dashboard.cardinfo')
        </div>
        <div class="col-md-3 col-xs-12">
            @include('users.dashboard.studyinfo')
        </div>
    </div>

    @if($user->bank != null)
        @include("users.dashboard.deletebank")
    @endif

@endsection


@section('javascript')

    @parent
        <script  type="text/javascript">

        angular.module('app', ['ngImgCrop'], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            })
          .controller('Ctrl', function($scope) {
            $scope.myImage='';
            $scope.myCroppedImage='';

            var handleFileSelect=function(evt) {
              var file=evt.currentTarget.files[0];
              var reader = new FileReader();
              reader.onload = function (evt) {
                $scope.$apply(function($scope){
                  $scope.myImage=evt.target.result;
                });
              };
              reader.readAsDataURL(file);
            };
            angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);
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
