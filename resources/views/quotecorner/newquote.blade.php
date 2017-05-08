<form class="form-horizontal" method="post" action="{{ route("quotes::add") }}" id="qq_addquote">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Post your own quote</strong>
        </div>
        <div class="panel-body">
            {{ csrf_field() }}
            <div class="form-group" style="margin-bottom: 0;">
                <div class="col-sm-12">
                    <textarea id="qq_field" rows="4" cols="30" form="addquote" name="quote" placeholder="Quote goes here" style="width: 100%; outline:none; resize:none; border:none; overflow:hidden;" required></textarea>
                </div>
            </div>
        </div>
        <div class="panel-footer">
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

    <script type="text/javascript">
        var textarea = null;
        window.addEventListener("load", function () {
            textarea = window.document.querySelector("textarea");
            textarea.addEventListener("keypress", function () {
                if (textarea.scrollTop != 0) {
                    textarea.style.height = textarea.scrollHeight + "px";
                }
            }, false);
        }, false);
    </script>

@endsection