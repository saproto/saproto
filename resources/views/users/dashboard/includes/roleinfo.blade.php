@if (count($user->roles) > 0)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Roles and permissions
        </div>
        <div class="card-body">
            <p class="card-text">
                You have the following roles and permissions on this site:
            </p>

            @foreach($user->roles as $role)
                <p class="card-text">
                    <i class="fas fa-user-friends fa-fw mr-2"></i> <strong>{{ $role->description }}</strong><br>
                @foreach($role->permissions as $permission)
                    <span class="badge badge-primary badge-pill">
                        <i class="fas fa-plus fa-fw mr-1"></i> {{ $permission->description }}
                    </span><br>
                @endforeach
                </p>
            @endforeach
        </div>
    </div>
@endif