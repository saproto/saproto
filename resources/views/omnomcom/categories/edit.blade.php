@extends('website.layouts.panel')

@section('page-title')
    Category Administration
@endsection

@section('panel-title')
    {{ ($category == null ? "Create new category." : "Edit category " . $category->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($category == null ? route("omnomcom::categories::add") : route("omnomcom::categories::edit", ['id' => $category->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label for="name">Category name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Special Products for Unicorns" value="{{ $category->name or '' }}" required>
                </div>

            </div>

        </div>

        @endsection

        @section('panel-footer')

            @if($category)
                <a class="btn btn-danger"
                   onclick="return confirm('Remove category \'{{ $category->name }}\'?');"
                   href="{{ route('omnomcom::categories::delete', ['id' => $category->id]) }}"
                   role="button">
                    Delete
                </a>
            @endif

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("omnomcom::categories::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection