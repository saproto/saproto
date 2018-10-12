@extends('website.master')


@section('body')

    @include('website.navigation.navbar')

    <div style="width: 100%; height: 71px;">&nbsp;</div>

    <main role="main" class="container-fluid">

        <div class="row">

            <div class="col-lg-9">

                @yield('container')

            </div>

            <div class="col-lg-3">

                @include('website.layouts.macros.upcomingevents', ['n' => 4])

                @include('website.layouts.macros.recentalbums', ['n' => 2])

            </div>

        </div>

    </main>

    @include('website.footer')

@endsection