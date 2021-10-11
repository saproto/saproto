<form method="post"
      action="{{ isset($committee) ? route("committee::edit", ["id" => $committee->id]) : route("committee::add") }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">

            Committee information

        </div>

        <div class="card-body">

            <div class="form-group">
                <label for="name">Committee name</label>
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="Awesome Committee Extraordinaire" value="{{ isset($committee) ? $committee->name : "" }}">
            </div>

            @if((isset($committee) && ! $protected) || Auth::user()->can('sysadmin'))

            <div class="form-group">
                <label for="slug">Committee e-mail alias</label>

                <div class="input-group">
                    <input type="text" class="form-control" id="slug" name="slug"
                           placeholder="awesome" value="{{ isset($committee) ? $committee->slug : "" }}">
                    <div class="input-group-append">
                        <span class="input-group-text">@ {{ config('proto.emaildomain') }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="is_society">Committee type</label>
                        <select class="form-control" id="is_society" name="is_society">
                            <option value="0" {{ isset($committee) && $committee->is_society ? '' : 'selected' }}>Committee
                            </option>
                            <option value="1" {{ isset($committee) && $committee->is_society ? 'selected' : '' }}>Society
                            </option>
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="public">Committee visibility</label>
                        <select class="form-control" id="public" name="public">
                            <option value="0" {{ isset($committee) && $committee->public ? '' : 'selected' }}>Admin only
                            </option>
                            <option value="1" {{ isset($committee) && $committee->public ? 'selected' : '' }}>Public
                            </option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">
                        <label for="allow_anonymous_email">Enable anonymous e-mail</label>
                        <select id="allow_anonymous_email" class="form-control" name="allow_anonymous_email">
                            <option value="0" {{ isset($committee) && $committee->allow_anonymous_email ? '' : 'selected' }}>No
                            </option>
                            <option value="1" {{ isset($committee) && $committee->allow_anonymous_email ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </div>

                </div>

            </div>

            @endif

            <div class="form-group">
                <label for="editor">Description</label>
                @include('website.layouts.macros.markdownfield', [
                    'name' => 'description',
                    'placeholder' => isset($committee) ? null : "Please elaborate on why this committee is awesome.",
                    'value' => isset($committee) ? $committee->description : null
                ])
            </div>

        </div>

        <div class="card-footer">

            <a href="{{ isset($committee) ? route("committee::show", ["id" => $committee->getPublicId()]) : 'javascript:history.go(-1)' }}"
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
