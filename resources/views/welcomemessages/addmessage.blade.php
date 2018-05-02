<form class="form-horizontal" method="post" action="{{ route("welcomeMessages::add") }}" id="addmessage">
    <h3 style="text-align:center; margin-bottom:20px;">Set a new welcome message</h3>
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4">
            <div id="user-select">
                <select class="user-search form-control" name="user_id" required></select>
            </div>
        </div>
        <div class="col-md-6">
            <input id="message" class="form-control" name="message" placeholder="I'm watching you..." type="text"
                   required>
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