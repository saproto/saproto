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
                    <span class="input-group-text">@ {{ config('proto.emaildomain') }}</span>
                </div>


            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="is_society">Committee type</label>
                        <select class="form-control" id="is_society" name="is_society">
                            <option value="0" @selected(!$new && !$committee->is_society)>Committee
                            </option>
                            <option value="1" @selected(!$new && $committee->is_society)>Society
                            </option>
                        </select>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="public">Committee visibility</label>
                        <select class="form-control" id="public" name="public">
                            <option value="0" @selected(!$new && !$committee->public)>Admin only
                            </option>
                            <option value="1" @selected(!$new && $committee->public)>Public
                            </option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="form-group mt-1" id="isSocietyActiveGroup">
                <div class="input-group" id="isActiveInput">
                    @include('components.forms.checkbox', [
                                'name' => 'is_active',
                                'checked' => !$new && !$committee?->is_active ,
                                'label' => "Set " . ($committee?->is_society ? 'society' : 'committee') . " as inactive"
                            ])
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">
                        <label for="allow_anonymous_email">Enable anonymous e-mail</label>
                        <select class="form-control" id="allow_anonymous_email" name="allow_anonymous_email">
                            <option value="0" @selected(!$new && $committee->allow_anonymous_email)>No
                            </option>
                            <option value="1" @selected(!$new && $committee->allow_anonymous_email)>Yes
                            </option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="form-group">
                <label for="editor">Description</label>
                @include('components.forms.markdownfield', [
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

            <button type="submit" class="btn btn-success float-end">
                Save
            </button>

        </div>

    </div>

</form>
@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        // Update the is active checkbox when the committee type is changed
        document.getElementById('is_society').addEventListener("change", function() {
            updateSocietyActive(this.value === '1');
        });

        // Update the is active checkbox when the committee type is changed
        function updateSocietyActive(isSociety) {
            document.getElementById('isActiveInput').lastElementChild.lastElementChild.innerText = "Set " + (isSociety ? 'society' : 'committee') + " as inactive";
        }

        // Set the initial state of the is active checkbox
        updateSocietyActive(Boolean({{($committee?->is_society ?? 0)}}));
    </script>
@endpush
