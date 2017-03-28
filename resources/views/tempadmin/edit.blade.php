@extends('website.layouts.panel')

@section('page-title')

    Temp Admin Admin

@endsection

@section('panel-title')

    @if($new) New temp admin @else Edit temp admin @endif

@endsection



@section('panel-body')

    <form method="post"
          action="{{ ($new ? route("tempadmin::add") : route("tempadmin::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="menuname">User:</label>
            @if($new)
                <div class="input-group">
                    <input type="text" class="form-control member-name"
                           placeholder="John Doe"
                           autocomplete="off"
                           required>
                    <input type="hidden" class="member-id" name="user_id" required>
                    <span class="input-group-btn">
                        <button class="btn btn-danger member-clear" disabled>
                            <i class="fa fa-eraser" aria-hidden="true"></i>
                        </button>
                    </span>
                </div>
            @else
                <div class="input-group">
                    <strong>{{ $item->user->name }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="url">Start at:</label>
            <input type="datetime" class="form-control" id="start_at" name="start_at" value="{{ $new ? Carbon::now() : $item->start_at }}">
        </div>

        <div class="form-group">
            <label for="url">End at:</label>
            <input type="datetime" class="form-control" id="end_at" name="end_at" value="{{ $new ? Carbon::tomorrow() : $item->end_at }}">
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("tempadmin::index") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script>

        // Member name selection

        $(".member-name").each(function () {
            $(this).autocomplete({
                minLength: 3,
                source: "{{ route("api::members") }}",
                select: function (event, ui) {
                    $(this).val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                    $(this).next(".member-id").val(ui.item.id);
                    $(this).parent().find(".member-clear").prop('disabled', false);
                    return false;
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                console.log(ul);
                return $("<li>").append(item.name).appendTo(ul);
            };
        });

        $(".member-clear").each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                $(this).parent().parent().find(".member-name").val("").prop('disabled', false);
                $(this).prop('disabled', true);
                $("#member-id").val("");
            });
        });

    </script>

@endsection