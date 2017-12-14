@extends('website.layouts.default-nobg')

@section('page-title')
    Company Administration
@endsection

@section('content')

    <form method="post"
          action="{{ ($company == null ? route("companies::add") : route("companies::edit", ['id' => $company->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        Descriptions
                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="editor">Excerpt</label>
                                    <textarea id="editor-excerpt"
                                              name="excerpt">{{ $company->excerpt or 'A small paragraph about this company.' }}</textarea>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="editor">Long</label>
                                    <textarea id="editor-description"
                                              name="description">{{ $company->description or 'A text dedicated to the company. Be as elaborate as you need to be!' }}</textarea>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Descriptions for membercard
                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="editor">Excerpt for membercard</label>
                                    <textarea id="editor-membercard_excerpt"
                                              name="membercard_excerpt" placeholder="A small paragraph about what this company does on our membercard.">{{ $company->membercard_excerpt or '' }}</textarea>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="editor">Long for membercard</label>
                                    <textarea id="editor-membercard_long"
                                              name="membercard_long" placeholder="A text dedicated to the companies role for our membercard. Be as elaborate as you need to be!">{{ $company->membercard_long or '' }}</textarea>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-heading">

                        {{ ($company == null ? "Create new company." : "Edit company " . $company->name .".") }}

                    </div>

                    <div class="panel-body">

                        @if($company && $company->image)

                            <img src="{!! $company->image->generateImagePath(500, null) !!}" style="width: 100%">

                            <hr>

                        @endif

                        <div class="form-group">
                            <label for="name">Company name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Aperture Science" value="{{ $company->name or '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="url">Company website:</label>
                            <input type="text" class="form-control" id="url" name="url"
                                   placeholder="http://www.aperturescience.com/" value="{{ $company->url or '' }}"
                                   required>
                        </div>

                        <hr>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="on_carreer_page" {{ ($company && $company->on_carreer_page? 'checked' : '') }}>
                                Visible on the carreer page.
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="in_logo_bar" {{ ($company && $company->in_logo_bar? 'checked' : '') }}>
                                Place logo in the logo bar.
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="in_logo_bar" {{ ($company && $company->on_membercard? 'checked' : '') }}>
                                    Visible on membercard page.
                            </label>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="image">Image file:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">
                            Submit
                        </button>

                        <a href="{{ route("companies::admin") }}" class="btn btn-default pull-right">Cancel</a>

                    </div>

                </div>
            </div>

        </div>

    </form>

@endsection



@section('javascript')

    @parent

    <script>
        var simplemde1 = new SimpleMDE({
            element: $("#editor-excerpt")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
        var simplemde2 = new SimpleMDE({
            element: $("#editor-description")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
        var simplemde3 = new SimpleMDE({
            element: $("#editor-membercard_excerpt")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
        var simplemde4 = new SimpleMDE({
            element: $("#editor-membercard_long")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
    </script>

@endsection