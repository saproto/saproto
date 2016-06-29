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
        <li class="list-group-item achievement {{ $achievement->tier }}">

            <div class="achievement-icon">
                @if($achievement->image)
                    <img src="{!! $achievement->image->generateImagePath(700,null) !!}" alt="">
                @else
                    No icon available
                @endif
            </div>
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

        .achievement div {
            float: right;
            width: 50%;
            padding: 10px;
            padding-bottom: 0;
        }

        .achievement .achievement-icon {
            padding:0;
            text-align:center;
            max-width:calc(50% - 20px);
            height:calc(100% - 20px);
            top:50%;
            position: absolute;
            transform:translate(0, -50%);
        }

        .list-group {
            margin-bottom:0;
        }

        .achievement-icon img {
            height: 100px;
            max-width: 100%;
            top:50%;
            left:50%;
            position: absolute;
            transform:translate(-50%, -50%);
        }

        .achievement {
            margin-top:5px;
            overflow: hidden;
            word-wrap: break-word;
            border-width: 5px;
            position: relative;
            height:120px;
        }

        #user-select div {
            padding: 0;
        }

        .COMMON {
            border-color: #DDDDDD;
        }

        .UNCOMMON {
            border-color: #1E90FF;
        }

        .RARE {
            border-color: #9932CC;
        }

        .EPIC {
            border-color: #333333;
        }

        .LEGENDARY {
            border-color: #C1FF00;
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