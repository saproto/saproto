@extends('website.layouts.panel')

@section('page-title')
    OmNomCom Store
@endsection

@section('panel-title')
    Which store would you like to open?
@endsection

@section('panel-body')

    <ul class="list-group">

        @foreach($stores as $name => $store)

            <li class="list-group-item">

                <a href="{{ route('omnomcom::store::show', ['store'=>$name]) }}">
                    {{ $store->name }}
                </a>

            </li>

        @endforeach

    </ul>

@endsection