<form class="form-horizontal" method="post" action="{{ route("welcomeMessages::add") }}" id="addmessage">
    <h3 style="text-align:center; margin-bottom:20px;">Set a new welcome message</h3>
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4">
            <div id="user-select">
                <div class="col-sm-9">
                    <input id="member-name" class="form-control" type="text" placeholder="User" required>
                    <input type="hidden" id="member-id" name="user_id" required>
                </div>
                <div class="col-sm-3">
                    <input type="button" class="form-control btn btn-success" id="member-clear" value="Clear">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <input id="message" class="form-control" name="message" placeholder="I'm watching you..." type="text" required>
        </div>
        <div class="col-md-2">
            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

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