<form method="post"
      action="{{ ( $new ? route("committee::add") : route("committee::edit", ["id" => $committee->id]) ) }}">

    {!! csrf_field() !!}

    <div class="card">

        <div class="card-header bg-dark text-white">

            Committee information

        </div>

        <div class="card-body">

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
                    <div class="input-group-append">
                        <span class="input-group-text">@ {{ config('proto.emaildomain') }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="public">Committee type</label>
                        <select class="form-control" id="is_society" name="is_society">
                            <option value="0" {{ (!$new && $committee->is_society ? '' : 'selected') }}>Committee
                            </option>
                            <option value="1" {{ (!$new && $committee->is_society ? 'selected' : '') }}>Society
                            </option>
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="public">Committee visibility</label>
                        <select class="form-control" id="public" name="public">
                            <option value="0" {{ (!$new && $committee->public ? '' : 'selected') }}>Admin only
                            </option>
                            <option value="1" {{ (!$new && $committee->public ? 'selected' : '') }}>Public
                            </option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">
                        <label for="public">Enable anonymous e-mail</label>
                        <select class="form-control" id="allow_anonymous_email" name="allow_anonymous_email">
                            <option value="0" {{ (!$new && $committee->allow_anonymous_email ? '' : 'selected') }}>No
                            </option>
                            <option value="1" {{ (!$new && $committee->allow_anonymous_email ? 'selected' : '') }}>Yes
                            </option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="form-group">
                <label for="editor">Description</label>
                @include('website.layouts.macros.markdownfield', [
                    'name' => 'description',
                    'placeholder' => $new ? "Please elaborate on why this committee is awesome." : null,
                    'value' => $new ? null : $committee->description
                ])
            </div>

        </div>

        <div class="card-footer">

            <a href="{{ ($new ? 'javascript:history.go(-1)' : route("committee::show", ["id" => $committee->getPublicId()]) ) }}"
               class="btn btn-light">
                Cancel
            </a>
            &nbsp;

            <button type="submit" class="btn btn-success float-right">
                Save
            </button>

        </div>

    </div>

</form>
