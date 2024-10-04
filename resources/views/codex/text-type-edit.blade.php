@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Edit Text Type
@endsection

@section('container')
    <form
        action="{{ isset($textType)&&$textType?route('codex::update-text-type', ['id'=>$textType->id]):route("codex::store-text-type") }}"
        method="POST">
        {{ csrf_field()}}
        <div class="row gap-3 justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-header">
                            Text type
                        </div>
                        <div class="card-body">
                            <label for="type">Name:</label>
                            <div class="form-group mb-3">
                                <input type="text" value="{{$textType->type??""}}" class="form-control" id="type"
                                       name="type">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                Save text type!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
