@extends('website.layouts.default-nobg')

@section('page-title')
    Job Offer Administration
@endsection

@section('content')

    <form method="post"
          action="{{ ($joboffer == null ? route("joboffers::add") : route("joboffers::edit", ['id' => $joboffer->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        {{ ($joboffer == null ? "Create new job offer." : "Edit job offer " . $joboffer->title .".") }}
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="company">Company</label>
                            <select id="company" name="company_id" class="form-control" required>
                                    <option value="" @if($joboffer == null) selected @endif disabled>Select a company...</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if($joboffer && $joboffer->company->id == $company->id) selected @endif>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Chief Executive Officer" value="{{ $joboffer->title or '' }}" required>
                        </div>


                        <div class="form-group">
                            <label for="editor-description">Description</label>
                            <textarea id="editor-description"
                                      name="description">{{ $joboffer->description or 'A text dedicated to the job offer. Be as elaborate as you need to be!' }}</textarea>
                        </div>

                    </div>

                    <div class="panel-footer">
                        <a class="btn btn-default" href="{{ route("joboffers::admin") }}">Cancel</a>
                        <button type="submit" class="btn btn-success pull-right">Save</button>
                    </div>

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
            element: $("#editor-description")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
    </script>

@endsection