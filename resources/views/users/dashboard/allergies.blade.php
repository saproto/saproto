<div class="panel panel-default">
    <div class="panel-heading"><strong name="alergies">Allergy and diet information</strong></div>

    <div class="panel-body">

        <p>
            @if($user->hasDiet())
                {!! $user->renderDiet() !!}
            @else
                <i>You didn't provide any allergy or diet information.</i>
            @endif
        </p>

    </div>

    <div class="panel-footer">

        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">

                <a class="btn btn-success" data-toggle="modal" data-target="#diet-modal">
                    Update your diet and allergy information
                </a>

            </div>
        </div>

    </div>

</div>

<!-- Large modal -->
<div id="diet-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route("user::diet::edit", ["id"=>$user->id]) }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Diet and Allergy Information</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Here you can enter allergies and diets and other info. Everything you enter here will be visible
                        to organizers of activities involving food from the moment you sign up until a week after the
                        activity has ended. The board and website admins will always be able to view this information.
                        Proto will do its best to take your dietary wishes and allergies into account when organsing
                        activities. However, always remain vigilant if eating the wrong thing can have severe
                        consequences.
                    </p>
                    <hr>
                    <textarea class="form-control" name="diet">{{ $user->diet }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
