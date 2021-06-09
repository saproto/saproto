@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($joboffer == null ? "Create new job offer." : "Edit job offer " . $joboffer->title .".") }}
@endsection

@section('container')

    <form method="post"
          action="{{ ($joboffer == null ? route("joboffers::add") : route("joboffers::edit", ['id' => $joboffer->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row justify-content-center">

            <div class="col-md-4">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="company">Company</label>
                            <select id="company" name="company_id" class="form-control" required>
                                <option value="" @if($joboffer == null) selected @endif disabled>Select a company...
                                </option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                            @if($joboffer && $joboffer->company->id == $company->id) selected @endif>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Chief Executive Officer" value="{{ $joboffer->title ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label>Offer information type</label>
                            <select id="information_type_selector" class="form-control">
                                <option value="" @if(!$joboffer || ($joboffer->description == null && $joboffer->redirect_url == null)) selected @endif disabled>Select a type...
                                </option>
                                <option value="description" @if($joboffer && $joboffer->description != null) selected @endif>Description</option>
                                <option value="url" @if($joboffer && $joboffer->redirect_url != null) selected @endif>Redirect URL</option>
                            </select>
                        </div>

                        <div id="information_type_description" class="form-group">
                            <label for="editor-description">Description</label>
                            @include('website.layouts.macros.markdownfield', [
                                'name' => 'description',
                                'placeholder' => !$joboffer ? 'A text dedicated to the job offer. Be as elaborate as you need to be!' : null,
                                'value' => !$joboffer ? null : $joboffer->description
                            ])
                        </div>

                        <div id="information_type_url" class="form-group">
                            <label for="title">Redirect URL</label>
                            <input type="text" class="form-control" id="redirect_url" name="redirect_url"
                                   placeholder="https://example.com/apply" value="{{ $joboffer->redirect_url ?? '' }}">
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>

                    <div class="card-footer">
                        <a class="btn btn-default" href="{{ route("joboffers::admin") }}">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">Save</button>
                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('javascript')

    <script nonce="{{ csp_nonce() }}">
        $(document).ready(updateInformationDisplay);
        $('#information_type_selector').change(updateInformationDisplay);

        function updateInformationDisplay() {
            $('#information_type_description, #information_type_url').removeClass('d-none');
            switch($('#information_type_selector').val()) {
                case 'description':
                    $('#information_type_url').addClass('d-none');
                    $('#redirect_url').val('').removeAttr('required');
                    break;
                case 'url':
                    $('#information_type_description').addClass('d-none');
                    $('#redirect_url').attr('required', 'true');
                    simplemde.value('');
                    break;
                default:
                    $('#information_type_url, #information_type_description').addClass('d-none').find('input').val('');
                    $('#information_type_selector').attr('required', 'true');
                    simplemde.value('');
                    break;
            }
        }
    </script>

@endpush