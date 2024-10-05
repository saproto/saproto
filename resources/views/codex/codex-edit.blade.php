@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Edit codex
@endsection

@section('container')
    <form
        action="{{ isset($codex)&&$codex?route('codex::update-codex', ['codex'=>$codex]):route("codex::store-codex") }}"
        method="POST">
        {{ csrf_field()}}
        <div class="row gap-3">
            <div class="col">
                <div class="row">
                    @include('codex.includes.codex-details', ['codex'=>$codex])
                </div>
                <div class="row">
                    @include('codex.includes.text_types', ['edit'=>true, 'textTypes' => $textTypes, 'myTextTypes' => $myTextTypes])
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="card mb-3 p-3">
                        <div class="d-inline-flex justify-content-between">
                            <button type="submit" class="btn btn-success btn-block">
                                Save codex!
                            </button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="card-body">
                        @include('codex.includes.song_list', ['edit'=>true, 'songTypes' => $songTypes, 'mySongs' => $mySongs, 'myShuffles' => $myShuffles])
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
