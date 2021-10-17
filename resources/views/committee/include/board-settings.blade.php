<form method="post" action="{{ route("committee::update_board") }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Board Settings
        </div>

        <div class="card-body">

            <div class="form-group">
                <label for="board_number">Board Number</label>
                <input id="board_number" type="text" class="form-control" name="board_number" value="{{ settings()->group('board')->get('board_number') }}">
            </div>

            <div class="form-group">
                <label for="secretary">Secretary</label>
                <input id="secretary" type="text" class="form-control" name="secretary" value="{{ settings()->group('board')->get('secretary') }}">
            </div>

            <div class="form-group">
                <label for="treasurer">Treasurer</label>
                <input id="treasurer" type="text" class="form-control" name="treasurer" value="{{ settings()->group('board')->get('treasurer') }}">
            </div>

            <div class="form-group">
                <label for="internal">Internal</label>
                <input id="internal" type="text" class="form-control" name="internal" value="{{ settings()->group('board')->get('internal') }}">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success btn-block">
                Update Board
            </button>
        </div>

    </div>

</form>