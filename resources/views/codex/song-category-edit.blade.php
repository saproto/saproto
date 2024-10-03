@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Edit Song category
@endsection

@section('container')
    <form
        action="{{ isset($category)&&$category?route('codex::update-song-category', ['id'=>$category->id]):route("codex::store-codex-category") }}"
        method="POST">
        {{ csrf_field()}}
        <div class="row gap-3 justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-header">
                            Song category
                        </div>
                        <div class="card-body">
                            <label for="name">Name:</label>
                            <div class="form-group mb-3">
                                <input type="text" value="{{$category->name??""}}" class="form-control" id="name"
                                       name="name">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                Save song category!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
