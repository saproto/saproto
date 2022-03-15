<form class="form-horizontal" method="post"
      action="{{ route("user::admin::update", ["id" => $user->id]) }}">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Update user
        </div>

        <div class="card-body">

            <label>Name</label>
            <input type="text" class="form-control mb-3" id="name" name="name" value="{{ $user->name }}" required>

            <label>Calling name</label>
            <input type="text" class="form-control mb-3" id="calling_name" name="calling_name"
                   value="{{ $user->calling_name }}" required>

            @if($user->completed_profile)
                <label>Birthday</label>
                @include('website.layouts.macros.datetimepicker', [
                    'name' => 'birthdate',
                    'format' => 'date',
                    'placeholder' => strtotime($user->birthdate)
                ])
            @endif

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success btn-block">Update User Account</button>
        </div>

    </div>

</form>