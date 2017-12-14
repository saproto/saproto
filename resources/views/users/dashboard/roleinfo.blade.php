<div class="panel panel-default">
    <div class="panel-heading">
        <strong>You have elevated authorization</strong>
    </div>
    <div class="panel-body">
        @foreach($user->roles as $role)
            <div class="list-group">
                <a class="list-group-item list-group-item-success">
                    <strong>{{ $role->description }}</strong><br>

                </a>
                @foreach($role->permissions as $permission)
                    <a class="list-group-item">
                        {{ $permission->description }}
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="panel-footer">
    </div>
</div>