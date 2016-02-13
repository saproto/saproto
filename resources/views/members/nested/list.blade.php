<table class="table table-hover">
    <tr>
        <th>User ID</th>
        <th>Name</th>
    </tr>
    @foreach($users as $user)
        <tr class="member" style="cursor: pointer;" user_id="{{ $user->id }}">
            <td>{{ $user->id }}</td>
            <td>@if($user->member) <i class="fa fa-users"></i>@else <i
                        class="fa fa-user"></i> @endif {{ $user->name }}</td>
        </tr>
    @endforeach
</table>

{!! $users->render() !!}