@extends('website.layouts.default-nobg')

@section('page-title')
    @if($new)
        Create new committee
    @else
        Edit: {{ $committee->name }}
    @endif
@endsection

@section('content')

    <div class="row">

        <div class="{{ ($new ? 'col-md-6 col-md-offset-3' : 'col-md-7') }}">

            @include('committee.form-members')

            @include('committee.form-committee')

        </div>

        @if(!$new)

            <div class="col-md-5">

                @include('committee.members-list')

            </div>

        @endif

    </div>

@endsection

@section('javascript')

    @parent

    <script>
        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });

        $('#committee-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    </script>

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left"
            },
            format: 'DD-MM-YYYY'
        });
    </script>

    <script type="text/javascript">
        $("#member-search").select2({
            ajax: {
                url: "{{ route('api::search::user') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: false
            },
            placeholder: 'Search for a user',
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo(item) {
            if (item.loading) {
                return item.text;
            } else {
                return item.name + " (#" + item.id + ")";
            }
        }

        function formatRepoSelection(item) {
            return item.name;
        }
    </script>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .committee-seperator {
            margin: 10px 0;
        }

    </style>

@endsection
