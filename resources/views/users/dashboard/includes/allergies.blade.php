<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Allergies and diet
    </div>

    <div class="card-body">

        <p class="card-text">
            @if($user->hasDiet())
                <em>Your allergies and/or diets are as follows:</em><br>
                {!! $user->renderDiet() !!}
            @else
                <i>No information provided.</i>
            @endif
        </p>

    </div>

    <div class="card-footer">

        <div class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#diet-modal">
            Update
        </div>

    </div>

</div>

<div id="diet-modal" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <form method="post" action="{{ route("user::diet::edit") }}">

            {{ csrf_field() }}

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update allergies and/or diet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        Here you can enter allergies and diets and other info. Everything you enter here will be visible
                        to organizers of activities involving food from the moment you sign up until a week after the
                        activity has ended. The board and website admins will always be able to view this information.
                        Proto will do its best to take your dietary wishes and allergies into account when organsing
                        activities.
                    </p>

                    <p>
                        <strong>
                            However, always remain vigilant if eating the wrong thing can have severe consequences.
                        </strong>
                    </p>

                    <hr>

                    <textarea class="form-control" name="diet">{{ $user->diet }}</textarea>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Save changes</button>
                </div>

            </div>

        </form>

    </div>

</div>
