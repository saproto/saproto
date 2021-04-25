@extends('website.layouts.redesign.generic')

@section('page-title')
    Dinner Form Signup
@endsection

@section('container')
    <div class="row">
        <div class="col-xl-4 offset-xl-4">
            @include('dinnerform.dinnerform_block', ['dinnerform'=> $dinnerform, 'canEdit' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 offset-xl-4">
            @include('dinnerform.show_includes.order-details')
        </div>
    </div>
@endsection