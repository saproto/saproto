@extends('website.layouts.panel')

@section('page-title')
    Password Store
@endsection

@section('panel-title')
    {{ ($password ? 'Edit' : 'Add') }} {{ ($type == 'password' ? 'Password' : 'Secure Note') }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route('passwordstore::add') }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label>Resource description:</label>
            <input class="form-control" type="text" name="description">
        </div>

        <div class="form-group">
            <label>Authorized users:</label>
            <select name="permission_id" class="form-control">
                @foreach(Permission::all() as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                @endforeach
            </select>
        </div>

        <hr>

        @if($type == 'password')

            <input type="hidden" name="type" value="password">

            <div class="form-group">
                <label>Username:</label>
                <input class="form-control" type="text" name="username">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" type="password" name="password">
            </div>

            <div class="form-group">
                <label>Website URI:</label>
                <input class="form-control" type="text" name="url">
            </div>

        @else

            <input type="hidden" name="type" value="note">

            <div class="form-group">

                <textarea class="form-control" name="note" rows="10"
                          placeholder="The content for this note."></textarea>

            </div>

        @endif

        @endsection

        @section('panel-footer')

            <input type="submit" value="Save" class="btn btn-success pull-right">

            <a href="{{ route('passwordstore::index') }}" class="btn btn-default" style="margin-right: 15px;">
                Cancel
            </a>

    </form>

@endsection