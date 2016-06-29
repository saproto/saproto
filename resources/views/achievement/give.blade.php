@extends('website.layouts.panel')

@section('page-title')
    Achievement Administration
@endsection

@section('panel-title')
    Give an Achievement
@endsection

@section('panel-body')

    <form method="post"
          action="{{ route("achievement::give", ['id' => $achievement->id]) }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="id">Member</label>
            <div id="user-select">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="member-name" placeholder="John Doe" required>
                    <input type="hidden" id="member-id" name="user_id" required>
                </div>
                <div class="col-sm-2">
                    <input type="button" class="form-control btn btn-success" id="member-clear" value="Clear">
                </div>
            </div>
        </div>

        <hr>

        <strong>Achievement to give:</strong>
        <li class="list-group-item achievement">

            <img src="{{ $achievement->img_file_id }}" alt="{{ $achievement->name }} icon"/>
            <div>
                <strong>{{ $achievement->name }}</strong>
                <p>{{ $achievement->desc }}</p>
            </div>

        </li>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Give</button>

            <a href="{{ route("achievement::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .achievement img, .achievement div {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .achievement {
            overflow: hidden;
            word-wrap: break-word;
        }

        #user-select div {
            padding: 0;
        }

    </style>

@endsection

@section('javascript')

    @parent

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

@endsection