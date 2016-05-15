@extends('website.layouts.default-nobg')

@section('page-title')
    Edit: {{ $committee->name }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-7">

            @include('committee.form-members')

            @include('committee.form-committee')

        </div>

        <div class="col-md-5">

            @include('committee.members-list')

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({selector: '#editor'});

        $('#committee-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    </script>

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script>
        $("#member-name").autocomplete({
            minLength: 3,
            source: "{{ route("api::members") }}",
            select: function (event, ui) {
                $("#member-name").val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                ;
                $("#member-id").val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
        $("#member-clear").click(function () {
            $("#member-name").val("").prop('disabled', false);
            ;
            $("#member-id").val("");
        });
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

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .committee-seperator {
            margin: 10px 0;
        }

        @if($committee->image)
        #header {
            background-image: url('{{ route("file::get", ['id' => $committee->image->id]) }}');
        }
        @endif

    </style>

@endsection