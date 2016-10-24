@extends('website.layouts.panel')

@section('head')
    @parent
    <meta http-equiv="refresh" content="{{ Session::get('passwordstore-verify') - time() }}">
@endsection

@section('page-title')
    Password Store
@endsection

@section('panel-title')
    {{ ($password ? 'Edit' : 'Add') }} {{ ($type == 'password' ? 'Password' : 'Secure Note') }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ $password ? route('passwordstore::edit', ['id'=>$password->id]) : route('passwordstore::add') }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label>Resource description:</label>
            <input class="form-control" type="text" name="description" value="{{ $password->description or '' }}">
        </div>

        <div class="form-group">
            <label>Authorized users:</label>
            <select name="permission_id" class="form-control" required>
                @foreach(Permission::all() as $permission)
                    @if(Auth::user()->can($permission->name))
                        <option value="{{ $permission->id }}" {{ ($password && $permission->id == $password->permission_id ? 'selected' : '') }}>
                            {{ $permission->display_name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <hr>

        @if($type == 'password')

            <input type="hidden" name="type" value="password">

            <div class="form-group">
                <label>Username:</label>
                <input class="form-control" type="text" name="username"
                       value="{{ $password ? Crypt::decrypt($password->username) : '' }}">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" type="password" name="password"
                       value="{{ $password ? Crypt::decrypt($password->password) : '' }}">
            </div>

            <div class="form-group">
                <label>Website URI:</label>
                <input class="form-control" type="text" name="url" value="{{ $password->url or '' }}">
            </div>

        @else

            <input type="hidden" name="type" value="note">

            <div class="form-group">

                <textarea class="form-control" name="note" rows="10"
                          placeholder="The content for this note.">{{ $password ? Crypt::decrypt($password->note) : '' }}</textarea>

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