@extends('website.layouts.default-nobg')

@section('page-title')
    Edit: {{ $committee->name }}
@endsection

@section('content')

    <ul id="committee-tab" class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"
                                                  class="white">Committee Info</a></li>
        <li role="presentation"><a href="#members" aria-controls="members" role="tab" data-toggle="tab" class="white">Committee
                Members</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="info">@include('committee.form-committee')</div>
        <div role="tabpanel" class="tab-pane" id="members">@include('committee.form-members')</div>
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
                $("#member-name").val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);;
                $("#member-id").val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
        $("#member-clear").click(function() {
            $("#member-name").val("").prop('disabled', false);;
            $("#member-id").val("");
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