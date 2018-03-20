<form method="post"
      action="{{ ( $new ? route("committee::add") : route("committee::edit", ["id" => $committee->id]) ) }}">

    {!! csrf_field() !!}

    <div class="panel panel-default">

        <div class="panel-heading">

            Committee properties

        </div>

        <div class="panel-body">

            <div class="form-group">
                <label for="name">Committee name</label>
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="Awesome Committee Extraordinaire" value="{{ (!$new ? $committee->name : "" ) }}">
            </div>

            <div class="form-group">
                <label for="slug">Committee e-mail alias</label>

                <div class="input-group">
                    <input type="text" class="form-control" id="slug" name="slug"
                           placeholder="awesome" value="{{ (!$new ? $committee->slug : "") }}">
                    <span class="input-group-addon">@ {{ config('proto.emaildomain') }}</span>
                </div>

            </div>

            <div class="form-group">
                <label for="public">Committee visibility</label>
                <select class="form-control" id="public" name="public">
                    <option value="0" {{ (!$new && $committee->public ? '' : 'selected') }}>Hidden
                    </option>
                    <option value="1" {{ (!$new && $committee->public ? 'selected' : '') }}>Public
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="public">Users can send anonymous e-mail to committee</label>
                <select class="form-control" id="allow_anonymous_email" name="allow_anonymous_email">
                    <option value="0" {{ (!$new && $committee->allow_anonymous_email ? '' : 'selected') }}>No
                    </option>
                    <option value="1" {{ (!$new && $committee->allow_anonymous_email ? 'selected' : '') }}>Yes
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="editor">Description</label>
                @if ($new)
                    <textarea id="editor" name="description"
                              placeholder="Please elaborate on why this committee is awesome."></textarea>
                @else
                    <textarea id="editor" name="description">{{ $committee->description }}</textarea>
                @endif
            </div>

        </div>

        <div class="panel-footer clearfix">

            <a href="{{ ($new ? 'javascript:history.go(-1)' : route("committee::show", ["id" => $committee->getPublicId()]) ) }}"
               class="btn btn-default">
                Cancel
            </a>
            &nbsp;

            <button type="submit" class="btn btn-success pull-right">
                Save
            </button>

        </div>

    </div>

</form>

@if(!$new)
    <form method="post" action="{{ route("committee::image", ["id" => $committee->id]) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="panel panel-default">

            <div class="panel-heading">
                Update committee image
            </div>

            <div class="panel-body">

                @if($committee->image)

                    <img src="{!! $committee->image->generateImagePath(700,null) !!}" width="100%;">

                @else
                    <p>
                        &nbsp;
                    </p>
                    <p style="text-align: center;">
                        This committee has no banner image yet. Upload one now!
                    </p>
                @endif

                <hr>

                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="image" class="col-sm-4 control-label">New banner image</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="image" type="file" name="image">
                        </div>
                    </div>

                </div>

            </div>

            <div class="panel-footer clearfix">
                <button type="submit" class="btn btn-success pull-right">
                    Replace committee image
                </button>
            </div>

        </div>

    </form>
@endif
