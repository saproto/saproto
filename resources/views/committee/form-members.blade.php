<form class="form-horizontal" action="{{ route('committee::membership::add') }}" method="post">

    <div class="panel panel-default">

        {!! csrf_field() !!}

        <div class="panel-heading">
            Add a member to this committee
        </div>

        <div class="panel-body">

            <br>

            <div class="form-group">
                <label for="member-name" class="col-sm-2 control-label">Member</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="member-name" placeholder="John Doe" required>
                    <input type="hidden" id="member-id" name="user_id" required>
                    <input type="hidden" name="committee_id" value="{{ $committee->id }}">
                </div>
                <div class="col-sm-2">
                    <input type="button" class="form-control btn btn-success" id="member-clear" value="Clear">
                </div>
            </div>
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="role" name="role" placeholder="Developer">
                </div>
            </div>
            <div class="form-group">
                <label for="edition" class="col-sm-2 control-label">Edition</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="edition" name="edition" placeholder="3.0">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label for="start" class="col-sm-2 control-label">Since</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control datetime-picker" id="start" name="start" value=""
                           required>
                </div>
            </div>
            <div class="form-group">
                <label for="end" class="col-sm-2 control-label">Till</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control datetime-picker" id="end" name="end" value="">
                </div>
            </div>

        </div>

        <div class="panel-footer clearfix">
            <button type="submit" class="btn btn-success pull-right">
                Add
            </button>
        </div>

    </div>

</form>