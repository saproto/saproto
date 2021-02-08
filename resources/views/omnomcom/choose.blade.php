@extends('website.master')

@section('page-title')

    Choose OmNomCom Store

@endsection

@section('body')

    <div class="row justify-content-center">

        <div class="col-xl-3 col-lg-5 col-md-6 col-sm-10 col-xs-12 mx-3 text-center">

            <div class="card mb-3 mt-5">

                <div class="card-header text-center bg-dark text-white">
                    @yield('page-title')
                </div>

                <ul class="list-group list-group-flush">
                    @foreach(config('omnomcom.stores') as $slug => $store)
                        <a href="{{ route('omnomcom::store::show', ['store' => $slug]) }}" class="list-group-item">
                            {{ $store->name }}
                        </a>
                    @endforeach
                </ul>

                <small href="/" style="text-decoration: none !important;" class="card-footer text-muted text-center">
                    @if(Auth::check())
                        Logged in as <strong>{{ Auth::user()->name }}</strong>. <a href="{{ route('login::logout') }}">Log
                            out.</a>
                    @else
                        Nog logged in. <a href="{{ route('login::show') }}">Log in.</a>
                    @endif
                </small>

            </div>

        </div>

    </div>

@endsection

@push('stylesheet')

    <style>

        #footer {
            display: none;
        }

    </style>

@endpush