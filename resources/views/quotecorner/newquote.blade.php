<form class="form-horizontal" method="post" action="{{ route("quotes::add") }}">

    {{ csrf_field() }}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Add your own quote
        </div>

        <div class="card-body">
            <textarea class="form-control" rows="4" cols="30" name="quote" required
                      placeholder="With greate quotes come great responsibility"></textarea>
        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success btn-block">
                Submit
            </button>

        </div>

    </div>

</form>