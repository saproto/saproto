<form class="form-horizontal" method="post" action="{{ route("pastries::add") }}" id="addpastry">
    <h3 style="text-align:center; margin-bottom:20px;">Bake a new Pastry</h3>
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4">
            <div id="user-select">
                <div class="col-sm-9">
                    <input id="member-name-a" class="form-control" type="text" placeholder="Person A" required>
                    <input type="hidden" id="member-id-a" name="user_a" required>
                </div>
                <div class="col-sm-3">
                    <input type="button" class="form-control btn btn-success" id="member-clear-a" value="Clear">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div id="user-select">
                <div class="col-sm-9">
                    <input id="member-name-b" class="form-control" type="text" placeholder="Person B" name="person_b" required>
                    <input type="hidden" id="member-id-b" name="user_b" required>
                </div>
                <div class="col-sm-3">
                    <input type="button" class="form-control btn btn-success" id="member-clear-b" value="Clear">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-control" name="pastry" form="addpastry">
                <option value="0">Cookies</option>
                <option value="1">Cake</option>
                <option value="2">Pie</option>
            </select>
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
        $("#member-name-a").autocomplete({
            minLength: 3,
            source: "{{ route("api::members") }}",
            select: function (event, ui) {
                $("#member-name-a").val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                ;
                $("#member-id-a").val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
        $("#member-clear-a").click(function () {
            $("#member-name-a").val("").prop('disabled', false);
            ;
            $("#member-id-a").val("");
        });
    </script>

    <script>
        $("#member-name-b").autocomplete({
            minLength: 3,
            source: "{{ route("api::members") }}",
            select: function (event, ui) {
                $("#member-name-b").val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                ;
                $("#member-id-b").val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
        $("#member-clear-b").click(function () {
            $("#member-name-b").val("").prop('disabled', false);
            ;
            $("#member-id-b").val("");
        });
    </script>

@endsection