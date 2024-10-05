@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Edit Song
@endsection

@section('container')
    <form action="{{ isset($song)&&$song?route('codex::update-song', ['id'=>$song->id]):route("codex::store-codex") }}"
          method="POST">
        {{ csrf_field()}}
        <div class="row gap-3 justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-header">
                            Song
                        </div>
                        <div class="card-body">
                            {{-- Title }--}}
                            <label for="type">Title:</label>
                            <div class="form-group mb-3">
                                <input type="text" value="{{$song->title??""}}" class="form-control" id="title"
                                       name="title">
                            </div>

                            {{-- Artist }--}}
                            <label for="artist">Artist:</label>
                            <div class="form-group mb-3">
                                <input type="text" value="{{$song->artist??""}}" class="form-control" id="artist"
                                       name="artist">
                            </div>

                            {{-- Youtube ID }--}}
                            <label for="youtube">Youtube ID:</label>
                            <div class="form-group mb-3">
                                <input type="text" value="{{$song->youtube??""}}" class="form-control" id="youtube"
                                       name="youtube">
                            </div>

                            {{-- Categories }--}}
                            <label for="categories">Categories:</label>
                            <ul>
                                @foreach($categories as $category)
                                    <li>
                                        <div class="form-check d-inline-flex">
                                            <input class="form-check-input" type="checkbox"
                                                   {{in_array($category->id, $myCategories)?"checked":""}} name="categoryids[]"
                                                   value="{{$category->id}}">
                                        </div>
                                        {{ $category->name}}
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Lyrics }--}}
                            <label for="lyrics">Lyrics:</label>
                            <div class="form-group mb-3">
                                @include('components.forms.markdownfield', [
                               'name' => 'lyrics',
                                   'placeholder' => "Awesome lyrics here!",
                                   'value' => $song->lyrics??"",
                               ])
                            </div>

                            <button type="submit" class="btn btn-success btn-block">
                                Save song!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
