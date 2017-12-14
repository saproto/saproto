@extends('website.layouts.panel')

@section('page-title')
    Add Alias
@endsection

@section('panel-body')

    <form method="post" action="{{ route("alias::add") }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="alias" name="alias" required>
                <span class="input-group-addon">@ {{ config('proto.emaildomain') }}</span>
            </div>
        </div>

        <hr>

        <label for="destination">Forward to an e-mail address:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="destination" name="destination">
        </div>

        <label for="destination">Or forward to a member:</label>
        <select class="form-control" id="user" name="user">
            <option value="off">Forward to e-mail</option>
            <option value="off" disabled>-- Select a user below --</option>
            @foreach(User::orderBy('name', 'asc')->get() as $user)
                <option value="{{ $user->id }}">{{ $user->name }} (#{{ $user->id }})</option>
            @endforeach
        </select>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("alias::index") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $("#user").on('change', function () {
            $("#destination").val('');
        });

        $("#destination").on('click', function () {
            $("#destination").focus();
            $("#user").val('off');
        })

    </script>

@endsection